<section class="section-accent projects">
  <div class="container">
    <h2 class="projects__title section-title"><?php the_field('projects_title'); ?></h2>
    <div class="projects__list list">
				  
        <?php $stProjects_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'student_projects',
			'category_name'    => 'roblox',
			'suppress_filters' => false
		);
		$stProjects_list = get_posts( $stProjects_section );
		foreach ( $stProjects_list as $item ) {
			$result = '';
			setup_postdata( $item );		
			
			?>
		      <article class="projects__card card">
        <picture>
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/roblox/projects/<?php echo $item->project_id; ?>.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/roblox/projects/<?php echo $item->project_id; ?>@2x.webp 2x
            " media="(min-width: 1280px)" type="image/webp" />
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/roblox/projects/<?php echo $item->project_id; ?>.jpg    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/roblox/projects/<?php echo $item->project_id; ?>@2x.jpg 2x
            " media="(min-width: 1280px)" type="image/jpeg" />
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/roblox/projects/<?php echo $item->project_id; ?>.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/roblox/projects/<?php echo $item->project_id; ?>@2x.webp 2x
            " type="image/webp" />
          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/roblox/projects/<?php echo $item->project_id; ?>@2x.jpg" type="image/jpeg" />
          <img class="card__pic" src="<?php echo get_template_directory_uri(); ?>/assets/images/roblox/projects/<?php echo $item->project_id; ?>.jpg" alt="<?php echo $item->project_img_alt ; ?>-<?php echo $item->item_title ; ?>" width="<?php echo $item->project_img_width ; ?>" height="<?php echo $item->project_img_height ; ?>" loading="lazy" />
        </picture>

        <h3 class="card__title"><?php echo $item->item_title; ?>
        </h3>
        <p class="card__description"><?php echo $item->item_description; ?></p>

        <a class="main-btn card__link link" href="<?php echo $item->item_link; ?>" target="_blank" rel="noopener nofollow noreferrer">
         <?php the_field('projects_roblox_btn'); ?>
        </a>
      </article>

     <?php } ?>
    </div>
	   <p class="item-title text-green projects__sub-title"><?php the_field('projects_sub_title'); ?></p>
	   <button type="button" class="main-btn how__btn" data-modal-open><?php the_field('roblox_booking_btn'); ?></button>
  </div>
</section>