<div class="backdrop is-hidden" data-modal>
  <div class="modal">
    <button class="btn-close" type="button" data-modal-close aria-label="<?php the_field('btn_close_aria', 'option'); ?>"></button>
    <div class="modal-content">
      <h2 class="modal-title">
       <?php the_field('modal_title'); ?>
      </h2>
      <p class="modal-description"> <?php the_field('modal_text'); ?></p>
    </div>
    <form class="modal-form" id="register_form" novalidate data-form>
      <div class="modal-group">
        <label class="modal-label"><?php the_field('user_name', 'option'); ?></label>
        <input class="modal-input" type="text" id="register_form_input_name" name="first_name" required=""
          data-required="name" data-invalid-message="<?php the_field('name_invalid', 'option'); ?>" />
      </div>
      <div class="modal-group">
        <label class="modal-label"><?php the_field('user_phone', 'option'); ?></label>
        <input class="modal-input" type="tel" id="register_form_input_tel" name="phone" required=""
          data-required="phone" data-invalid-message="<?php the_field('phone_invalid', 'option'); ?>" />
      </div>
      <div class="modal-group">
        <label class="modal-label"> <?php the_field('user_email', 'option'); ?></label>
        <input class="modal-input" type="email" id="register_form_input_email" name="email" required=""
          data-required="email" data-invalid-message="<?php the_field('email_invalid', 'option'); ?>" />
      </div>
  
      <!-- hidden inputs for utm-tags -->
	  <input type="hidden" name="promo" value="" />
		<input type="hidden" name="ip" value="" />
<!-- 	  <input type="hidden" name="google_id" value="" />
      <input type="hidden" name="utm_source" value="" />
      <input type="hidden" name="utm_medium" value="" />
      <input type="hidden" name="utm_term" value="" />
      <input type="hidden" name="utm_campaign" value="" />
      <input type="hidden" name="utm_content" value="" /> -->
      
      <!-- end hidden inputs for utm-tags -->
      <div class="btn-cont">
        <button class="btn modal-btn order-btn" type="submit">Замовити</button>
      </div>
    </form>
    <div class="modal-message">
      <p class="modal-text"><?php the_field('wait_text', 'option'); ?></p>
      <div class="progress">
        <div class="color"></div>
      </div>
    </div>
  </div>
</div>
