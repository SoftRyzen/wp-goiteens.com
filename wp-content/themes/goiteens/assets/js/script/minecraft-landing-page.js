jQuery( function( $ ) {

	'use strict';

	/******************************************************************
	 * Home
	 * @type {{init: MinecraftLandingPage.init, install: MinecraftLandingPage.install}}
	 * @since 1.0
	 * @author GoIteens
	 */
	var MinecraftLandingPage = {

		/**
		 * Init
		 */
		init: function ()
		{

			this.install  = this.install( this )
			this.slider  = this.slider( this )

		},

		/**
		 * Install
		 */
		install: function()
		{



		},

		/**
		 * Slider
		 */
		slider: function()
		{

			const swiper = new Swiper('.swiper', {
				loop: true,
				//TODO This Settings
			});

		},

	}

	MinecraftLandingPage.init()



});
