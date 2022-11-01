<div class="backdrop is-hidden" data-modal>
  <div class="modal-outer vacancy-modal-outer">
    <button
      class="btn-close"
      type="button"
      data-modal-close
      aria-label=" <?php the_field('btn_close_aria', 'option'); ?>"
    ></button>
    <img
      class="logo"
      src="<?php echo get_template_directory_uri(); ?>/assets/images/header/logo.svg"
      alt="<?php the_field('logo_alt', 'option'); ?>"
      width="77"
      height="24"
    />
  <div class="form-wrapper is-hidden" data-resume>
	  <?php echo do_shortcode('[contact-form-7 id="3322" title="надіслати резюме" html_class="modal-form vacancies-form"]'); ?>
	  </div>
	  <div class="form-wrapper is-hidden" data-candidate>
	  <?php echo do_shortcode('[contact-form-7 id="3360" title="Порадити кандидата" html_class="modal-form vacancies-form"]'); ?>
		   </div>
  </div>
</div>