<section class="speakers section">
  <div class="container">
    <h2 class="speakers__title title"><?php the_field('speakers_title'); ?></h2>
    <p class="text-label speakers__description"><?php the_field('speakers_description'); ?></p>
    <div class="speakers-slider-js speakers__list">
		 <?php
		$speakers_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'speakers',
			'suppress_filters' => false
		);
		$speakers_list = get_posts( $speakers_section );

		foreach ( $speakers_list as $item ) {
			$result = '';
			setup_postdata( $item );
			?>

      <div class="speakers__item">
        <div class="speakers__item-wrapper">
          <picture>
            <source srcset="
                <?php echo get_template_directory_uri(); ?>/assets/images/about/speakers/speaker-<?php echo $item->speaker_id; ?>_lg.webp    1x,
                <?php echo get_template_directory_uri(); ?>/assets/images/about/speakers/speaker-<?php echo $item->speaker_id; ?>_lg@2x.webp 2x
              " media="(min-width: 768px)" type="image/webp" />
            <source srcset="
                <?php echo get_template_directory_uri(); ?>/assets/images/about/speakers/speaker-<?php echo $item->speaker_id; ?>_lg.jpg    1x,
                <?php echo get_template_directory_uri(); ?>/assets/images/about/speakers/speaker-<?php echo $item->speaker_id; ?>_lg@2x.jpg 2x
              " media="(min-width: 768px)" type="image/jpeg" />
            <source srcset="
                <?php echo get_template_directory_uri(); ?>/assets/images/about/speakers/speaker-<?php echo $item->speaker_id; ?>_sm.webp    1x,
                <?php echo get_template_directory_uri(); ?>/assets/images/about/speakers/speaker-<?php echo $item->speaker_id; ?>_sm@2x.webp 2x
              " media="(max-width: 767px)" type="image/webp" />
            <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/about/speakers/speaker-<?php echo $item->speaker_id; ?>_sm@2x.jpg 2x" media="(max-width: 767px)"
              type="image/jpeg" />
            <img class="speakers__item-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/about/speakers/speaker-<?php echo $item->speaker_id; ?>_sm.jpg"
              alt="<?php the_field('speakers_alt'); ?>-<?php echo $item->speaker_name; ?>" width="190" height="280" loading="lazy" />
          </picture>
        </div>
        <p class="text-accent speakers__item-title"><?php echo $item->speaker_name; ?></p>
        <p><?php echo $item->speaker_position; ?> <span class="speakers__item-company"> <?php echo $item->speaker_company; ?></span></p>
      </div>
     	<? } ?>
    </div>
  </div>
</section>