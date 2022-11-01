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
    <div class="header__wrapper header__wrapper--top">
      <a href="/" class="link header__link" target="_blank" rel="noopener noreferrer nofollow">
        <img class="header__logo" src=" <?php echo get_template_directory_uri();?>/assets/images/programming4kids/logo-black.svg" alt="<?php echo get_field('logo_alt_aria', 'option'); ?>" width="143"
          height="37" />
      </a>
    </div>
    <div class="header__wrapper">
      <p class="header__label"><?php the_field('header_label'); ?></p>
      <h1 class="header__title text-white"><?php the_field('header_title'); ?></h1>
      <p class="header__subtitle"><?php the_field('header_subtitle'); ?></p>

		<?php $headerList = get_field('header_list');?>
		       <ul class="header__list list">
			<?php foreach ($headerList['header_item'] as $item): ?>
          <li class="header__item"> 
			  <svg class="header__icon" width="35" height="25">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/sprite.svg<?php echo "{$item['icon_id']}"; ?>"></use>
          </svg>
			   <p><?php echo "{$item['item_text']}"; ?></p>
				   </li>
        <?php endforeach; ?>
		  </ul>
		
 <button type="button" class="main-btn header__btn" data-modal-open><?php the_field('programming4kids_btn'); ?></button>
    </div>
  </div>
</header>