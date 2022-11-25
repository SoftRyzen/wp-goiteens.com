<?php

namespace goiteens\controller;

/**
 * ACF Controller
 **/
class acf {

	/**
	 * Constructor
	 **/
	function __construct() {

		// Custom place to save ACF options
		add_filter( 'acf/settings/save_json', [ $this, 'set_acf_json_save_point']);
		add_filter( 'acf/settings/load_json', [ $this, 'set_acf_json_load_point']);
	}

	// Save json folder
	function set_acf_json_save_point() {

		// update path
		$path = get_stylesheet_directory() . '/app/options';

		// return
		return $path;
	}

	// Load json
	function set_acf_json_load_point() {

		// remove original path (optional)
		unset($paths[0]);

		// append path
		$paths[] = get_stylesheet_directory() . '/app/options';

		// return
		return $paths;
	}

}
