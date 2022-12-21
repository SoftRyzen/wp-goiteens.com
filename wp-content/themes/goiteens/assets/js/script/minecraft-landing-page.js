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
				// initialSlide:0,
				slidesPerView: 1,
				spaceBetween: 32,
				centeredSlides:true,
				slidesPerGroup:1,
				//TODO This Settings
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				  },
				  pagination: {
					el: ".swiper-pagination",
					dynamicBullets: true,
					clickable: true,
				  },
				//   Responsive breakpoints
				  breakpoints: {
					768: {
					  slidesPerView: 2,
					},
					1280: {
					  slidesPerView: 3,
					}
				},
					
			});
		},

	}

	MinecraftLandingPage.init()
	


});
