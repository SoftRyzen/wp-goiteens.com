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
       <a href="https://goiteens.ua/" target="_blank" rel="noopener nofollow noreferrer" class="link header__link">
          <img class="header__logo" src="<?php echo get_template_directory_uri();?>/assets/images/roblox/logo-black.svg" alt="<?php echo get_field('logo_alt_aria', 'option'); ?>" width="143" height="37" /> </a>
        <div class="header__wrapper">
          <p class="header__label text-upper"><?php the_field('header_label'); ?></p>
            <h1 class="header__title"><?php the_field('header_title'); ?></h1>
             <p class="header__subtitle"><?php the_field('header_subtitle'); ?></p>

       <?php $headerList = get_field('header_list');?>
        <ul class="header__list list">
          <?php foreach ($headerList as $item): ?>
            <li class="header__item">
             <svg class="header__icon" width="18" height="18">
            <use
             href="<?php echo get_template_directory_uri(); ?>/assets/images/roblox/sprite.svg#icon-header"
             ></use>
           </svg>
            <p><?php echo "{$item['item_text']}"; ?></p>
           </li>
           <?php endforeach; ?>
          </ul>
			
           <button type="button" class="main-btn header__btn" data-modal-open>
            <?php the_field('roblox_trial_btn'); ?>
           </button>
         </div>
       </div>
      </header>