<section class="section" id="registration">
  <div class="container choice-line">
	  <div class="choice-container">
		  <div class="choice-content">
			 <h2 class="section-title"><?php the_field('referral_form_title'); ?></h2>
			 <p class="choice-descr"><?php the_field('referral_form_description'); ?></p>
		  </div>
		  <div class="form choice-form">
			 <?php get_template_part( 'template-parts/referral/components/form'); ?> 
		  </div> 
	  </div>
  </div>
</section>
