jQuery( function( $ ) {

	'use strict';

	/******************************************************************
	 * Home
	 * @type {{init: SalesPage.init, install: SalesPage.install}}
	 * @since 1.0
	 * @author Goiteens
	 * @date 30.11.2022
	 */
	var SalesPage = {

		/**
		 * Init
		 */
		init: function ()
		{

			this.install  = this.install( this )
			this.prices  = this.prices( this )

		},

		/**
		 * Install
		 */
		install: function()
		{


		},

		/**
		 * Prices
		 */
		prices: function(e)
		{

			/**
			 * Tab Click
			 */
			$( document ).on('click', '.studding-payments_currency-tabs-btn', function (e)
			{

				e.preventDefault()

				let $this = $(this),
					tab = $this.data('tab')

				$this.parent().parent().find('.studding-payments_currency-tabs-btn--active').removeClass('studding-payments_currency-tabs-btn--active')

				$('.studding-payments_price-list').removeClass('active')

				$('[data-prices="' + tab + '"]').addClass('active')



			} )

		},

	}

	SalesPage.init()

});
