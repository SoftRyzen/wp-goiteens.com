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


 <header class="hero-header section">

  <div class="container hero-header__container">
	     <a class="link hero-header__logo-link" href="<?php echo home_url('/'); ?>" target="_blank" rel="nofollow noopener noreferrer" aria-label="<?php the_field('link_area_lab'); ?>" >
        <img class="hero-header__logo-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/vacancies/logo.svg" alt="<?php the_field('logo_alt'); ?>" width="143" height="37" />
        </a>
    <div class="hero-header__box-text">

      <p class="text-label hero-header__subtitle"><?php the_field('vacancies_header_description'); ?></p>
      <h1 class="hero-header__title"><?php the_field('vacancies_header_title'); ?></h1>
		<?php $headerList = get_field('vacancies_header_text');
		if( $headerList ): ?> 
      <ul class="list hero-header__list">
		    	<?php foreach( $headerList as $item ): ?>	
        <li class="hero-header__text-item"><?php echo "{$item['text']}"; ?></li>
           <?php endforeach; ?>
      </ul>
<?php endif; ?>
    </div>
  </div>

</header>
