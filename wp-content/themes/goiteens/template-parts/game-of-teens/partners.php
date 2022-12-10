<section class="section partners" id="partners">
    <div class="container">
        <h2 class="partners__title section__title "> <?php the_field('partners_title'); ?></h2>

        <ul class="list partners__list">
            <?php
            $args = array(
                'numberposts'      => 150,
                'order'            => 'ASC',
                'post_type'        => 'partners',
                'category_name'       => 'game-of-teens',
                'suppress_filters' => false
            );
            $partners_list = get_posts($args);

            foreach ( $partners_list as $item) {
                $result = '';
                setup_postdata($item);
            
               
               
            ?>

            <li class="partners__item">
                <picture>
                    <source
                        srcset="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/partners/<?php echo $item->partner_logo_id; ?>.png 1x, <?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/partners/<?php echo $item->partner_logo_id; ?>@2x.png 2x"
                        type="image/png">
                    <img class="partners__img"
                        src="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/partners/<?php echo $item->partner_logo_id; ?>.png"
                        alt="<?php the_field('partners_img_alt'); ?>-<?php echo $item->partner_name; ?>"
                        width="<?php echo $item->partner_logo_width; ?>"
                        height="<?php echo $item->partner_logo_height; ?>" loading="lazy">
                </picture>
                <h3 class="partners__name "><?php echo $item->partner_name; ?></h3>
                <p><?php echo $item->partner_description; ?></p>
            </li>
            <? } ?>
        </ul>
        <a class="link main-btn main-btn--yellow partners__btn" href="<?php the_field('partners_link'); ?>"
            target="_blank" rel="noopener noreferrer nofollow"><?php the_field('partner_text'); ?></a>

    </div>
</section>