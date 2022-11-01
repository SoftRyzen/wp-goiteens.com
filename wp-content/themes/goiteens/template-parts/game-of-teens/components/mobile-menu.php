<div class="mobile-menu" data-menu>
    <div class="container">
        <a href="#home" class="link menu-link">
            <img class="mobile-menu-logo"
                src="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/logo.svg"
                alt="<?php the_field('logo_alt'); ?>" width="143" height="37" />
        </a>
        <button class="modal-btn-close" type="button" aria-label="<?php the_field('header_menu_btn_aria'); ?>"
            data-menu-close-btn>
            <svg class="modal-btn-close-svg" width="57" height="57">
                <use
                    href="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/sprite.svg#icon-close-menu">
                </use>
            </svg>
        </button>

        <?php get_template_part( 'template-parts/game-of-teens/components/navigation'); ?>
    </div>
</div>