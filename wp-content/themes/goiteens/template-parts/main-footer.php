<?php
 $footerStyle ="";
 if(is_page_template('templates/tmpl-course-page.php') or is_page_template('templates/tmpl-about-page.php') ) {
    $footerStyle = "transparent" ;
  }

?>
	<footer id="colophon" class="footer <? if( $footerStyle ): echo "{$footerStyle}"; endif?>">
		<div class="container">
    <div class="footer__wrapper">

        <div class="wrapper__logo">
			   <a class="footer__link" href="<?php echo home_url('/'); ?>" aria-label="<?php echo get_field('logo_alt_aria', 'option'); ?>" target="_blank" rel="noopener noreferrer nofollow">
				<img class="footer__logo" src="<?php echo get_template_directory_uri(); ?><?php echo get_field('logo_img', 'option'); ?>" alt="<?php echo get_field('logo_alt_aria', 'option'); ?>" width="143" height="37" />
          		</a>
        </div>
		
		<ul class="list footer__list-lang">
			<li><a class="link footer__link" href="<?php echo get_field('lang_link', 'option'); ?>"><?php echo get_field('lang_text', 'option'); ?></a></li>
			<li><a class="link footer__link" href="<?php echo get_field('two_lang_link', 'option'); ?>"><?php echo get_field('two_lang_text', 'option'); ?></a></li>
		</ul>
		
				<?php 
				$links = get_field('page_links_list', 'option');
				if( $links ): ?>
		<ul class="list footer__list-link">
					<?php foreach ($links as $elem): ?>
			        <?php $link = $elem["list_link"];
					$link_url = $link['url'];
					$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self'; ?>
					
			<li class="item">
   				<a class="link footer__link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" rel="noopener noreferrer nofollow"><?php echo esc_html( $link_title ); ?></a>
			</li>
				<?php endforeach; ?>
		</ul>
				<?php endif; ?> 

			<?php if(!get_locale() == 'pl_PL'):?>
		<?php $phoneList = get_field('phone_list', 'option');
        if( $phoneList ): ?>
		<ul class="list footer__list-tel">
            <?php foreach ($phoneList as $item): ?>
			<li class="item">
              <a class="link footer__link" href="tel:<?php echo "{$item['phone_href']}"; ?>"><?php echo "{$item['phone_text']}"; ?></a>
			</li>
              <?php endforeach; ?>
			</ul>
			 <?php endif; ?>	
	<?php endif	;?>


           


        
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
			

          <a class="link payment__contract" href="<?php get_field('сontract_for_payments') ? the_field('policy_link_pay', 'option') : the_field('policy_link', 'option'); ?>" aria-label="goiteens programs" target="_blank"
                rel="noopener noreferrer nofollow" data-terms="agreements"><?php echo get_field('policy_title', 'option'); ?></a>
			
			<?php if(get_locale() == 'pl_PL' ): ?>
			          <a class="link payment__contract" href="<?php the_field('modal_policy_link', 'option') ; ?>" aria-label="goiteens programs" target="_blank"
                rel="noopener noreferrer nofollow" data-terms="agreements"><?php echo get_field('policy_link_text', 'option'); ?></a>
			<?php endif; ?>
        </div>

    </div>
			<?php if(get_locale() == 'pl_PL'):?>
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