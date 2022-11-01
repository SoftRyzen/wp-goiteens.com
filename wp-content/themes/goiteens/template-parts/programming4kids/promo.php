<section class="section promo">
    <div class="container">
        <h2 class="section-title promo__title"><?php the_field('promo_title'); ?></h2>
        <div class="promo__wrapper">
			
			<?php $promoList = get_field('promo_list');?>
		    <ul class="list promo__list">
			<?php foreach ($promoList['promo_item'] as $item): ?>
          <li class="promo__item"><?php echo "{$item['promo_text']}"; ?> 
				</li>
        <?php endforeach; ?>
		  </ul>
			<button type="button" class="main-btn promo__btn" data-modal-open><?php the_field('programming4kids_btn'); ?></button>
            <picture class="promo__img-wrap">
                <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/promo/promo-girl.webp 1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/promo/promo-girl@2x.webp 2x" media="(min-width: 280px)" type="image/webp" />

                <source srcset="  <?php echo get_template_directory_uri(); ?>/assets/programming4kids/images/promo/promo-girl@2x.jpg 2x" media="(min-width: 280px)"
                    type="image/jpeg" />
                <img class="promo__img" src="  <?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/promo/promo-girl.jpg" width="396" height="272"
                    loading="lazy" alt="<?php the_field('promo_img_alt'); ?>" />
            </picture>
        </div>
    </div>
</section>