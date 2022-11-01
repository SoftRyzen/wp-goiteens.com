<section class="section step wave-bg">
  <div class="container">
    <div class="step-content">
		<?php  $stepTitle= get_field('step_title'); ?> 
		<?php if($stepTitle):?>
      <h2 class="step-title"><?php echo $stepTitle ;?></h2>
		<?php endif ;?>
<!--       <p class="step-label">{{ step.label }}</p> -->
    	<?php  $btnText= get_field('btn_course_order'); ?> 
	 <?php get_template_part( 'template-parts/python-start/components/btn-wrap', null, ['btnText' => $btnText]  ); ?>
    </div>
  </div>
</section>
