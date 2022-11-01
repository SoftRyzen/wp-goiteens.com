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
  <div class="header__main-wrap ny-decor">
    <div class="header__top header-js">
      <div class="container">
        <div class="header__wrapper">
          <div class="header__nav-wrapper">
		 <a class="link" href="<?php echo home_url('/'); ?>" target="_blank" rel="nofollow noopener noreferrer" aria-label="<?php the_field('link_area_lab'); ?>" >
          <img class="header__logo-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/python/logo.svg" alt="<?php the_field('logo_alt'); ?>" width="143" height="37" />
        </a>
        
			<?php get_template_part( 'template-parts/python/navigation', get_post_type()  ); ?>
			  
            <button type="button" class="mobile-menu-btn" data-menu-btn aria-label="<?php the_field('btn_open_lab'); ?>">
              <svg class="mobile-menu-svg" width="57" height="57">
                <use href="<?php echo get_template_directory_uri(); ?>/assets/images/python/sprite.svg#icon-mobile-menu"></use>
              </svg>
            </button>
          </div>
			<?php $header = get_field('header', 'option'); ?>
          <a class="header__tel link" href="tel:<?php echo "{$header['phone_href']}"; ?>"><?php echo "{$header['phone']}"; ?></a>
        </div>
      </div>
    </div>
   
	<div class="header-cont header-cont-js">
  <div class="container">
    <div class="header-cont__box-text">
      <p class="text-label header-cont__label"><?php the_field('text_label'); ?></p>
      <p class="text-label header-cont__subtitle"><?php the_field('header_subtitle'); ?></p>
      <h1 class="header-cont__title"><?php the_field('header_title'); ?></h1>
		<?php $headerList = get_field('header_list');
		if( $headerList ): ?> 		
			<ul class="list header-cont__list">
		  	<?php foreach( $headerList as $item ): ?>			
				<li class="header-cont__list-item"><?php echo "{$item['text']}"; ?></li>
        	<?php endforeach; ?>
    		</ul>
		<?php endif; ?>
    </div>
    <div class="header-cont__box-btn">
	<button type="button" class="main-btn header-cont__btn btn-icon main-btn--violet" data-modal-open><?php the_field('header_button'); ?></button>
      <span class="text-notation header-cont__notation"><?php the_field('header_notation'); ?></span>
    </div>
  </div>
</div>	  
	  
  </div>
  <div class="header__side">
    <div class="header__img-wrapper" data-text="<?php the_field('video_label'); ?>">
      <picture>
		  <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/python/header/boy_md.webp 1x,
						  <?php echo get_template_directory_uri(); ?>/assets/images/python/header/boy_md@2x.webp 2x" media="(min-width: 768px)" type="image/webp" />
		  <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/python/header/boy_md.png 1x, 
						  <?php echo get_template_directory_uri(); ?>/assets/images/python/header/boy_md@2x.png 2x" media="(min-width: 768px)" type="image/jpeg" />
		  <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/python/header/boy_sm.webp 1x,
						  <?php echo get_template_directory_uri(); ?>/assets/images/python/header/boy_sm@2x.webp 2x" media="(max-width: 767px)" type="image/webp" />
		  <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/python/header/boy_sm@2x.png 2x" media="(max-width: 767px)" type="image/jpeg" />
		  <img class="header__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/python/header/boy_sm.png" alt="<?php the_field('header_img_alt'); ?>" width="320"
          height="391" loading="lazy" />
      </picture>
      <div class="play-btn" data-video-open>
        <svg class="play-btn__svg" width="70" height="70">
          <use href="<?php echo get_template_directory_uri(); ?>/assets/images/python/sprite.svg#icon-play-btn"></use>
        </svg>
      </div>
    </div>
  </div>
</header>
	<?php get_template_part( 'template-parts/python/mobile-menu', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/modal-video', get_post_type()  ); ?>