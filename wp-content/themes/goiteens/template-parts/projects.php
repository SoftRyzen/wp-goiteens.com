<div class="projects">
  <h2 class="projects__title title"><?php the_field('projects_title'); ?></h2>
  <p class="text-label projects__description"><?php the_field('projects_description'); ?></p>
  <div class="projects-slider-js projects__list">
	
	   <?php
		$stProjects_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'student_projects',
			'category_name'         => 'goiteens',
			'suppress_filters' => false
		);
		$stProjects_list = get_posts( $stProjects_section );
		foreach ( $stProjects_list as $item ) {
			$result = '';
			setup_postdata( $item );		
			
			?>
	  
    <div class="projects__item">
      <picture>
        <source srcset="
            <?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_lg.webp    1x,
            <?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_lg@2x.webp 2x
          " media="(min-width: 1280px)" type="image/webp" />
        <source srcset="
            <?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_lg.jpg    1x,
            <?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_lg@2x.jpg 2x
          " media="(min-width: 1280px)" type="image/jpeg" />

        <source srcset="
            <?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_md.webp    1x,
            <?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_md@2x.webp 2x
          " media="(min-width: 768px)" type="image/webp" />
        <source srcset="
            <?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_md.jpg    1x,
            <?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_md@2x.jpg 2x
          " media="(min-width: 768px)" type="image/jpeg" />
        <source srcset="
            <?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_sm.webp    1x,
            <?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_sm@2x.webp 2x
          " media="(max-width: 767px)" type="image/webp" />
        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_sm@2x.jpg" media="(max-width: 767px)"
          type="image/jpeg" />
        <img class="projects__item-image" src="<?php echo get_template_directory_uri(); ?>/assets/images/components/projects/project-<?php echo $item->project_id; ?>_sm.jpg"
          alt="<?php the_field('projects_alt'); ?>-<?php echo $item->item_title; ?>" width="280" height="200" loading="lazy" />
      </picture>
      <div class="projects__item-wrapper">
        <h3 class="text-label projects__item-title"><?php echo $item->item_title; ?></h3>

       <?php if( $item->collaborators_title ): ?>
		  <p class="text-label projects__item-label"><?php echo $item->collaborators_title; ?></p>
		 <?php endif; ?>
		  <?php if( $item->collaborators_list ): ?>
<ul class="list projects__item-list">
<?php echo $item->collaborators_list; ?>
        </ul>
		 <?php endif; ?>
		  <?php if( $item->item_description ): ?>
        <p class="projects__item-description"><?php echo $item->item_description; ?></p>

       <?php endif; ?>
		   <?php if( $item->item_link): ?>
		  <a class="projects__link" target="_blank" href="<?php echo $item->item_link; ?>" rel="noreferrer noopener nofollow">
			  <?php  the_field('projects_link_text'); ?></a>
		   <?php endif; ?>
      </div>
    </div>
	   <?php } ?>

  </div>
</div>