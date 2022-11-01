<section class="section conclusion">
  <div class="container">
    <h2 class="section__title conclusion__title"><?php the_field('conclusion_title');?></h2>
  </div>
  <div class="conclusion__wrapper">
    <div class="container">
      <div class="conclusion__content">
        <picture class="conclusion__img-wrapper">
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/python/conclusion/boy_lg.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/python/conclusion/boy_lg@2x.webp 2x
            " type="image/webp" />
          <img srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/python/conclusion/boy_lg.jpg    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/python/conclusion/boy_lg@2x.jpg 2x
            " src="<?php echo get_template_directory_uri(); ?>/assets/images/python/conclusion/boy_lg.jpg"
            class="conclusion__img" alt="<?php the_field('conclusion_img_alt');?>" width="470" height="518" loading="lazy" />
        </picture>
        <div class="conclusion__side">
          <h3 class="text-yellow conclusion__side-title"><?php the_field('descript_title');?></h3>
          <p><?php the_field('conclusion_description');?></p>
          <p class="text-yellow conclusion__side-text"><?php the_field('conclusion_text');?></p>
			<button type="button" class="main-btn conclusion__btn btn-icon main-btn--yellow" data-modal-open><?php the_field('header_button'); ?></button>
        </div>
      </div>
    </div>
  </div>
</section>
