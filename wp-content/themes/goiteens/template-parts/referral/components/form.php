 <form class="form__thumb" novalidate data-form="consultation">
    <div class="input-wrapper">
      <?php $inputsList= get_field('referral_form_inputs');
	  if($inputsList): ?>
		<?php foreach($inputsList as $item): ?>
        <label class="form__label"> 
          <span class="form__label-span"><?php echo "{$item['title']}"; ?></span>
          <input class="form__input"  type="<?php echo "{$item['type']}"; ?>" data-<?php echo "{$item['id']}"; ?> name="<?php echo "{$item['name']}"; ?>" required=""
          data-required="<?php echo "{$item['required']}"; ?>" data-invalid-message="<?php echo "{$item['warning']}"; ?>" />
              
        </label>
		<?php endforeach ;?>
		<?php endif ;?>
	</div>
      <div class="btn-cont">
        <button class="main-btn btn header__btn" type="submit"><?php the_field('referral_form_btn_submit'); ?></button>
      </div>
</form>
    <div class="modal-message">
      <p class="text"><?php the_field('referral_form_wait_text'); ?></p>
      <div class="progress">
        <div class="color"></div>
      </div>
    </div>