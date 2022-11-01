<footer id="colophon" class="footer">
  <div class="container">
    <div class="footer__wrapper">
      <div class="wrapper__top">
        <div class="wrapper__logo">
          <a class="link logo" href="<?php echo home_url('/'); ?>" target="_blank" rel="nofollow noopener noreferrer"
            aria-label="<?php echo get_field('logo_alt_aria', 'option'); ?>">
            <svg class="footer__logo" width="146" height="36">
              <use href="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/sprite.svg#logo-yellow" />
            </svg>
			  <?php $logoDesc = get_field('logo_description', 'option');
		if($logoDesc):?>
		<span class="header__logo-desc"> <?php echo $logoDesc; ?></span>
		<?php endif ;?>
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
								<?php if(get_locale() == 'pl_PL'): ?>
			          <a class="link payment__contract" href="<?php the_field('modal_policy_link', 'option') ; ?>" aria-label="goiteens programs" target="_blank"
                rel="noopener noreferrer nofollow" data-terms="agreements"><?php echo get_field('policy_link_text', 'option'); ?></a>
			<?php endif; ?>
        </div>
			 
	
		 
      </div>		
    </div>
	  
		<?php if(get_locale() == 'pl_PL' || get_locale() == 'en_US' ): ?>
		<div class="address">
		<address class="footer-address">
			<p class="footer-address__text"><?php the_field('address_text', 'option');?></p>
			<?php $address_list = get_field('address_list', 'option');
			 if( $address_list ): ?>
           <ul class="list footer-address__list">
			   <?php foreach ($address_list as $item): ?>
               <li class="footer-address__item">
                   <a class="link footer-address__link"
					  target="_blank"
                       href="<?php echo "{$item['address_link']}"; ?>" rel="noopener noreferrer nofollow">
                        <?php echo "{$item['address_description']}"; ?></a>
               	</li>
			   <?php endforeach; ?>
              </ul>
			<?php endif; ?>
			<p class="footer-address__text"><?php the_field('address_text-nip', 'option');?></p>
			<p class="footer-address__text"><?php the_field('address_text-krs', 'option');?></p>
        </address>	 
		</div>
	<?php endif	;?>
  </div>

	</footer><!-- #colophon -->

