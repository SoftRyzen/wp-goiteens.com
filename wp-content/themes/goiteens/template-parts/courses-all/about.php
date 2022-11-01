<section class="section about">
  <div class="container">
    <div class="about-wrapper">
      <div class="about-content">
        <h2 class="section-title about-title"><?php the_field('all_about_title'); ?></h2>
<?php $descriptionList = get_field('all_about__description');
		if( $descriptionList ): ?>
        <?php foreach($descriptionList as $item ): ?>
        <p class="about-description"><?php echo "{$item['text']}"; ?></p>
         <?php endforeach; ?>
		  <?php endif; ?>
      </div>

      <div class="about-video-wrapper">
        <div class="about-video-preview">
          <picture>
            <source
              srcset="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/about/<?php the_field('all_about__img'); ?>.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/courses-all/about/<?php the_field('all_about__img'); ?>@2x.webp 2x"
              type="image/webp" />

            <source
              srcset="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/about/<?php the_field('all_about__img'); ?>.png 1x, <?php echo get_template_directory_uri(); ?>/assets/images/courses-all/about/<?php the_field('all_about__img'); ?>@2x.png 2x"
              type="image/png" />

            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/about/<?php the_field('all_about__img'); ?>.png" width="<?php the_field('all_about_width'); ?>" height="<?php the_field('all_about_height'); ?>"
              alt="<?php the_field('all_about_img_alt'); ?>" class="about-img" loading="lazy" />
          </picture>
          <p class="about-video-title"><?php the_field('all_about__label'); ?></p>
        </div>

        <div class="youtube-video">
			
		<?php $pathTop= get_field('svg_baner_top_sm');
		$heightSm= get_field('svg_baner_sm_height');
		$pathBottom= get_field('svg_baner_bottom_sm')
		?>
	 <?php get_template_part( 'template-parts/courses-all/components/svg', null, ['path' => $pathTop, 'height' => $heightSm ]  ); ?> 
			
          <div class="youtube" data-embed="<?php the_field('header_video_id'); ?>"> <?php get_template_part( 'template-parts/courses-all/components/play' ); ?> </div>
   
	 <?php get_template_part( 'template-parts/courses-all/components/svg', null, ['path' => $pathBottom, 'height' => $heightSm ]  ); ?> 
			

        </div>
      </div>
    </div>
  </div>
</section>