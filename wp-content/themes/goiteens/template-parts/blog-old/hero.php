<?php

?>
<!-- Hero -->
<section class="hero">

    <!-- container -->
    <div class="container">

        <!-- suptitle -->
        <p class="hero-suptitle">
            <?= _e('Завжди в темі', 'goiteens') ?>
        </p>
        <!-- end suptitle -->

        <!-- title -->
        <?php the_title('<h1 class="hero-title hero-title--large">', '</h1>') ?>
        <!-- end title -->

        <!-- desc -->
        <div class="hero__content">
            <?php the_content(); ?>
        </div>
        <!-- end desc -->

    </div>
    <!-- end container -->

    <picture>
        <!-- WEBP -->
        <source media="(min-width: 1280px)" type="image/webp" srcset="
      <?= get_stylesheet_directory_uri() ?>/assets/blog/images/hero/desktop/hero-image-desktop.webp 1x,
      <?= get_stylesheet_directory_uri() ?>/assets/blog/images/hero/desktop/hero-image-desktop@2x.webp 2x
    " />
        <source media="(min-width: 768px)" type="image/webp" srcset="
      <?= get_stylesheet_directory_uri() ?>/assets/blog/images/hero/tablet/hero--image-tablet.webp 1x,
      <?= get_stylesheet_directory_uri() ?>/assets/blog/images/hero/tablet/hero--image-tablet.webp 2x
    " />
        <!-- PNG (insert "image/jpeg" for JPEG) -->
        <source media="(min-width: 1170px)" type="image/png" srcset="
      <?= get_stylesheet_directory_uri() ?>/assets/blog/images/hero/desktop/hero-image-desktop.png    1x,
      <?= get_stylesheet_directory_uri() ?>/assets/blog/images/hero/desktop/hero-image-desktop@2x.png 2x
    " />
        <img class="hero-image" width="246" height="276" loading="lazy" alt="Хлопчик з рупором"
             src="<?= get_stylesheet_directory_uri() ?>/assets/blog/images/hero/tablet/hero--image-tablet.png"
             srcset="<?= get_stylesheet_directory_uri() ?>/assets/blog/images/hero/tablet/hero--image-tablet.png 2x" />
    </picture>

</section>
<!-- End Hero -->
