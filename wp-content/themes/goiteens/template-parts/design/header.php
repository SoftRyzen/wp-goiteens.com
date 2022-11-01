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
  <div class="header__top">
    <div class="container">
      <div class="header__top-wrapper">
        <a href="<?php echo home_url('/'); ?>" class="link header__logo-link" target="_blank" rel="noopener noreferrer nofollow">
          <img class="header__logo-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/design/logo-black.svg" alt="<?php echo get_field('logo_alt_aria', 'option'); ?>" width="143"
            height="37" />
        </a>
		<button type="button" class="main-btn header__top-btn" data-modal-open >
		  <?php the_field('btn_header_text'); ?>
		</button>
      </div>
    </div>
  </div>
  <div class="header__cont">
    <div class="container">
      <div class="header__cont-wrapper">
        <p class="text-label text-cursive header__label"><?php the_field('header_text_label'); ?></p>
		<?php $startList = get_field('header_start_list');
		if( $startList ): ?>
        <ul class="list header__start-list">
          <?php foreach($startList as $item ): ?>
          <li class="header__start-item">
            <h3 class="item-title text-accent header__start-title"><?php echo "{$item['header_start_title']}"; ?></h3>

			  <p class="header__start-text"><?php if($item['header_start_title']==="старт") {the_field('start_date');} else {echo "{$item['header_start_text']}";} ?></p>
          </li>
          <?php endforeach; ?>
        </ul>
		<?php endif; ?>
        <h1 class="header__title"><?php the_field('header_title'); ?></h1>
		<?php $headerList = get_field('header_list');
		if( $headerList ): ?>
        <ul class="list header__cont-list">
          <?php foreach($headerList as $item ): ?>
          <li class="header__cont-item"><?php echo "{$item['item_text']}"; ?></li>
          <?php endforeach; ?>
        </ul>
		<?php endif; ?>
      </div>

		<?php get_template_part( 'template-parts/design/components/btn-wrapper' ); ?> 
    </div>
  </div>
</header>