<section class="section choice">
  <div class="container choice-container">
    <div class="choice-content">
      <h2 class="section-title choice-title"><?php the_field('all_choice_title'); ?></h2>
      <p class="choice-descr"><?php the_field('all_choice_description'); ?></p>
    </div>

    <div class="form choice-form">
      <div class="about-video-preview">
        <picture>
          <source
            srcset="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/choice/<?php the_field('all_choice_img'); ?>.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/courses-all/choice/<?php the_field('all_choice_img'); ?>@2x.webp 2x"
            type="image/webp" />

          <source
            srcset="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/choice/<?php the_field('all_choice_img'); ?>.png 1x, <?php echo get_template_directory_uri(); ?>/assets/images/courses-all/choice/<?php the_field('all_choice_img'); ?>@2x.png 2x"
            type="image/png" />

          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/choice/<?php the_field('all_choice_img'); ?>.png" width="<?php the_field('all_about_width'); ?>" height="<?php the_field('all_about_height'); ?>"
            alt="<?php the_field('all_about_img_alt'); ?>" class="about-img" loading="lazy" />
        </picture>
        <p class="about-video-title"><?php the_field('all_choice_form_info'); ?></p>
      </div>
		
		 	<?php $dataFormName= "consultation";
		  $dataFormIndex="2";
		  $formStyle="form__thumb";
		  $groupStyle="form__group";
		  $labelStyle="form__label";
		  $labelSpanStyle="form__label-span";
		  $inputStyle="form__input";
		  $selectStyle="form__input";
		  $submitBtnStyle="header__btn"
		  
		?>
	 <?php get_template_part( 'template-parts/courses-all/components/form', null, ['dataFormName' => $dataFormName, 'dataFormIndex' => $dataFormIndex, 'formStyle' => $formStyle, 'groupStyle' => $groupStyle, 'labelStyle' => $labelStyle, 'labelSpanStyle' => $labelSpanStyle, 'inputStyle' => $inputStyle, 'selectStyle' => $selectStyle, 'submitBtnStyle' => $submitBtnStyle ]  ); ?> 

    </div>
  </div>
</section>