<?php
namespace goiteens\controller;
use goiteens\helper\utils;

/**
 * Widgets Controller
 **/
class widgets {

	/**
	 * Constructor
	 **/
	function __construct() {

		$this->remove_unwanted_widgets();

		// register custom widgets
		utils::autoload_dir( get_template_directory() . '/widgets/', 1, 'widget.php' );

	}

	/**
	 * Disable default WP Widgets
	 */
	function remove_unwanted_widgets() {

		add_action( 'widgets_init', function() {

			$to_disable = [
				'WP_Widget_Pages',
				'WP_Widget_Calendar',
				'WP_Widget_Archives',
				'WP_Widget_Links',
				'WP_Widget_Meta',
				'WP_Widget_Search',
				'WP_Widget_Text',
				'WP_Widget_Categories',
				'WP_Widget_Recent_Posts',
				'WP_Widget_Recent_Comments',
				'WP_Widget_RSS',
				'WP_Widget_Tag_Cloud',
				'WP_Nav_Menu_Widget',
				'WP_Widget_Media_Gallery',
				'WP_Widget_Media_Audio',
				'WP_Widget_Media_Image',
				'WP_Widget_Media_Video',
				'WP_Widget_Custom_HTML',

				// plugins
				'MC4WP_Form_Widget'
			];

			foreach( $to_disable as $widget ) {
				unregister_widget( $widget );
			}

		}, 11);

	}

}

?>