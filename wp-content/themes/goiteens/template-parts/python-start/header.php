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
	 <?php get_template_part( 'template-parts/python-start/top-panel', get_post_type()  ); ?>
   
    <div class="header-content">
      <div class="header-mark">
        <span><?php the_field('header_mark'); ?></span>
        <span class="header-age"><?php the_field('header_age'); ?></span>
      </div>
      <p class="header-label text-accent"><?php the_field('header_label'); ?></p>
      <h1 class="header-title"><?php the_field('header_title'); ?></h1>
      <p class="header-description"><?php the_field('header_description'); ?></p>
      <button class="btn btn-modal btn-accent btn-desktop"><?php the_field('btn_program_start'); ?></button>
      <span class="btn-label btn-desktop"
        ><span class="text-accent">*</span><?php the_field('header_price'); ?></span
      >
    </div>
    <picture>
		<?php 
		if(get_the_ID() == 6489){
			$imgSrc = "fe-start/header/header";
		}elseif(get_the_ID() == 6850){
			$imgSrc = "design-start/header/header";
		}else{
			$imgSrc ="python-start/header/rockets";
		}
		;?>
      <source
        srcset="
          <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>_lg.webp    1x,
          <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>_lg@2x.webp 2x
        "
        type="image/webp"
        media="(min-width: 1280px)"
      />
      <source
        srcset="
           <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>_lg.png    1x,
           <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>_lg@2x.png 2x
        "
        type="image/png"
        media="(min-width: 1280px)"
      />
      <source
        srcset="
           <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>_md.webp    1x,
           <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>_md@2x.webp 2x
        "
        type="image/webp"
        media="(min-width: 768px)"
      />
      <source
        srcset=" <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>_md@2x.png 2x"
        media="(min-width: 768px)"
        type="image/png"
      />

      <img class="header-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>_md.png" alt="<?php the_field('header_img_alt'); ?>" loading="lazy" width="<?php the_field('header_img_width'); ?>" height="<?php the_field('header_img_height'); ?>" />
    </picture>

    <ul class="list program">
      <li class="program-item"><p class="program-info"><?php the_field('header_exercise'); ?></p></li>
      <li class="program-item">
        <p class="program-info"><?php the_field('header_modules'); ?></p>
        <p class="program-description"><?php the_field('header_modules_about'); ?></p>
      </li>
    </ul>
    <button class="btn btn-modal btn-accent btn-mobile"><?php the_field('btn_program_start'); ?></button>
    <span class="btn-label btn-mobile"><span class="text-accent">*</span><?php the_field('header_price'); ?></span>
  </div>
</header>
