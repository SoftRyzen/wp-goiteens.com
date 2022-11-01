<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GoITeens
 */

?>

<header class="header">
  <div class="header__main-wrap">
    <div class="header__top header-js">
      <div class="container">
        <a class="link" href="<?php echo home_url('/'); ?>" target="_blank" rel="nofollow noopener noreferrer" aria-label="<?php the_field('link_area_lab'); ?>" >
          <img class="header__logo-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/frontend-junior/logo.svg" alt="<?php the_field('logo_alt'); ?>" width="143" height="37" />
<!-- 			<img class="header__logo-img" src="<?php echo get_template_directory_uri(); ?><?php echo get_field('logo_img'); ?>" alt="<?php the_field('logo_alt'); ?>" width="143" height="37" /> -->
        </a>
      </div>
    </div>
	  
	  <div class="header-cont header-cont-js">
		<div class="container">
			<div class="header-cont__box-text">
				<p class="text-label header-cont__label"><?php the_field('text_label'); ?></p>
				<p class="text-label header-cont__subtitle"><?php the_field('header_subtitle'); ?></p>
				<h1 class="header-cont__title"><?php the_field('title'); ?></h1>
				<p class="header-cont__description"><?php the_field('header_description'); ?></p>
			</div>
			<div class="header-cont__box-btn">
				 <button type="button" class="main-btn header-cont__btn btn-icon main-btn--violet" data-modal-open><?php the_field('button'); ?></button>

			</div>
		  </div>
	  </div>

	  
  </div>
  <div class="header__side">
    <div class="header__img-wrapper">
      <picture>
        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/frontend-junior/header/boy_lg.webp 1x, ./assets/images/header/boy_lg@2x.webp 2x" media="(max-width: 767px)" type="image/webp" />
        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/frontend-junior/header/boy_lg@2x.png 2x" media="(max-width: 767px)" type="image/png" />
        <img class="header__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/frontend-junior/header/boy_lg.png" alt="<?php the_field('header_img_alt'); ?>" width="570" height="770" loading="lazy" />
      </picture>
    </div>
  </div>
</header>
