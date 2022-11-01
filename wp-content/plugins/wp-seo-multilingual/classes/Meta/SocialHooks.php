<?php

namespace WPML\WPSEO\Meta;

use WPML\FP\Obj;
use WPML\WPSEO\Utils;

class SocialHooks implements \IWPML_Frontend_Action {

	const OPTION_KEY = 'wpseo_social';

	public function add_hooks() {
		add_action( 'wp', [ $this, 'init' ] );
	}

	public function init() {
		if ( Utils::isFrontPageWithPosts() ) {
			add_filter( 'wpseo_opengraph_title', [ $this, 'translateTitle' ] );
			add_filter( 'wpseo_opengraph_desc', [ $this, 'translateDescription' ] );
		}
	}

	/**
	 * @param string $title
	 *
	 * @return string
	 */
	public function translateTitle( $title ) {
		return self::translate( 'title', $title );
	}

	/**
	 * @param string $description
	 *
	 * @return string
	 */
	public function translateDescription( $description ) {
		return self::translate( 'desc', $description );
	}

	/**
	 * @param string $type
	 * @param string $originalText
	 *
	 * @return string
	 */
	private static function translate( $type, $originalText ) {
		return Obj::propOr( $originalText, 'og_frontpage_' . $type, get_option( self::OPTION_KEY ) );
	}
}
