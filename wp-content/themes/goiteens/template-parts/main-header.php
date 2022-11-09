<header class="header">
  <div class="container">
	<div class="header__logo-container">
    	<a class="header__logo link" href="<?php echo home_url('/'); ?>" aria-label="<?php echo get_field('logo_alt_aria', 'option'); ?>">
        	<img class="header__img" src="<?php echo get_template_directory_uri(); ?><?php echo get_field('logo_img', 'option'); ?>" alt="<?php echo get_field('logo_alt_aria', 'option'); ?>" width="80" 					height="20" />
			<?php if(!(get_locale() == 'pl_PL')):?>
			<span class="header__logo-text">
			 <?php $goiteens_description = get_bloginfo( 'description', 'display' );
				if ( $goiteens_description || is_customize_preview() ) :
			?>
			<?php echo $goiteens_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>
        </span>
			<?php endif ;?>
    	</a>
		 <?php if((get_locale() == 'pl_PL')):?>
			<span class="header__logo-text">
			 <?php $goiteens_description = get_bloginfo( 'description', 'display' );
				if ( $goiteens_description || is_customize_preview() ) :
			?>
			<?php echo $goiteens_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>
        </span>
			<?php endif ;?>
	</div>
    <div class="header__wrapper">
      <button class="hamburger hamburger--collapse" type="button" aria-expanded="false" aria-controls="mobile-menu"
        aria-label=" <?php echo get_field('menu_btn_aria', 'option'); ?>" data-menu-button>
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
      </button>
      <div class="language-select language-select--mobile" style="display: none">
        <select>
          <option value="0">Ukr</option>
          <option value="1">Ru</option>
          <option value="2">Pl</option>
          <option value="3">En</option>
          <option value="4">Tr</option>
          <option value="5">Ukr</option>
        </select>
      </div>
    </div>
    <div class="mobile-menu" id="mobile-menu" data-menu>
			         <?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'container' => 'nav',
					'container_class' => 'navigation',
					'menu_id'        => false,
					'menu_class'      => 'navigation__list list',
				)
			);
			?>

		<?php $header = get_field('header', 'option');?>
<!--		--><?php //if($header['location_href']): ?>
<!--		--><?php //if(!(get_locale() == 'pl_PL')):?>
<!--			<a class="link location"  href="--><?php //echo "{$header['location_href']}"; ?><!--"  target="_blank"-->
<!--          rel="noreferrer noopener nofollow">-->
<!--        <svg width="18" height="18" class="location__icon">-->
<!--          <use href="--><?php //echo get_template_directory_uri(); ?><!--/assets/images/sprite.svg#location"></use>-->
<!--        </svg>-->
<!--        <span>--><?php //echo "{$header['location']}"; ?><!--</span>-->
<!--      </a>-->
<!--			--><?php //endif; ?>
<!--		  -->
<!--		--><?php //endif; ?>

      <a class="contact-tel link" href="tel:<?php echo "{$header['phone_href']}"; ?>"><?php echo "{$header['phone']}"; ?></a>
      <div class="language-select" style="display: none">
        <select>
          <option value="0">Ukr</option>
          <option value="1">Ru</option>
          <option value="2">Pl</option>
          <option value="3">En</option>
          <option value="4">Tr</option>
          <option value="5">Ukr</option>
        </select>
      </div>
    </div>
  </div>
</header>
