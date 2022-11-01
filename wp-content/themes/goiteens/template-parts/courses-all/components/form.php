<form class="<?php echo $args['formStyle']; ?>" novalidate data-form="<?php echo $args['dataFormName']; ?>" data-form-index="<?php echo $args['dataFormIndex']; ?>">
<div class="input-wrapper">
	<?php $inputsList= get_field('all_modal_inputs');
	  if($inputsList): ?>
       <?php foreach( $inputsList as $item ): ?>	
<!--       <div class="<?php echo $args['groupStyle']; ?>"> -->
       <?php  if($item['select_option']): ?>
	        <?php  if($args['dataFormName']==='modal'): ?>
            <label class="<?php echo $args['labelStyle']; ?> ">
                <span class="<?php echo $args['labelSpanStyle']; ?> "><?php echo "{$item['title']}"; ?></span>
      
                <select class="<?php echo $args['selectStyle']; ?>" name="selected_course"  data-form-select>
                   <?php foreach( $item['select_option'] as $option ): ?>
                  <option value="<?php echo "{$option['value']}"; ?>"><?php echo "{$option['text']}"; ?></option>
                 <?php endforeach; ?>

                </select>

            </label>
	           <?php endif; ?>
	
		  <?php else :?>

        <label class="<?php echo $args['labelStyle']; ?>"> 
          <span class="<?php echo $args['labelSpanStyle']; ?>">  <?php echo "{$item['title']}"; ?>  </span>
          <input class="<?php echo $args['inputStyle']; ?>" type="<?php echo "{$item['type']}"; ?>" data-<?php echo "{$item['id']}"; ?> name="<?php echo "{$item['name']}"; ?>" required=""
          data-required="<?php echo "{$item['required']}"; ?>" data-invalid-message="<?php echo "{$item['warning']}"; ?>" />
              
        </label>
        <?php endif; ?>
<!--       </div> -->
     
	<?php endforeach; ?>
	<?php endif; ?>
</div>
      <div class="btn-cont">
        <button class="main-btn btn" type="submit"><?php the_field('all_modal_btn_submit'); ?></button>
      </div>
	 <?php  if($args['dataFormName']==='modal'): ?>
      <div class="modal-term">
        <label class="modal-term-label" >
          <input class="modal-term-checkbox custom-checkbox" type="checkbox" name="user-policy" value="accept" checked required />
          <span class="custom-checkbox"></span>
          <?php the_field('checkbox_text_start', 'option'); ?> 
          <a href="<?php the_field('modal_policy_link', 'option'); ?>" target="_blank"
            rel="noopener nofollow noreferrer"> <?php the_field('policy_link_text', 'option'); ?></a>, <?php the_field('checkbox_text_end', 'option'); ?>
        </label>
      </div>
	 <?php endif; ?>
    </form>
    <div class="modal-message">
		<p class="text display-hidden" data-text-wait><?php the_field('wait_text', 'option'); ?></p>
        <p class="text display-hidden" data-text-success><?php the_field('success_text', 'option'); ?></p>
        <p class="text display-hidden" data-text-error><?php the_field('error_text', 'option'); ?></p>
      <div class="progress">
        <div class="color"></div>
      </div>
    </div>