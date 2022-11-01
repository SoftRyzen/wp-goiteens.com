<section class="section awards">

  <div class="awards__wrapper">
    <div class="container">
      <h2 class="awards__title"><?php the_field('awards_title'); ?></h2>
      <div class="awards__list awards-slider-js">
		
		  <?php $awards_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'awards',
			'category_name'	   => 'frontend',
			'suppress_filters' => false
		);
		$awards_list = get_posts( $awards_section );

		foreach ( $awards_list as $item ) {
			$result = '';
			setup_postdata( $item );
			?>
        <div class="awards__item">
          <div class="awards__item-wrapper">
            <picture>
              <source srcset="
                  <?php echo get_template_directory_uri(); ?>/assets/images/frontend/awards/award<?php echo $item->award_numb_id; ?>_lg.webp    1x,
                  <?php echo get_template_directory_uri(); ?>/assets/images/frontend/awards/award<?php echo $item->award_numb_id; ?>_lg@2x.webp 2x
                " media="(min-width: 320px)" type="image/webp" />

              <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/frontend/awards/award<?php echo $item->award_numb_id; ?>_lg@2x.png 2x" media="(min-width: 320px)"
                type="image/png" />

              <img class="awards__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/frontend/awards/award<?php echo $item->award_numb_id; ?>_lg.png" alt="<?php echo $item->award_img_alt; ?>" width="<?php echo $item->award_img_width; ?>" height="<?php echo $item->award_img_height; ?>" loading="lazy" />
            </picture>
          </div>
          <h3 class="awards__item-title"><?php echo $item->award_title; ?></h3>
          <p class="awards__item-descr"><?php echo $item->award_description; ?></p>
        </div>
       <? } ?>
      </div>
    </div>
  </div>
</section>