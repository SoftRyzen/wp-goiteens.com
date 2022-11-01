<section class="section about" id="competition">
    <div class="container about__container">

        <h2 class="about__title section__title-accent text-accent title-shadow"
            data-text="<?php the_field('about_title'); ?>">
            <?php the_field('about_title'); ?>
        </h2>
        <?php $imgList = get_field('about_img_list');
        if( $imgList ): ?>
        <div class="about__img-wrapper">

            <?php foreach( $imgList as $item ): ?>
            <picture>
                <source
                    srcset="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/about/about-<?php echo "{$item['img_id']}"; ?>.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/about/about-<?php echo "{$item['img_id']}"; ?>@2x.webp 2x"
                    type="image/webp" />

                <source
                    srcset="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/about/about-<?php echo "{$item['img_id']}"; ?>.jpg 1x, <?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/about/about-<?php echo "{$item['img_id']}"; ?>@2x.jpg 2x"
                    type="image/jpeg" />
                <img class="about__img"
                    src="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/about/about-<?php echo "{$item['img_id']}"; ?>.jpg"
                    alt="<?php the_field('about_image_alt'); ?>" width="270" height="240" loading="lazy">
            </picture>

            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php $aboutList = get_field('about_list');
        if( $aboutList ): ?>
        <ul class="list about__list">
            <?php foreach( $aboutList as $item ): ?>
            <li class="item"><?php echo "{$item['text']}"; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>


    </div>
</section>