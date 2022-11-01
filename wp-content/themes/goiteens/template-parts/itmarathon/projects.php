<section class="section projects" id="projects">
  <div class="projects__wrapper">
    <div class="container wrapper">
      <h2 class="section__title projects__title"><?php the_field('projects_title'); ?></h2>
      <p class="text__description projects__description"><?php the_field('projects_description'); ?></p>
    </div>
  </div>
  <div class="projects__content">
    <div class="container">
      <div class="projects__list projects-slider-js">
               <?php $stProjects_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'student_projects',
			'category_name'    => 'it-marathon',
			'suppress_filters' => false
		);
		$stProjects_list = get_posts( $stProjects_section );
		foreach ( $stProjects_list as $item ) {
			$result = '';
			setup_postdata( $item );		
			
			?>
        <div class="projects__item">
          <div class="projects__img-wrapper">
            <picture>
              <source srcset="
                  <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/projects/project-<?php echo $item->project_id; ?>.webp    1x,
                  <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/projects/project-<?php echo $item->project_id; ?>@2x.webp 2x
                " type="image/webp" />
              <img class="projects__img" srcset="
                  <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/projects/project-<?php echo $item->project_id; ?>.jpg    1x,
                  <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/projects/project-<?php echo $item->project_id; ?>@2x.jpg 2x
                " src="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/projects/project-<?php echo $item->project_id; ?>.jpg" alt="<?php the_field('projects_alt'); ?>-<?php echo $item->item_title; ?>" width="270"
                height="199" loading="lazy" />
            </picture>
          </div>
          <h3 class="section__subtitle text-bold projects__item-title"><?php echo $item->item_title; ?></h3>
          <p class="projects__item-text"><?php echo $item->item_description; ?></p>
        </div>
        <? } ?>
      </div>
    </div>
  </div>
</section>