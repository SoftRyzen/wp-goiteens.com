<section class="section project wave-bg">
  <div class="container">
    <div class="project-content">
      <h2 class="section-title"><?php the_field('project_title'); ?></h2>
		
	<?php if(get_the_ID() == 6489):?>
     <picture class="project-img-wrap">
       <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/fe-start/project/project-img.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/fe-start/project/project-img@2x.webp 2x "
          type="image/webp" />
        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/fe-start/project/project-img.png 1x, <?php echo get_template_directory_uri(); ?>/assets/images/fe-start/project/project-img@2x.png 2x "
          type="image/png" />
        <img class="project-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/fe-start/project/project-img.png" alt="фото проекту" width="470"
          height="382" />
      </picture>
	  <?php endif ;?>
		
      <p class="project-description"><?php the_field('project_description'); ?></p>
      <?php  $btnText= get_field('btn_course_signup'); ?> 
	 <?php get_template_part( 'template-parts/python-start/components/btn-wrap', null, ['btnText' => $btnText]  ); ?>
    </div>
  </div>
</section>
