<section class="projects">
  <div class="projects__container">
    <div class="container ">
      <h3 class="projects__title subtitle"><?php the_field('all_projects_title'); ?></h3>

      <ul class="list grid projects__list ">
	          <?php
		$projects_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'student_projects',
			'category_name'         => 'courses-all',
			'suppress_filters' => false
		);
		$projects_list = get_posts( $projects_section );
		foreach ( $projects_list as $item ) {
			$result = '';
			setup_postdata( $item );		
			?>
        <li class="projects__card grid__item">
          <div class="projects__image-wrapper" data-text="<?php echo $item->collaborators_title; ?>">
            <picture>
              <source srcset="
                <?php echo get_template_directory_uri(); ?>/assets/images/courses-all/projects/project-<?php echo $item->project_id; ?>.webp    1x,
                <?php echo get_template_directory_uri(); ?>/assets/images/courses-all/projects/project-<?php echo $item->project_id; ?>@2x.webp 2x
              " type="image/webp" />
              <source srcset="
                <?php echo get_template_directory_uri(); ?>/assets/images/courses-all/projects/project-<?php echo $item->project_id; ?>.jpg    1x,
                <?php echo get_template_directory_uri(); ?>/assets/images/courses-all/projects/project-<?php echo $item->project_id; ?>@2x.jpg 2x
              " type="image/jpeg" />


              <img class="projects__item-image" src="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/projects/project-<?php echo $item->project_id; ?>.jpg"
                alt="<?php the_field('all_projects_alt'); ?>-<?php echo $item->item_title; ?>" width="360" height="260" loading="lazy" />
            </picture>

          </div>

          <h3 class="projects__card-title"><?php echo $item->item_title; ?></h3>
          <p class="projects__card-description"><?php echo $item->item_description; ?></p>
        </li>
        <? } ?>
      </ul>
    </div>
  </div>
</section>