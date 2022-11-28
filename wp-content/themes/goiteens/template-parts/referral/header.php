<header class="header">
  <div class="container">
    <div class="header__wrapper">
      <a href="<?php echo site_url() ?>" target="_blank" rel="noopener nofollow noreferrer" class="link header__link">
        <img class="header__logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/referral/logo-black.svg" alt="{{page.logo_alt}}" width="143"
          height="37" />
      </a>
<?php $contactsList= get_field('phone_list', 'option');
	  if($contactsList): ?>
      <ul class="header__contacts  list">
        <?php foreach($contactsList as $item): ?>
        <li class="header__contact-item ">
			 <a class="link " href="tel:<?php echo "{$item['phone_href']}"; ?>"><?php echo "{$item['phone_text']}"; ?></a>
		  </li>
        <?php endforeach ;?>
      </ul>
	<?php endif ;?>
		

    </div>

    <div class="header__box">
      <div class="header__content">
        <h1 class="section-title header__title"><?php the_field('referrall_header_title') ;?></h1>
        <p class="header__description"><?php the_field('referrall_header_description') ;?></p>
		<a class="main-btn courses__btn menu-link link header-btn" href="#registration"><?php the_field('referral_reserve_text') ;?></a>
      </div>
    </div>
    <div class="header__about-wrapper">
      <h2 class="header__about-title"><?php the_field('referral_header_about_us') ;?></h2>
		<?php $aboutList= get_field('referral_about_us_list');
	  if($aboutList): ?>
      <ul class="list header__about-list">
        <?php foreach($aboutList as $key=> $item): ?>
        <li class="header__about-item">
          <picture>
            <source srcset="
                <?php echo get_template_directory_uri(); ?>/assets/images/referral/header/about-us-icon-<?php echo $key+1 ;?>.webp    1x,
                <?php echo get_template_directory_uri(); ?>/assets/images/referral/header/about-us-icon-<?php echo $key+1 ;?>@2x.webp 2x
              " type="image/webp" />
            <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/referral/header/about-us-icon-<?php echo $key+1 ;?>@2x.png 2x" type="image/png" />
            <img class="header__about-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/referral/header/about-us-icon-<?php echo $key+1 ;?>.png"
              alt="<?php echo"{$item['img_alt']}";?>" width="<?php echo"{$item['img_width']}";?>" height="<?php echo"{$item['img_height']}" ;?>" loading="lazy" />
          </picture>
        </li>
        <?php endforeach ;?>
      </ul>
	<?php endif ;?>
    </div>
  </div>
</header>
