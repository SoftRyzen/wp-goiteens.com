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


	}

	Blog.init()

});
