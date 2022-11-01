<?php

namespace WPML\WPSEO\SlugTranslation;

use WPML\FP\Obj;

class Hooks implements \IWPML_Backend_Action, \IWPML_DIC_Action {

	public function add_hooks() {
		add_action( 'update_option_wpseo_titles', [ $this, 'flushRulesOnBreadcrumbChange' ], 10, 2 );
	}

	/**
	 * @param array $oldValue
	 * @param array $newValue
	 */
	public function flushRulesOnBreadcrumbChange( $oldValue, $newValue ) {
		$getBreadcrumbsSetting = Obj::prop( 'breadcrumbs-enable' );

		if ( $getBreadcrumbsSetting( $oldValue ) !== $getBreadcrumbsSetting( $newValue ) ) {
			add_action( 'shutdown', 'flush_rewrite_rules' );
		}
	}
}
