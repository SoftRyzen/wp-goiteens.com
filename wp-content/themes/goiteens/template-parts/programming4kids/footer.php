<footer id="colophon" class="footer">
  <div class="container">
    <div class="footer__wrapper">

      <div class="wrapper__logo">
        <a href="/" class="link footer__logo" target="_blank" rel="noopener noreferrer nofollow">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/logo-black.svg" alt="<?php echo get_field('logo_alt_aria', 'option'); ?>" width="143" height="37" />
        </a>
      </div>
  <a class="link footer__courses" href="<?php echo home_url(get_field('course_link', 'option')); ?>" aria-label="goiteens programs"
            target="_blank" rel="noopener noreferrer nofollow"><?php echo get_field('course_text', 'option'); ?></a>

<!-- 	    <a class="footer__tel link" href="tel:<?php echo get_field('phone_href'); ?>"><?php echo get_field('phone_text'); ?></a>  -->
				<?php $phoneList = get_field('phone_list', 'option');
        if( $phoneList ): ?>
		<ul class="list footer__list-tel">
            <?php foreach ($phoneList as $item): ?>
			<li class="item">
              <a class="link footer__tel" href="tel:<?php echo "{$item['phone_href']}"; ?>"><?php echo "{$item['phone_text']}"; ?></a>
			</li>
              <?php endforeach; ?>
			</ul>
			 <?php endif; ?>	
	  
     <?php $socialList = get_field('socials_list', 'option');
 if( $socialList ): ?>
<ul class="list social__list">
<?php foreach ($socialList as $item): ?>
			  
  <li class="social__item">
    <a
      class="social__link"
      href="<?php echo "{$item['social_link']}"; ?>"
      aria-label="<?php echo "{$item['social_id']}"; ?>"
      target="_blank"
      rel="noopener noreferrer nofollow"
    >
      <svg class="social__svg" width="32"  height="32">
        <use href="<?php echo get_template_directory_uri(); ?>/assets/images/footer/socials.svg<?php echo "{$item['svg_id']}"; ?>"></use>
      </svg>
    </a>
  </li>
<?php endforeach; ?>
</ul>
<?php endif; ?>


        <div class="payment">
          <div class="payment__cards">
            <svg class="payment__svg" width="34" height="34">
              <use href="<?php echo get_template_directory_uri(); ?>/assets/images/footer/socials.svg#visa"></use>
            </svg>
            <svg class="payment__svg" width="34" height="34">
              <use href="<?php echo get_template_directory_uri(); ?>/assets/images/footer/socials.svg#mastercard"></use>
            </svg>
          </div>
          <a class="link payment__contract" href="<?php echo the_field('policy_link', 'option'); ?>" aria-label="goiteens programs" target="_blank"
                rel="noopener noreferrer nofollow" data-terms="agreements"><?php echo get_field('policy_title', 'option'); ?></a>
        </div>
      </div>
    </div>
  </div>

  </div>
</footer><!-- #colophon -->

