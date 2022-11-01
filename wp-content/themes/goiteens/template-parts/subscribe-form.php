  <div class="modal-subscribe-outer" data-subscribe-outer>
	    <h2 class="modal-title">Підпишись на розсилку, щоб не пропустити актуальні новини </h2>
        <form class="modal-form" id="subscribe_form" novalidate data-subscribe-form>
     
      <div class="modal-group visually-hidden">
        <label class="modal-label">
          <?php the_field('user_name', 'option'); ?> <span class="modal-label-required"> * </span></label
        >
		   <input class="modal-input" type="text" id="subscribe_form_input_name" name="first_name" required=""
                value="Blog user name" data-required="name" />
      </div>

      <div class="modal-group">
        <label class="modal-label">
          <?php the_field('user_email', 'option'); ?>  <span class="modal-label-required"> * </span></label
        >
      <input class="modal-input" type="email" id="subscribe_form_input_email" name="email" required=""
                data-required="email" />
      </div>
      <div class="btn-cont">
        <button class="main-btn subscribe-btn" type="submit"><?php the_field('btn_submit', 'option'); ?> </button>
      </div>
      <div class="modal-term">
        <label class="modal-term-label" for="subscribe-user-policy">
          <input class="subscribe-term-checkbox custom-checkbox" type="checkbox" name="user-policy" value="accept"
                    id="subscribe-user-policy" checked required />
          <span class="custom-checkbox"></span>
         <?php the_field('checkbox_text_start', 'option'); ?> 
          <a
            href="<?php the_field('modal_policy_link', 'option'); ?>"
            target="_blank"
            rel="noopener noreferrer"
            ><?php the_field('policy_link_text', 'option'); ?> </a
          >, <?php the_field('checkbox_text_end', 'option'); ?>
    
        </label>
      </div>
    </form>
    <div class="subscribe-modal-message">
	 <p class="text is-hidden" data-subscribe-text-wait><?php the_field('wait_text', 'option'); ?></p>
      <p class="text is-hidden" data-subscribe-text-success><?php the_field('success_text', 'option'); ?></p>
      <p class="text is-hidden" data-subscribe-text-error><?php the_field('error_text', 'option'); ?></p>
      <div class="subscribe-progress">
        <div class="color"></div>
      </div>
    </div>	  
  </div>
