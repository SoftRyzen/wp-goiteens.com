<?php
namespace goiteens\controller;

/**
 * Backend Controller
 **/
class backend
{

	/**
	 * Constructor
	 **/
	function __construct()
	{

		// load admin assets
		add_action('admin_enqueue_scripts', [$this, 'load_assets']);

		// add editor style
		$this->add_editor_styles();

	}

	/**
	 * Load admin assets
	 **/
	function load_assets()
	{

		wp_enqueue_style('goiteens-admin', get_template_directory_uri() . '/assets/css/admin.css', false, GoITeens()->config['cache_time']);

		wp_enqueue_script(
			'goiteens-admin',
			get_template_directory_uri() . '/assets/js/admin/admin.min.js',
			['jquery'], GoITeens()->config['cache_time'],
			true
		);

	}

	/**
	 * Add custom editor styles
	 */
	function add_editor_styles()
	{

		add_action('init', function () {
			add_editor_style('assets/css/admin-editor-style.css');
		});

		add_filter('tiny_mce_before_init', function ($mce_init) {
			$mce_init['cache_suffix'] = 'v=' . GoITeens()->config['cache_time'];
			return $mce_init;
		});

	}

}

?>