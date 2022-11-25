<?php
namespace goiteens\controller;

/**
 * Optimization Controller
 **/
class optimization {

	/**
	 * Constructor
	 **/
	function __construct() {

		$this->head_cleanup();

		$this->assets_cleanup();

		$this->disable_trackbacks();

		//$this->disable_rest_api();

		//add_filter( 'script_loader_src', [ $this, 'remove_script_version' ], 15, 1 );
		//add_filter( 'style_loader_src', [ $this, 'remove_script_version' ], 15, 1 );

	}

	/**
	 * Clean head
	 */
	function head_cleanup() {

		remove_action( 'wp_head', 'feed_links_extra', 3 );

		add_action( 'wp_head', 'ob_start', 1, 0 );
		add_action( 'wp_head', function () {
			$pattern = '/.*';
			$pattern .= preg_quote( esc_url( get_feed_link( 'comments_' . get_default_feed() ) ), '/' );
			$pattern .= '.*[\r\n]+/';
			echo preg_replace( $pattern, '', ob_get_clean() );
		}, 3, 0 );

		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
		remove_action( 'wp_head', 'wp_generator' );

		// remove jquery migrate for optimization reasons
		add_filter( 'wp_default_scripts', function( $scripts ) {
			if ( ! is_admin() ) {
				$scripts->remove( 'jquery' );
				$scripts->add( 'jquery', false, ['jquery-core'], '1.10.2' );
			}
		} );

		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		add_filter( 'use_default_gallery_style', '__return_false' );
		add_filter( 'emoji_svg_url', '__return_false' );
		add_filter( 'show_recent_comments_widget_style', '__return_false' );
		add_filter( 'the_generator', '__return_false' );
		add_filter( 'style_loader_tag', [ $this, 'clean_style_tag' ] );
		add_filter( 'get_avatar', [ $this, 'remove_self_closing_tags' ] ); // <img />
		add_filter( 'comment_id_fields', [ $this, 'remove_self_closing_tags' ] ); // <input />
		add_filter( 'post_thumbnail_html', [ $this, 'remove_self_closing_tags' ] ); // <img />
		add_filter( 'get_bloginfo_rss', [ $this, 'remove_default_description' ] );

		add_action( 'init', function() {
			if ( class_exists( 'Vc_Manager' ) ) {
				remove_action( 'wp_head', [ visual_composer(), 'addMetaData']);
			}
		}, 100);

		if( defined( 'WPSEO_VERSION')) {
			add_action( 'wp_head',function() { 
				ob_start(function($o) {
					return preg_replace( '/^\n?<!--.*?[Y]oast.*?-->\n?$/mi','',$o);
				});
			}, ~PHP_INT_MAX);
		}

	}

	/**
	 * Remove unused assets
	 */
	function assets_cleanup() {

		add_action( 'wp_enqueue_scripts', function() {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
		}, 100 );

	}

	/**
	 * Disable trackbacks
	 */
	function disable_trackbacks() {

		add_filter( 'xmlrpc_methods', [ $this, 'filter_xmlrpc_method' ], 10, 1 );
		add_filter( 'wp_headers', [ $this, 'filter_headers' ], 10, 1 );
		add_filter( 'rewrite_rules_array', [ $this, 'filter_rewrites' ] );
		add_filter( 'bloginfo_url', [ $this, 'kill_pingback_url' ], 10, 2 );
		add_action( 'xmlrpc_call', [ $this, 'kill_xmlrpc' ] );

	}

/**
	 * Clean up output of stylesheet <link> tags
	 */
	public function clean_style_tag( $input ) {

		preg_match_all(
			"!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!",
			$input,
			$matches
		);

		if ( empty( $matches[2] ) ) {
			return $input;
		}

		// Only display media if it is meaningful
		$media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
		return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";

	}

	/**
	 * Remove unnecessary self-closing tags
	 */
	public function remove_self_closing_tags( $input ) {
		return str_replace( ' />', '>', $input );
	}

	/**
	 * Don't return the default description in the RSS feed if it hasn't been changed
	 */
	public function remove_default_description( $bloginfo ) {
		$default_tagline = 'Just another WordPress site';
		return ( $bloginfo === $default_tagline ) ? '' : $bloginfo;
	}

	/**
	 * Disable pingback XMLRPC method
	 */
	public function filter_xmlrpc_method( $methods ) {
		unset( $methods['pingback.ping'] );
		return $methods;
	}

	/**
	 * Remove pingback header
	 */
	public function filter_headers( $headers ) {
		if ( isset( $headers['X-Pingback'] ) ) {
			unset( $headers['X-Pingback'] );
		}
		return $headers;
	}

	/**
	 * Kill trackback rewrite rule
	 */
	public function filter_rewrites( $rules ) {
		foreach ( $rules as $rule => $rewrite ) {
			if ( preg_match( '/trackback\/\?\$$/i', $rule ) ) {
				unset( $rules[ $rule ] );
			}
		}
		return $rules;
	}

	/**
	 * Kill bloginfo('pingback_url')
	 */
	public function kill_pingback_url( $output, $show ) {
		if ( $show === 'pingback_url' ) {
			$output = '';
		}
		return $output;
	}

	/**
	 * Disable XMLRPC call
	 */
	public function kill_xmlrpc( $action ) {
		if ( $action === 'pingback.ping' ) {
			wp_die( 'Pingbacks are not supported', 'Not Allowed!', [ 'response' => 403 ] );
		}
	}

	/**
	 * Disable REST API
	 */
	function disable_rest_api() {
		remove_action( 'template_redirect', 'rest_output_link_header', 11);
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10);
		remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd');

		add_filter( 'rest_authentication_errors', function( $access ) {

			// CF7 uses REST APIm skip
			if( strpos( $_SERVER['REQUEST_URI'], 'contact-form-7') !== false) {
        return $access;
    	}

			// disable REST API for not-logged users
			if( !is_user_logged_in() ) {
				$message = apply_filters( 'disable_wp_rest_api_error', __('REST API restricted to authenticated users.', 'shop') );
				return new \WP_Error( 'rest_login_required', $message, ['status' => rest_authorization_required_code()] );
			}

			return $access;

		});
	}

	/**
	 * Remove version query string from all styles and scripts
	 */
	public function remove_script_version( $src ) {
		return $src ? esc_url( remove_query_arg( 'ver', $src ) ) : false;
	}

}

?>
