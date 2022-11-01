<section class="section categories" id="categories">
    <div class="container categories__container">

        <h2 class="categories__title section__title ">
            <?php the_field('categories_title'); ?>
        </h2>
        <?php $categoriesList = get_field('categories_list');
        if( $categoriesList ): ?>
        <ul class="list categories__list">
            <?php foreach( $categoriesList as $index => $item ): ?>
            <li class="categories__item">
                <div class="categories__item-content">
                    <h3 class="categories__item-title item-title"><?php echo "{$item['title']}"; ?></h3>
                    <p><?php echo "{$item['text']}"; ?></p>
                </div>
                <picture class="categories__img">


                    <source
                        srcset="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/categories/categories-<?php echo $index+1; ?>.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/categories/categories-<?php echo $index+1; ?>@2x.webp 2x"
                        type="image/webp" />

                    <source
                        srcset="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/categories/categories-<?php echo $index+1; ?>.jpg 1x, <?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/categories/categories-<?php echo $index+1; ?>@2x.jpg 2x"
                        type="image/jpeg" />



                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/categories/categories-<?php echo $index+1; ?>.jpg"
                        alt="" width="570" height="440" loading="lazy">
                </picture>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>



    </div>
</section>