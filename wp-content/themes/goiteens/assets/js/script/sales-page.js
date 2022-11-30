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
			this.tab  = this.tab( this )

		},

		/**
		 * Install
		 */
		install: function()
		{


		},

		/**
		 * Tab
		 */
		tab: function(e)
		{

			/**
			 * Tab Click
			 */
			$( document ).on('click', '.studding-payments_currency-tabs-btn', function (e)
			{

				e.preventDefault()

				let $this = $(this),
					$tabs = $('.studding-payments_currency-tabs-list-content'),
					$tb = $this.data('tab'),
					btn_active_class = 'studding-payments_currency-tabs-btn--active'

				$this
					.parent()
					.parent()
					.find('.' + btn_active_class)
					.removeClass(btn_active_class)

				$this.addClass(btn_active_class)

				$tabs
					.find('.active')
					.removeClass('active')

				$($tb).addClass('active')

			} )

		},

	}

	SalesPage.init()

});
