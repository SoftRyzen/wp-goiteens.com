<div class="backdrop is-hidden" data-modal>
    <div class="modal-outer">
        <button class="btn-close" type="button" data-modal-close
            aria-label=" <?php the_field('btn_close_aria', 'option'); ?>"></button>
        <img class="logo header__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/header/logo.svg"
            alt="<?php the_field('logo_alt', 'option'); ?>" width="77" height="24" />
        <div class="modal-progress">
            <ul class="list 1 modal-progress-bar">
                <li class="item is-active"><span><?php the_field('first_step', 'option'); ?></span></li>
                <?php
		  if ($args): ?>
                <li class="item"><span><?php echo $args['secondFormStep']; ?></span></li>
                <?php endif; ?>
                <li class="item"><span><?php the_field('done', 'option'); ?></span></li>
            </ul>
        </div>
        <form class="modal-form" id="register_form" novalidate data-form>
            <h2 class="modal-title"><?php the_field('modal_title', 'option'); ?></h2>
            <div class="modal-group">
                <label class="modal-label">
                    <?php the_field('user_name', 'option'); ?> <span class="modal-label-required"> * </span></label>
                <input class="modal-input" type="text" id="register_form_input_name" name="first_name" required=""
                    data-required="name" data-invalid-message=" <?php the_field('name_invalid', 'option'); ?> " />
            </div>
            <div class="modal-group">
                <label class="modal-label">
                    <?php the_field('user_phone', 'option'); ?> <span class="modal-label-required"> * </span></label>
                <input class="modal-input" type="tel" id="register_form_input_tel" name="phone" required=""
                    data-required="phone" data-invalid-message="<?php the_field('phone_invalid', 'option'); ?>" />
            </div>
            <div class="modal-group">
                <label class="modal-label">
                    <?php the_field('user_email', 'option'); ?> <span class="modal-label-required"> * </span></label>
                <input class="modal-input" type="email" id="register_form_input_email" name="email" required=""
                    data-required="email" data-invalid-message="<?php the_field('email_invalid', 'option'); ?>" />
            </div>
            <div class="modal-group">
                <select class="modal-input modal-select " name="correct_whois" id="form__select">
                    <option value="kid"><?php the_field('select_kid', 'option'); ?></option>
                    <option value="parents"><?php the_field('select_parents', 'option'); ?></option>
                </select>
            </div>
            <div class="btn-cont">
                <button class="main-btn btn" type="submit"><?php the_field('btn_submit', 'option'); ?> </button>
            </div>
            <div class="modal-term">
                <label class="modal-term-label" for="user-policy">
                    <input class="modal-term-checkbox custom-checkbox" type="checkbox" name="user-policy" value="accept"
                        id="user-policy" checked required />
                    <span class="custom-checkbox"></span>
                    <?php if(get_locale() == 'pl_PL' ): ?>
                    <?php the_field('checkbox_text_start', 'option'); ?>
                    <a href="<?php the_field('modal_policy_link', 'option'); ?>" target="_blank"
                        rel="noopener noreferrer"><?php the_field('policy_link_text', 'option'); ?> </a> oraz <a
                        href="<?php the_field('policy_link', 'option'); ?>" target="_blank"
                        rel="noopener noreferrer"><?php the_field('policy_title', 'option'); ?> </a>,
                    <?php the_field('checkbox_text_end', 'option'); ?>
                    <?php else :?>
                    <?php the_field('checkbox_text_start', 'option'); ?>
                    <a href="<?php the_field('modal_policy_link', 'option'); ?>" target="_blank"
                        rel="noopener noreferrer"><?php the_field('policy_link_text', 'option'); ?> </a>,
                    <?php the_field('checkbox_text_end', 'option'); ?>
                    <?php endif; ?>



                </label>
            </div>
            <input type="hidden" name="url_theme" value="<?= get_template_directory_uri() ?>" />
        </form>
        <div class="modal-message">
            <p class="text is-hidden" data-text-wait><?php the_field('wait_text', 'option'); ?></p>
            <p class="text is-hidden" data-text-success><?php the_field('success_text', 'option'); ?></p>
            <p class="text is-hidden" data-text-error><?php the_field('error_text', 'option'); ?></p>
            <div class="progress">
                <div class="color"></div>
            </div>
        </div>
        <div class="leeloo">

        </div>
        <?php if ($args): ?>
        <p class="modal-info-text"><?php echo $args['modalInfoText']; ?></p>


        <?php endif; ?>

    </div>
</div>
