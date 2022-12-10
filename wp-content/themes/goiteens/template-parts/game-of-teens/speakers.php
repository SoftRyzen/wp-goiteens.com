<section class="section speakers ">
    <div class="container">
        <h2 class="speakers__title section__title "><?php the_field('speakers_title'); ?></h2>
        <ul class="list speakers__list">


            <?php
            $args = array(
                'numberposts'      => 150,
                'order'            => 'ASC',
                'post_type'        => 'game_speakers',
                'category_name'       => 'game-of-teens',
                'suppress_filters' => false
            );
            $speakers_list = get_posts($args);

            foreach ($speakers_list as $item) {
                $result = '';
                setup_postdata($item);


            ?>
            <li>
                <picture>
                    <source
                        srcset="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/speakers/<?php echo $item->speaker_id; ?>.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/speakers/<?php echo $item->speaker_id; ?>@2x.webp 2x"
                        type="image/webp">
                    <source
                        srcset="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/speakers/<?php echo $item->speaker_id; ?>.jpg 1x, <?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/speakers/<?php echo $item->speaker_id; ?>@2x.jpg 2x"
                        type="image/jpeg">


                    <img class="speakers__img"
                        src="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/speakers/<?php echo $item->speaker_id; ?>.jpg"
                        alt="<?php echo $item->speaker_name; ?>" width="270" height="388" loading="lazy">
                </picture>




                <h3 class="speakers__name text-accent"><?php echo $item->speaker_name; ?></h3>
                <p><?php echo $item->speaker_position; ?></p>
            </li>
            <? } ?>
        </ul>
        <p class="speakers__title section__title "><?php the_field('video_title'); ?>
        </p>
        <div class="speakers__wrapper">
            <div class="speakers__video youtube-js" data-embed="<?php the_field('video_data'); ?>"
                aria-label="<?php the_field('video_aria_label'); ?>">
            </div>
        </div>
    </div>
</section>