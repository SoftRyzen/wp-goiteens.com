<section class="section result">
  <div class="container">
    <div class="result__container">
      <div class="result__content">
        <h2 class="section__title result__title"><?php the_field('result_title'); ?></h2>
		<?php $resultList = get_field('result_list');
		if( $resultList ): ?> 
        <ul class="list grid result__list">
          	<?php foreach( $resultList as $item ): ?>	
          <li class="grid__item result__item">
            <p class="text__description result__text"><?php echo "{$item['text']}"; ?></p>
          </li>
         <?php endforeach; ?>
        </ul>
		<?php endif; ?>
      </div>
      <div class="result__img">
        <picture>
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/result/girl_lg.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/result/girl_lg@2x.webp 2x
            " type="image/webp" />

          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/result/girl_lg@2x.png 2x" media="(min-width: 768px)" type="image/png" />
          <img class="result__img-picture" src="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/result/girl_lg.png" alt="<?php the_field('result_img_alt'); ?>" 								width="511" height="615" loading="lazy" />
        </picture>
      </div>
    </div>
  </div>
</section>