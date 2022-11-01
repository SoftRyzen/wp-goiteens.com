<?php

namespace WPML\WPSEO\RankMathSEO;

class Loaders {

	/**
	 * @return array
	 */
	public static function get() {
		return array_filter( [
			Sitemap\Hooks::class,
			self::getSitemapLangModeHooks(),
			class_exists( \WooCommerce::class ) ? Compatibility\WooCommerce\Hooks::class : null,
		] );
	}

	private static function getSitemapLangModeHooks() {
		/** @var \SitePress $sitepress */
		global $sitepress;

		return wpml_collect( [
			WPML_LANGUAGE_NEGOTIATION_TYPE_DIRECTORY => Sitemap\LangMode\DirectoryHooks::class,
		] )->get( $sitepress->get_setting( 'language_negotiation_type' ) );
	}
}
