<?php
namespace goiteens\controller;

/**
 * Init Controller
 **/
class init
{

	/**
	 * Constructor
	 **/
	function __construct()
	{

		$this->add_theme_support();
		$this->register_settings();
		$this->register_menus();
		$this->register_cpt();
		$this->register_sidebars();

	}

	/**
	 * Add theme support
	 */
	function add_theme_support()
	{

		add_action('after_setup_theme', function () {
			add_theme_support('automatic-feed-links');
			add_theme_support('title-tag');
			add_theme_support('post-thumbnails');
			add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',]);
			add_theme_support('custom-background', apply_filters('goiteens_custom_background_args', array('default-color' => 'ffffff', 'default-image' => '', )));
			add_theme_support('custom-logo', array('height' => 250, 'width' => 250, 'flex-width' => true, 'flex-height' => true, ));
			add_theme_support('customize-selective-refresh-widgets');

			load_theme_textdomain('wa', get_template_directory() . '/languages');

			$GLOBALS['content_width'] = apply_filters('goiteens_content_width', 640);
		});

	}


	/**
	 * ACF
	 */
	function register_settings()
	{
		// ACF Options Page
		if (function_exists('acf_add_options_page')) {

			acf_add_options_page(
				array(
					'page_title' => 'Theme General Settings',
					'menu_title' => 'Theme Settings',
					'menu_slug' => 'theme-general-settings',
					'capability' => 'edit_posts',
					'redirect' => false
				)
			);

			acf_add_options_page(
				array(
					'page_title' => 'Marketing Settings',
					'menu_title' => 'Marketing Settings',
					'parent_slug' => 'theme-general-settings',
				)
			);

			acf_add_options_sub_page(
				array(
					'page_title' => 'Theme Header Settings',
					'menu_title' => 'Header',
					'parent_slug' => 'theme-general-settings',
				)
			);

			acf_add_options_sub_page(
				array(
					'page_title' => 'Theme Footer Settings',
					'menu_title' => 'Footer',
					'parent_slug' => 'theme-general-settings',
				)
			);

			acf_add_options_sub_page(
				array(
					'page_title' => 'Theme Modal Settings',
					'menu_title' => 'Modal',
					'parent_slug' => 'theme-general-settings',
				)
			);

			acf_add_options_sub_page(
				array(
					'page_title' => 'Theme Single Vacancies Settings',
					'menu_title' => 'Single Vacancies',
					'parent_slug' => 'theme-general-settings',
				)
			);
		}

	}

	/**
	 * Register nav menus
	 */
	function register_menus()
	{

		// register menus
		add_action('init', function () {
			register_nav_menus([
				'menu-1' => __('Primary', 'goiteens'),
			]);
		});

	}

	/**
	 * Register custom post types
	 */
	function register_cpt()
	{

		GoITeens()->model->taxonomies->register_post_types();

	}

	/**
	 * Register sidebars
	 */
	function register_sidebars()
	{

		add_action('widgets_init', function () {

			register_sidebar([
				'name' => esc_html__('Sidebar', 'goiteens'),
				'id' => 'sidebar-1',
				'description' => esc_html__('Add widgets here.', 'goiteens'),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<h2 class="widget-title">',
				'after_title' => '</h2>',
			]);

		});

	}

}

?>