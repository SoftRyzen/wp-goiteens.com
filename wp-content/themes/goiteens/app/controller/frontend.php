<?php
namespace goiteens\controller;

/**
 * Frontend Controller
 **/
class frontend
{

	private $_cache_time;

	/**
	 * Constructor
	 **/
	function __construct()
	{

		$this->_cache_time = GoITeens()->config['cache_time'];

		// header actions
		add_action('wp_head', [$this, 'do_header_actions']);

		// write critical css
		add_filter('wp_enqueue_scripts', [$this, 'write_critical_css'], 1);

		// move jquery to footer
		add_filter('wp_enqueue_scripts', [$this, 'move_jquery']);

		// load assets
		add_action('wp_print_styles', [$this, 'load_scripts'], 15);
		add_action('get_footer', [$this, 'load_styles'], 15);

		// Adds custom classes to the array of body classes.
		add_filter('body_class', [$this, 'custom_body_classes']);

	}

	/**
	 * Header actions
	 */
	function do_header_actions()
	{

		// add site icon
		if (function_exists('has_site_icon') && has_site_icon()) {
			wp_site_icon();
		}

		// Add a pingback url auto-discovery header for single posts, pages, or attachments.
		if (is_singular() && pings_open()) {
			printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
		}

	}

	/**
	 * Critical css
	 */
	function write_critical_css($title_tag_content)
	{

		$critical_stylesheet = get_template_directory() . '/assets/css/critical-css.css';

		if (file_exists($critical_stylesheet)) {

			ob_start();
			readfile($critical_stylesheet);
			$critical_css = ob_get_clean();
			$critical_css = trim(str_replace('/*# sourceMappingURL=critical-css.css.map */', '', $critical_css));

			echo '<style id="critical-css">' . $critical_css . '</style>';

		}

	}


	/**
	 * Move jquery to footer
	 */
	function move_jquery()
	{
		wp_deregister_script('jquery');
		wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), false, NULL, true);
	}

	/**
	 * Load scripts
	 */
	function load_scripts()
	{

		wp_register_script(
			'goiteens-libs',
			get_template_directory_uri() . '/assets/js/libs.min.js',
			false, $this->_cache_time,
			true
		);

		$deps = [
			'jquery',
			'goiteens-libs'
		];

		wp_register_script(
			'goiteens-app',
			get_template_directory_uri() . '/assets/js/app.min.js',
			$deps, $this->_cache_time,
			true
		);

		wp_enqueue_script('goiteens-app');

		wp_localize_script('goiteens-app', 'themeVars', [
			'ajaxurl' => admin_url('admin-ajax.php'),
			'ajaxNonce' => wp_create_nonce('goiteens_ajax_nonce'),
			'siteURL' => site_url('/')
		]);

		// add defer to all scripts
		add_filter('script_loader_tag', function ($tag, $handle) {
			return str_replace(' src', ' defer src', $tag);
		}, 10, 2);

	}

	/**
	 * Load styles
	 */
	function load_styles()
	{

		wp_register_style(
			'goiteens-app',
			get_template_directory_uri() . '/assets/css/app.min.css',
			false, $this->_cache_time
		);

		wp_enqueue_style('goiteens-app');

	}

	/**
	 * Custom body classes
	 */
	function custom_body_classes($classes)
	{
		// Adds a class of hfeed to non-singular pages.
		if (!is_singular()) {
			$classes[] = 'hfeed';
		}

		// Adds a class of no-sidebar when there is no sidebar present.
		if (!is_active_sidebar('sidebar-1')) {
			$classes[] = 'no-sidebar';
		}

		return $classes;
	}
}

?>