<header class="header header-js">


    <div class="container header__container">

        <a href="<?php echo home_url('/'); ?>" target="_blank" rel="noopener noreferrer nofollow"
            class="header__logo link" aria-label="<?php the_field('link_area_lab'); ?>">

            <img class="header__logo-img"
                src="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/logo-black.svg"
                alt="<?php the_field('logo_alt'); ?>" width="143" height="37" />
            <span class="text-label"><?php the_field('header_label'); ?></span>
        </a>


        <?php get_template_part( 'template-parts/game-of-teens/components/navigation'); ?>

        <button type="button" class="mobile-menu-btn" data-menu-btn
            aria-label="<?php the_field('header_menu_btn_aria'); ?>">
            <svg class="mobile-menu-svg" width="57" height="57">
                <use
                    href="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/sprite.svg#icon-mobile-menu">
                </use>
            </svg>
        </button>

    </div>




</header>

<?php get_template_part( 'template-parts/game-of-teens/components/mobile-menu'); ?>