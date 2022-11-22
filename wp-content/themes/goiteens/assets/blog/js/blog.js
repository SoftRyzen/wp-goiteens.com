jQuery( function( $ ) {

	'use strict';

	let paged = 1

	/******************************************************************
	 * Home
	 * @type {{init: Blog.init, install: Blog.install}}
	 * @since 1.0
	 * @author Alex Cherniy
	 * @date 07.11.2022
	 */
	var Blog = {

		/**
		 * Init
		 */
		init: function ()
		{

			this.install  = this.install( this )
			this.wpcf7_form  = this.wpcf7_form( this )

		},

		/**
		 * Install
		 */
		install: function()
		{

			/**
			 * Filters
			 */
			$( document ).on(
				'click',
				'.blogFilterCategoryBtn',
				this.filter_category )

			/**
			 * Load More
			 */
			$( document ).on(
				'click',
				'.blogListBtn',
				this.load_more )

			/**
			 * Form Submit
			 */
			$( document ).on(
				'submit',
				'.wpcf7Submit',
				this.form )

		},

		/**
		 * Load More
		 */
		load_more: function(e)
		{

			let $btn = $(this),
				$container = $('.blogListContainer'),
				$bloglist = $('.blogListPreload')

			$.ajax({
				type: 'POST',
				url: ajax_blog_handle.ajaxurl,
				dataType: 'json',
				data: {
					action: 'blog_load_more',
					paged: paged,
				},
				beforeSend: function()
				{
					$bloglist.addClass('preloader')
				},
				complete: function()
				{
					$bloglist.removeClass('preloader')
				},
				success: function (res)
				{

					if(paged >= res.max)
					{
						$btn.remove()
					}

					$container.append(res.items)

					paged++;

				}
			})

			e.preventDefault()

		},

		/**
		 * Filter Category
		 */
		filter_category: function(e)
		{

			e.preventDefault()

			let $this = $(this),
				url = $( '.blogFilterCategorySelect option:selected' ).val()

			window.location.href = url

		},

		/**
		 * Form Submit
		 */
		form: function(e)
		{

			let $this = $(this),
				$btn = $this.find('[type="submit"]'),
				btn_text = $btn.data('preloader')

			$btn.find('span').addClass('hidden')
			$btn.append('<span class="loaded">' + btn_text + ' <b class="btn__loading"><i>.</i><i>.</i><i>.</i></b></span>')
			$this.find('input,button,select,textarea,checkbox').addClass('disabled')

			//e.preventDefault()

		},

		/**
		 * Form wpcf7
		 */
		wpcf7_form: function(e)
		{

			document.addEventListener('wpcf7submit', function (event)
			{

				let $submit = $('.wpcf7-form').find('[type="submit"]'),
					$form = $('.wpcf7-form')

				$submit.find('.loaded').remove()
				$submit.find('.hidden').removeClass('hidden')
				$submit.removeClass('disabled')
				$form.find('input,button,select,textarea').removeClass('disabled')

			})

		},


	}

	Blog.init()

});
