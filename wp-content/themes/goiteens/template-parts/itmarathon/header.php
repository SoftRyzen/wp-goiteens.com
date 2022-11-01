<header class="header" id="home">
  <div class="header__main-wrap ">
    <div class="header__top header-js">
      <div class="container">
        <div class="header__wrapper">
          <div class="header__nav-wrapper">
			   <a class="link" href="<?php echo home_url('/'); ?>" target="_blank" rel="nofollow noopener noreferrer" aria-label="<?php the_field('link_area_lab'); ?>" >
            <img class="header__logo-img" src=" <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/logo.svg" alt="<?php the_field('logo_alt'); ?>" width="143" height="37" />
				</a>
			  
           <?php get_template_part( 'template-parts/itmarathon/components/navigation', get_post_type()  ); ?>
			  
            <button type="button" class="mobile-menu-btn" data-menu-btn aria-label="<?php the_field('btn_open_lab'); ?>">
              <svg class="mobile-menu-svg" width="57" height="57">
                <use href="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/sprite.svg#icon-mobile-menu"></use>
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
    <p class="header-cont__start text-label">
        <?php the_field('start_text'); ?> <span class="text-accent header-cont__start--date"><?php the_field('start_date'); ?></span>
      </p>
      <h1 class="header-cont__title"><?php the_field('header_cont_title'); ?></h1>
      <p class="text-label header-cont__subtitle"><?php the_field('header_cont_subtitle'); ?></p>
		<?php $headerList = get_field('header_cont_items');
		if( $headerList ): ?> 
      <ul class="list header-cont__list">
       	<?php foreach( $headerList as $item ): ?>		
        <li class="header-cont__list-item"><?php echo "{$item['text']}"; ?></li>
       <?php endforeach; ?>
      </ul>
		<?php endif; ?>
    </div>
    <div class="header-cont__box-btn">
	<?php  $btnText= get_field('regist_btn');
		$btnStyle="header-cont__btn main-btn--violet";
		$btnDataModal="data-modal-open"
		?>
	 <?php get_template_part( 'template-parts/itmarathon/components/btn', null, ['btnText' => $btnText, 'btnStyle' => $btnStyle, 'btnDataModal' => $btnDataModal ]  ); ?>

    </div>
  </div>
</div>
  </div>
  <div class="header__side">
    <div class="header__img-wrapper">
      <picture>
        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/header/boy_md.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/header/boy_md@2x.webp 2x"
          media="(min-width: 768px)" type="image/webp" />

        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/header/boy_md.png 1x, <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/header/boy_md@2x.png 2x"
          media="(min-width: 768px)" type="image/jpeg" />
        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/header/boy_sm.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/header/boy_sm@2x.webp 2x"
          media="(max-width: 767px)" type="image/webp" />

        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/images/header/boy_sm@2x.png 2x" media="(max-width: 767px)" type="image/jpeg" />
        <img class="header__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/header/boy_sm.png" alt="<?php the_field('img_alt'); ?>" width="320"
          height="391" loading="lazy" />
      </picture>
      <div class="play-btn" data-video-open>
        <svg class="play-btn__svg" width="70" height="70">
          <use href="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/sprite.svg#icon-play-btn"></use>
        </svg>
      </div>
    </div>
  </div>
</header>
 <?php get_template_part( 'template-parts/itmarathon/components/mobile-menu', get_post_type()  ); ?>
 <?php get_template_part( 'template-parts/itmarathon/components/modal-video', get_post_type()  ); ?>
