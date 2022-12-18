jQuery( function( $ ) {

	'use strict';

	/******************************************************************
	 * Home
	 * @type {{init: CourseChildPage.init, install: CourseChildPage.install}}
	 * @since 1.0
	 * @author Goiteens
	 */
	var CourseChildPage = {

		/**
		 * Init
		 */
		init: function ()
		{

			this.install  = this.install( this )
			this.modal  = this.modal( this )

		},

		/**
		 * Install
		 */
		install: function()
		{


		},

		/**
		 * Modal
		 */
		modal: function(e)
		{

			/**
			 * Go Pay
			 */
			$( document ).on('click', '.lp_noregistration .btn-modal', function (e)
			{

				e.preventDefault()

				let $this = $(this)

				$.ajax({
					type: 'POST',
					url: ajax_goiteens_course_handle.ajaxurl,
					dataType: 'json',
					data: {
						action: ajax_goiteens_course_handle.action,
						data: ajax_goiteens_course_handle,
					},
					beforeSend: function()
					{

					},
					complete: function()
					{

					},
					success: function (response)
					{

						if( response.success === true )
						{
							window.location.href = response.data.url;
						}else{
							$('.modal-message').html(ajax_goiteens_course_handle.messages.error_invoice)
						}

					}
				})


			} )

		},

	}

	CourseChildPage.init()


});
