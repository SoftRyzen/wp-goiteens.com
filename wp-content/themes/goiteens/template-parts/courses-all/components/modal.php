<div class="backdrop is-hidden" data-modal>
  <div class="modal-outer">
    <button class="btn-close" type="button" data-modal-close aria-label="<?php the_field('btn_close_aria', 'option'); ?>"></button>
    <img class="header__logo-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/logo-black.svg" alt="<?php the_field('logo_alt', 'option'); ?>" width="143"
      height="37" />

    <div class="modal-progress">
      <ul class="list modal-progress-bar">
        <li class="item is-active"><span>1</span></li>
        <li class="item"><span>2</span></li>
        <li class="item"><span><?php the_field('all_modal_done'); ?></span></li>
      </ul>
    </div>

    <h2 class="modal-title"><?php the_field('all_modal_title'); ?></h2>
	  
	  	<?php $dataFormName= "modal";
	  	$dataFormIndex="3";
		  $formStyle="modal-form";
		  $groupStyle="modal-group";
		  $labelStyle="modal-label";
		  $labelSpanStyle="modal-label-span";
		  $inputStyle="modal-input";
		  $selectStyle="modal-input modal-select"
		  
		  
		?>
	 <?php get_template_part( 'template-parts/courses-all/components/form', null, ['dataFormName' => $dataFormName, 'dataFormIndex' => $dataFormIndex, 'formStyle' => $formStyle, 'groupStyle' => $groupStyle, 'labelStyle' => $labelStyle, 'labelSpanStyle' => $labelSpanStyle, 'inputStyle' => $inputStyle, 'selectStyle' => $selectStyle ]  ); ?> 

	  <div class="leeloo"></div>
  </div>
</div>