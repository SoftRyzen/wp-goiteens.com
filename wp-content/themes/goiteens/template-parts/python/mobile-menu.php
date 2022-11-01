<div class="mobile-menu" data-menu>
  <div class="container">
    <a href="#home" class="link menu-link">
      <img class="mobile-menu-logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/python/logo.svg" alt="<?php the_field('logo_alt'); ?>" width="143" height="37" />
    </a>
    <button class="modal-btn-close" type="button" aria-label="<?php the_field('btn_close_lab'); ?>" data-menu-close-btn >
      <svg class="modal-btn-close-svg" width="57" height="57">
        <use href="<?php echo get_template_directory_uri(); ?>/assets/images/python/sprite.svg#icon-close-menu"></use>
      </svg>
    </button>

    <?php get_template_part( 'template-parts/python/navigation', get_post_type()  ); ?>
  </div>
</div>
