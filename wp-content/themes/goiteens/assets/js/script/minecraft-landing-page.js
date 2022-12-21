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

			 const swiper = new Swiper('.minecraftSwiperReviews .swiper', {
				loop: true,
				slidesPerView: 1,
				spaceBetween: 32,
				//centeredSlides:true,
				//slidesPerGroup:1,
				navigation: {
					nextEl: '.minecraftSwiperReviews .swiper-button-next',
					prevEl: '.minecraftSwiperReviews .swiper-button-prev',
				  },
				  pagination: {
					el: ".minecraftSwiperReviews .swiper-pagination",
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
