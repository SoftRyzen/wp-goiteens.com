<section class="section portfolio">
    <div class="container">
        <div class="grid portfolio__wrapper">
            <div class="grid__item portfolio__img-wrap double-border">
                <picture>
                    <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/design/portfolio/mobile.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/design/portfolio/mobile@2x.webp 2x
            " type="image/webp" />
                    <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/design/portfolio/mobile@2x.jpg 2x" type="image/jpeg" />
                    <img class="portfolio__img portfolio__img-mobile" src="<?php echo get_template_directory_uri(); ?>/assets/images/design/portfolio/mobile.jpg"
                        alt="<?php the_field('mob_img_alt'); ?>" width="300" height="363" loading="lazy" />
                </picture>
                <picture>
                    <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/design/portfolio/laptop.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/design/portfolio/laptop@2x.webp 2x
            " type="image/webp" />
                    <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/design/portfolio/laptop@2x.jpg 2x" type="image/jpeg" />
                    <img class="portfolio__img portfolio__img-laptop" src="<?php echo get_template_directory_uri(); ?>/assets/images/design/portfolio/laptop.jpg"
                        alt="<?php the_field('laptop_img_alt'); ?>" width="362" height="416" loading="lazy" />
                </picture>
            </div>
            <p class="grid__item text-upper portfolio__text"><?php the_field('portfolio_text'); ?></p>
        </div>
    </div>
</section>