<?php

namespace WPML\WPSEO;

class Loaders {

	/**
	 * @param string $wpSeoVersion
	 *
	 * @return array
	 */
	public static function get( $wpSeoVersion ) {
		$factories = [
			\WPML_WPSEO_Main_Factory::class,
			\WPML\WPSEO\PrimaryCategory\Hooks::class,
		];

		if ( defined( 'WPML_ST_VERSION' ) ) {
			$factories = array_merge(
				$factories,
				[
					\WPML\WPSEO\SlugTranslation\Hooks::class,
				]
			);
		}

		if ( version_compare( $wpSeoVersion, '14', '>=' ) ) {
			$factories = array_merge(
				$factories,
				[
					\WPML\WPSEO\Presentation\Hooks::class,
					\WPML\WPSEO\Meta\SocialHooks::class,
				]
			);
		}

		return $factories;
	}
}