<section class="section statistics wave-bg">
  <div class="container">
    <div class="statistics-content">
      <h2 class="statistics-title"><?php the_field('statistics_title'); ?></h2>
      <p class="statistics-description text-accent"><?php the_field('statistics_description'); ?></p>
		<?php  $btnText= get_field('btn_course_want'); ?> 
	 <?php get_template_part( 'template-parts/python-start/components/btn-wrap', null, ['btnText' => $btnText]  ); ?>
    </div>
  </div>
</section>

