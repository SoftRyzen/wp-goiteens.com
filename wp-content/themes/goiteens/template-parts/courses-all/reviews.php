<section class="section reviews">
  <div class="container">
    <h2 class="section-title reviews__title">
      <?php the_field('all_reviews_title') ;?> 

    </h2>

    <ul class="list reviews__list grid reviews-js">
		 <?php
		$parentsReviews = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'parent_review',
			'category_name'    => 'courses-all',
			'suppress_filters' => false
		);
		$parentsReviews_list = get_posts( $parentsReviews );
		foreach ( $parentsReviews_list as $item ) {
			$result = '';
			setup_postdata( $item );
			?>

      <li class="reviews__item grid__item">
        <div class="youtube-video">
			<div class="reviews__banner-wrap">
          <p class="reviews__item-name"><?php echo $item->parents_name; ?></p>
			
		<?php $pathTop= get_field('svg_baner_top');
		$height= get_field('svg_baner_height');
		$pathBottom= get_field('svg_baner_bottom')
		?>
			<?php get_template_part( 'template-parts/courses-all/components/svg', null, ['path' => $pathTop, 'height' => $height ]  ); ?> 
			</div>
           <?php if($item->parents_video_id):?>
          <div class="youtube" data-embed="<?php echo $item->parents_video_id; ?>"><?php get_template_part( 'template-parts/courses-all/components/play' ); ?></div>
           <?php else :?>
          <p class="reviews__item-description">
            <span class="reviews__item-text"><?php echo $item->parents_description; ?></span>
          </p>
           <?php endif; ?>
          <?php get_template_part( 'template-parts/courses-all/components/svg', null, ['path' => $pathBottom, 'height' => $height ]  ); ?> 
        </div>

      </li>
     <?php } ?>
    </ul>
	  
    <button type="button" class="reviews__btn main-btn  main-btn--violet " id="showMore"><?php the_field('all_review_btn') ;?></button>
  </div>
</section>