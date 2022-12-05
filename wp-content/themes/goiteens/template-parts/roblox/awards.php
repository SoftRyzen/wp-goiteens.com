<section class="section awards">
  <div class="container awards__wrapper">
    <h2 class="section-title awards__title"><?php the_field('awards_title'); ?></h2>

    <div class="awards__content">
			  <?php
		$awards_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'awards',
			'category_name'	   => 'roblox',
			'suppress_filters' => false
		);
		$awards_list = get_posts( $awards_section );

		foreach ( $awards_list as $item ) {
			$result = '';
			setup_postdata( $item );
			?>

      <ul class="list grid awards__list">
      
        <li class="grid__item awards__item">
          <picture>
            <source srcset="
                <?php echo get_template_directory_uri(); ?>/assets/images/roblox/awards/awards-<?php echo $item->award_numb_id; ?>.webp    1x,
                <?php echo get_template_directory_uri(); ?>/assets/images/roblox/awards/awards-<?php echo $item->award_numb_id; ?>@2x.webp 2x
              " type="image/webp" />
            <source srcset="./assets/images/roblox/awards/awards-<?php echo $item->award_numb_id; ?>@2x.png 2x" type="image/png" />
            <img class="awards__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/roblox/awards/awards-<?php echo $item->award_numb_id; ?>.png"
              alt="<?php echo $item->award_img_alt; ?>-<?php echo $item->award_title; ?>" width="<?php echo $item->award_img_width; ?>" height="<?php echo $item->award_img_height; ?>" loading="lazy" />
          </picture>

          <h3 class="text-blue awards__item-title"><?php echo $item->award_title; ?></h3>
          <p class="awards__item-sub-title"><?php echo $item->award_sub_title; ?></p>
          <p class="awards__item-text"><?php echo $item->award_description; ?></p>

        </li>
       
      </ul>
			<?php } ?>
		 <button type="button" class="main-btn awards__btn" data-modal-open><?php the_field('roblox_trial_btn'); ?></button>
    </div>
  </div>
</section>