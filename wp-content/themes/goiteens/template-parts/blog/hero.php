<?php

?>
<!-- Hero -->
<section class="hero">

    <!-- container -->
    <div class="container">

    <p class="hero-suptitle">
            <?= _e('Завжди в темі', 'goiteens') ?>
        </p>
        <!-- end suptitle -->

        <!-- title -->
        <?php the_title('<h1 class="hero-title hero-title--large">', '</h1>') ?>
        <!-- end title -->


    <div class="swiper">
  <!-- Additional required wrapper -->
  <div class="swiper-wrapper">
    <!-- Slides -->
    <div class="swiper-slide hero-slide">

    <picture>
        <source media="(min-width: 768px)" type="image/webp" srcset="
      <?= get_stylesheet_directory_uri() ?>/assets/images/blog/hero-img-1x.webp 1x,
      <?= get_stylesheet_directory_uri() ?>/assets/images/blog/hero-img-2x.webp 2x
    " />
        <!-- PNG (insert "image/jpeg" for JPEG) -->
        <source media="(min-width: 768px)" type="image/jpeg" srcset="
      <?= get_stylesheet_directory_uri() ?>/assets/images/blog/hero-img-1x.jpg 1x,
      <?= get_stylesheet_directory_uri() ?>/assets/images/blog/hero-img-2x.jpg 2x
    " />
        <img class="hero-image" width="280" height="268" loading="lazy" alt="Учні магічної школи"
             src="<?= get_stylesheet_directory_uri() ?>/assets/images/blog/hero-mob-1x.jpg"
             srcset="<?= get_stylesheet_directory_uri() ?>/assets/images/blog/hero-mob-2x.jpg 2x" />
    </picture>
     
    <div class="hero-box">
      <h2>Безпека дитини в інтернеті: що потрібно знати</h2>
      <span>Тест</span>
      <time></time>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniamLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      <p> Ut enim ad minim veniamLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</p>
      <a href="">Пройти тест</a>
    </div>

    </div>

  
  </div>
  <!-- If we need pagination -->
  <div class="swiper-pagination"></div>

  <!-- If we need navigation buttons -->
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>

</div>
    
    </div>
</section>
<!-- End Hero -->
