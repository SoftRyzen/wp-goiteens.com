<section class="section awards">
  <div class="container">
    <h2 class="section-title awards__title"><?php the_field('awards_title'); ?></h2>
    <div class="awards__wrapper">
      <p class="text-label awards__description"><?php the_field('awards_description'); ?></p>
      <ul class="list grid awards__list">
      <?php
		$awards_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'awards',
			'category_name'	   => 'design',
			'suppress_filters' => false
		);
		$awards_list = get_posts( $awards_section );

		foreach ( $awards_list as $key=>$item ) {
			$result = '';
			setup_postdata( $item );
			?>
        <li class="grid__item awards__item">
          <picture>
            <source srcset="
                 <?php echo get_template_directory_uri(); ?>/assets/images/design/awards/awards-<?php echo $item->award_numb_id; ?>.webp    1x,
                 <?php echo get_template_directory_uri(); ?>/assets/images/design/awards/awards-<?php echo $item->award_numb_id; ?>@2x.webp 2x
              " type="image/webp" />
            <source srcset=" <?php echo get_template_directory_uri(); ?>/assets/images/design/awards/awards-<?php echo $item->award_numb_id; ?>@2x.png 2x" type="image/png" />
            <img class="awards__img" src=" <?php echo get_template_directory_uri(); ?>/assets/images/design/awards/awards-<?php echo $item->award_numb_id; ?>.png"
              alt="<?php echo $item->award_img_alt; ?>" width="120" height="123" loading="lazy" />
          </picture>

          <h3 class="text-accent awards__content-title"><?php echo $item->award_title; ?></h3>
          <p class="awards__text"><?php echo $item->award_description; ?></p>

        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</section>