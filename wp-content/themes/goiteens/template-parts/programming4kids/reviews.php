<section class="section reviews">
  <div class="container">
    <h2 class="section-title">
     <?php the_field('reviews_title'); ?>
      <span class="reviews__title-span"> <?php the_field('reviews_title_span'); ?></span>
    </h2>
    <div class="reviews__list reviews-slider-js">
		
			    <?php
		$stReviews_home_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'parent_review',
			'category_name'	   => 'programming4kids',
			'suppress_filters' => false
		);
		$stReviews_list = get_posts( $stReviews_home_section );
		foreach ( $stReviews_list as $item ) {
			$result = '';
			setup_postdata( $item );
			?>
     
      <div class="reviews__item">
        <div class="reviews__item-top">

      <?php    
			if ($item->parents_img_id): ?> 
        <picture>
            <source srcset="
               <?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/reviews/<?php echo $item->parents_img_id ; ?>.webp    1x,
               <?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/reviews/<?php echo $item->parents_img_id ; ?>@2x.webp 2x
            " media="(min-width: 280px)" type="image/webp" />

            <source srcset=" <?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/reviews/<?php echo $item->parents_img_id ; ?>@2x.jpg 2x" media="(min-width: 280px)"
              type="image/jpeg" />
            <img class="reviews__item-img" src=" <?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/reviews/<?php echo $item->parents_img_id ; ?>.jpg"
              alt="<?php echo $item->reviews_img_alt ; ?><?php echo $item->parents_name ; ?>" width="84" height="84" loading="lazy" />
          </picture>
		 <?php endif; ?>

          <p class="item-title reviews__item-title"><?php echo $item->parents_name ; ?></p>

        </div>

        <p class=" reviews__item-description"><?php echo $item->parents_description ; ?></p>
      </div>
  
		  <?php } ?>
    </div>
  </div>
</section>