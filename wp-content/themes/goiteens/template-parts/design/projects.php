<section class="section projects">
    <div class="container">

        <h2 class="section-title projects__title"><?php the_field('projects_title'); ?></h2>
        <p class="text-label"><?php the_field('projects_description'); ?></p>

        <ul class="list grid projects__list">
              <?php
		$projects_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'student_projects',
			'category_name'         => 'design',
			'suppress_filters' => false
		);
		$projects_list = get_posts( $projects_section );
		foreach ( $projects_list as $item ) {
			$result = '';
			setup_postdata( $item );		
			?>
			
            <li class="grid__item projects__item">
                <div class="projects__item-cont">
                    <div class="projects__img-wrap">
                        <picture>
                            <source
                                srcset="<?php echo get_template_directory_uri(); ?>/assets/images/design/projects/project-<?php echo $item->project_id; ?>.webp 1x, 
										<?php echo 	get_template_directory_uri(); ?>/assets/images/design/projects/project-<?php echo $item->project_id; ?>@2x.webp 2x"
                                type="image/webp" />
                            <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/design/projects/project-<?php echo $item->project_id; ?>@2x.png 2x"
                                type="image/png" />
                            <img class="projects__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/design/projects/project-<?php echo $item->project_id; ?>.png"
                                alt="<?php echo $item->project_img_alt; ?>" width="<?php echo $item->project_img_width; ?>" height="<?php echo $item->project_img_height; ?>"
                                loading="lazy">
                        </picture>
                    </div>
                    <p class="projects__text"><?php echo $item->item_title; ?></p>

				<?php if( $item->item_link ): ?>
                    <a class="link main-btn projects__link" href="<?php echo $item->item_link; ?>" target="_blank"
                        rel="nofollow noopener noreferrer"><?php the_field('projects_link_text'); ?></a>
                 <?php endif; ?>
                </div>

            </li>
             <? } ?>
        </ul>

    </div>
</section>