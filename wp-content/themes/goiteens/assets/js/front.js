(function($){

	class ThemeFront {

		constructor() {

			// this.loadGoogleFonts();

		}

		/**
		 * Load google fonts
		 */
		loadGoogleFonts() {

			WebFont.load({
				google: {
					families: ["Inter:400,700,800", "Roboto+Condensed:400&display=swap"]
				}
			});

		}

	}

	window.ThemeFront = new ThemeFront();

})( window.jQuery );
