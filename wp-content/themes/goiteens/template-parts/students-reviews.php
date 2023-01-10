	<div class="students-reviews">
  <div class="students-review-slider-js students-reviews__list">
	  	  
	    <?php
		$stReviews_home_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'testemonials',
			'category_name'	   => 'goiteens',
			'suppress_filters' => false
		);
		$stReviews_list = get_posts( $stReviews_home_section );
		foreach ( $stReviews_list as $item ) {
			$result = '';
			setup_postdata( $item );
			?>
    <div class="students-reviews__item">
      <div class="students-reviews__item-wrap">
        <picture>
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/components/students-reviews/<?php echo $item->student_img_id; ?>.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/components/students-reviews/<?php echo $item->student_img_id; ?>@2x.webp 2x
            " media="(min-width: 320px)" type="image/webp" />
          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/components/students-reviews/<?php echo $item->student_img_id; ?>@2x.png 2x" media="(min-width: 320px)"
            type="image/png" />
          <img class="students-reviews__item-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/components/students-reviews/<?php echo $item->student_img_id; ?>.png"
            alt="<?php the_field('student_img_alt'); ?> - <?php echo $item->students_name; ?>" width="62" height="62" loading="lazy" />
        </picture>
        <p class="students-reviews__item-descript custom-scroll"><?php echo $item->description_student; ?></p>
        <p class="students-reviews__item-title"><?php echo $item->students_name; ?></p>
        <p class="students-reviews__item-course"><?php echo $item->age_students; ?> </p>
      </div>
    </div>
	  
	  <?php } ?>

  </div>
  <div class="students-reviews__btn-wrapper">
    <button class="students-reviews__prev-btn students-prev-but-js" type="button"
      aria-label="<?php the_field('student_prev_btn'); ?>"></button>
    <button class="students-reviews__next-btn students-next-but-js" type="button"
      aria-label="<?php the_field('student_next_btn'); ?>"></button>
  </div>
</div>