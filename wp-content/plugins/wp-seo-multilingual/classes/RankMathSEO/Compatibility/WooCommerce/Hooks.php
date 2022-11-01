<?php

namespace WPML\WPSEO\RankMathSEO\Compatibility\WooCommerce;

use WPML\Element\API\PostTranslations;
use WPML\FP\Obj;
use function WPML\FP\pipe;

class Hooks implements \IWPML_Frontend_Action {

	public function add_hooks() {
		add_filter( 'rank_math/frontend/breadcrumb/is_using_shop_base', [ $this, 'filterIsUsingShopBase' ] );
	}

	/**
	 * @param bool $isUsingShopBase
	 *
	 * @return bool
	 */
	public function filterIsUsingShopBase( $isUsingShopBase ) {
		if ( $isUsingShopBase ) {
			return $isUsingShopBase;
		}

		$defaultShopSlug = wpml_collect( PostTranslations::get( wc_get_page_id( 'shop' ) ) )
			->filter( Obj::prop( 'original' ) )
			->map( pipe( Obj::prop( 'element_id' ), 'get_post', Obj::prop( 'post_name' ) ) )
			->first();

		return (bool) strstr(
			(string) Obj::prop( 'product_base', wc_get_permalink_structure() ),
			'/' . $defaultShopSlug
		);
	}
}
