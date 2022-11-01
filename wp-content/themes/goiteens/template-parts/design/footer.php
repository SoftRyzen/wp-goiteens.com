<footer id="colophon" class="footer">
  <div class="container">
    <div class="footer__wrapper">
      <div class="wrapper__top">
        <div class="wrapper__logo">
          <a class="link" href="<?php echo home_url('/'); ?>" target="_blank" rel="nofollow noopener noreferrer"
            aria-label="<?php echo get_field('logo_alt_aria', 'option'); ?>">
           
			   <img class="footer__logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/design/logo.svg" alt="<?php echo get_field('logo_alt_aria', 'option'); ?>" width="143" height="37" />
          </a>
        </div>
        <div class="list nav__list">
          <a class="link footer__link" href="<?php echo home_url(get_field('course_link', 'option')); ?>" aria-label="goiteens programs"
            target="_blank" rel="noopener noreferrer nofollow"><?php echo get_field('course_text', 'option'); ?></a>
        </div>
      </div>
	
		 <div class="wrapper__bottom">
        
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

	</footer><!-- #colophon -->
