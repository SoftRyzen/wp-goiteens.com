<section class="section projects">
  <div class="projects__wrapper">
    <div class="container">
      <h2 class="section__title projects__title"><?php the_field('projects_title'); ?></h2>
      <p class="text-label projects__description"><?php the_field('projects_description'); ?></p>
    </div>
  </div>
	<div class="projects__content">
		<div class="container">
			<div class="projects__list projects-slider-js">
				<?php $stProjects_section = array(
					'numberposts'      => 150,
					'order'            => 'ASC',
					'post_type'        => 'student_projects',
					'category_name'    => 'python',
					'suppress_filters' => false
				);
				$stProjects_list = get_posts( $stProjects_section );
				foreach ( $stProjects_list as $item ) {
					$result = '';
					setup_postdata( $item );?>
				<div class="projects__item">
					<div class="projects__img-wrapper">
						<picture>
              <source srcset="
                  <?php echo get_template_directory_uri(); ?>/assets/images/python/projects/project-<?php echo $item->project_id; ?>.webp    1x,
                  <?php echo get_template_directory_uri(); ?>/assets/images/python/projects/project-<?php echo $item->project_id; ?>@2x.webp 2x
                " type="image/webp" />
              <img class="projects__img" srcset="
                  <?php echo get_template_directory_uri(); ?>/assets/images/python/projects/project-<?php echo $item->project_id; ?>.jpg    1x,
                  <?php echo get_template_directory_uri(); ?>/assets/images/python/projects/project-<?php echo $item->project_id; ?>@2x.jpg 2x
                " src="<?php echo get_template_directory_uri(); ?>/assets/images/python/projects/project-<?php echo $item->project_id; ?>.jpg" 
				   alt="<?php the_field('projects_alt'); ?>-<?php echo $item->item_title; ?>" width="{{item.img_width}}" height="{{item.img_height}}" loading="lazy" />
            </picture>
          </div>
          <h3 class="text-bold projects__item-title"><?php echo $item->item_title; ?></h3>
          <p class="projects__item-text"><?php echo $item->item_description; ?></p>
        </div>
         <? } ?>
      </div>
    </div>
  </div>
</section>