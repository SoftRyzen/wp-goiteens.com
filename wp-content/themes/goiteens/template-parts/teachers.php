<?php $minecraft = is_page_template('templates/tmpl-minecraft-page.php') ; ?>
<?php $design = is_page_template('templates/tmpl-design-page.php') ; ?>

<section class="teachers section">
  <div class="container">
    <h2 class="	<?php if($minecraft){echo 'section__title';} elseif($design){echo 'section-title';} else{ echo 'teachers__title title';}  ?> ">
		<?php the_field('teachers_title'); ?>
	  </h2>
    <p class="text-label teachers__description"><?php the_field('teachers_description'); ?></p>
    <div class="teachers-slider-js teachers__list">
       <?php
		$teachers_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'teachers',
			'category_name'         => 'goiteens',
			'suppress_filters' => false
		);
		$teachers_list = get_posts( $teachers_section );

		foreach ( $teachers_list as $item ) {
			$result = '';
			setup_postdata( $item );
			?>
      <div class="teachers__item">
        <picture class="teachers__img-wrap">
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/about/teachers/teacher-<?php echo $item->teacher_img_id; ?>_lg.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/about/teachers/teacher-<?php echo $item->teacher_img_id; ?>_lg@2x.webp 2x
            " media="(min-width: 768px)" type="image/webp" />
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/about/teachers/teacher-<?php echo $item->teacher_img_id; ?>_lg.jpg    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/about/teachers/teacher-<?php echo $item->teacher_img_id; ?>_lg@2x.jpg 2x
            " media="(min-width: 768px)" type="image/jpeg" />
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/about/teachers/teacher-<?php echo $item->teacher_img_id; ?>_sm.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/about/teachers/teacher-<?php echo $item->teacher_img_id; ?>_sm@2x.webp 2x
            " media="(max-width: 767px)" type="image/webp" />
          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/about/teachers/teacher-<?php echo $item->teacher_img_id; ?>_sm@2x.jpg 2x" media="(max-width: 767px)"
            type="image/jpeg" />
          <img class="teachers__item-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/about/teachers/teacher-<?php echo $item->teacher_img_id; ?>_sm.jpg"
            alt="<?php the_field('teachers_alt'); ?>-<?php echo $item->teachers_name; ?>" width="190" height="280" loading="lazy" />
        </picture>
        <p class="text-accent teachers__item-title"><?php echo $item->teachers_name; ?></p>
        <p class="teachers__item-description"><?php echo $item->teachers_description; ?></p>
        <p class="text-accent"><?php echo $item->teachers_position; ?></p>
      </div>
    	<? } ?>
    </div>
  </div>
</section>