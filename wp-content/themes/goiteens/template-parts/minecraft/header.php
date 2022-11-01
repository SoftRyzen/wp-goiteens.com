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
  <div class="container">
    <div class="header__logo-container">
		<a class="header__logo link" href="<?php echo home_url('/'); ?>" target="_blank" rel="nofollow noopener noreferrer"
      aria-label="<?php echo get_field('logo_alt_aria', 'option'); ?>">
      <svg class="header__img" width="142" height="36">
        <use href=" <?php echo get_template_directory_uri(); ?>/assets/images/minecraft/sprite.svg#logo-violet" />
      </svg>
    </a>
	  <?php $logoDesc = get_field('logo_description', 'option');
		if($logoDesc):?>
		<span class="header__logo-desc"> <?php echo $logoDesc; ?></span>
		<?php endif ;?>
	  </div>
    <div class="header__rightside">
		<?php $header = get_field('header', 'option');
  ?>
      <a class="contact-tel link" href="tel:<?php echo "{$header['phone_href']}"; ?>"><?php echo "{$header['phone']}"; ?></a>
      <button class="main-btn main-btn--violet" type="button" data-modal-open>
       <?php the_field('btn_short_text'); ?> 
      </button>
    </div>
  </div>
</header>








