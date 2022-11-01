<?php

namespace WPML\WPSEO\RankMathSEO\Sitemap;

use WPML\Element\API\PostTranslations;
use WPML\FP\Fns;
use WPML\FP\Lst;
use WPML\FP\Maybe;
use WPML\FP\Obj;

class Hooks implements \IWPML_Frontend_Action, \IWPML_DIC_Action {

	/** @var \WPML_URL_Converter $urlConverter */
	private $urlConverter;

	/** @var null|array $secondaryHomeUrls */
	private $secondaryHomesById;

	public function __construct( \WPML_URL_Converter $urlConverter ) {
		$this->urlConverter = $urlConverter;
	}

	public function add_hooks() {
		add_filter( 'rank_math/sitemap/entry', [ $this, 'filterEntry' ], 10, 3 );
	}

	/**
	 * @param array  $url
	 * @param string $type
	 * @param object $object
	 *
	 * @return array|null
	 */
	public function filterEntry( $url, $type, $object ) {
		if ( $url && 'post' === $type ) {
			return $this->replaceHomePageInSecondaryLanguages( $url, $object );
		}

		return $url;
	}

	/**
	 * @param array  $url
	 * @param object $object
	 *
	 * @return array
	 */
	private function replaceHomePageInSecondaryLanguages( $url, $object ) {
		if ( null === $this->secondaryHomesById ) {
			// $getIdAndUrl :: \stdClass -> []
			$getIdAndUrl = function( $translation ) {
				return [
					(int) $translation->element_id,
					$this->urlConverter->convert_url( home_url(), $translation->language_code )
				];
			};

			$this->secondaryHomesById = Maybe::fromNullable( get_option( 'page_on_front' ) )
			                                 ->map( PostTranslations::get() )
			                                 ->map( Fns::reject( Obj::prop( 'original' ) ) )
			                                 ->map( Fns::map( $getIdAndUrl ) )
			                                 ->map( Lst::fromPairs() )
			                                 ->getOrElse( [] );
		}

		return Obj::assoc(
			'loc',
			Obj::propOr(
				$url['loc'],
				(int) Obj::prop( 'ID', $object ),
				$this->secondaryHomesById
			),
			$url
		);
	}
}
