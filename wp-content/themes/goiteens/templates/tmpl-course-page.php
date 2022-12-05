<?php
/*
Template Name: Course Page
*/
get_header();
?>
<?php if((get_locale() == 'uk')):?>
	<?php get_template_part( 'template-parts/banner-zsu' ); ?>
<?php endif; ?>
	<?php get_template_part( 'template-parts/main-header', get_post_type() ); ?>
<section class="hero">	
	<?php if(!(get_locale() == 'pl_PL')):?>
        <picture class="hero__image-wrapper">
			<source srcset="
				<?php echo get_template_directory_uri();?>/assets/images/programs/hero/children_lg.webp    1x,
				<?php echo get_template_directory_uri();?>/assets/images/programs/hero/children_lg@2x.webp 2x
			  " media="(min-width: 1280px)" type="image/webp" />
			<source srcset="
				<?php echo get_template_directory_uri();?>/assets/images/programs/hero/children_lg.png    1x,
				<?php echo get_template_directory_uri();?>/assets/images/programs/hero/children_lg@2x.png 2x
			  " media="(min-width: 1280px)" type="image/png" />
			<source srcset="<?php echo get_template_directory_uri();?>/assets/images/programs/hero/children_md.webp 1x" media="(max-width: 1279px)" type="image/webp" />
			<img class="hero__image" src="<?php echo get_template_directory_uri();?>/assets/images/programs/hero/children_md.png" alt="<?php the_field('course_img_alt'); ?>"
			  width="609" height="558" />
  		</picture>
	<?php else: ?>
		<picture class="hero__image-wrapper">
			<source srcset="
				<?php echo get_template_directory_uri();?>/assets/images/programs/hero/pl/children_lg.webp    1x,
				<?php echo get_template_directory_uri();?>/assets/images/programs/hero/pl/children_lg@2x.webp 2x
			  " media="(min-width: 1280px)" type="image/webp" />
			<source srcset="
				<?php echo get_template_directory_uri();?>/assets/images/programs/hero/pl/children_lg.png    1x,
				<?php echo get_template_directory_uri();?>/assets/images/programs/hero/pl/children_lg@2x.png 2x
			  " media="(min-width: 1280px)" type="image/png" />
			<source srcset="<?php echo get_template_directory_uri();?>/assets/images/programs/hero/pl/children_md.webp 1x" media="(max-width: 1279px)" type="image/webp" />
			<img class="hero__image" src="<?php echo get_template_directory_uri();?>/assets/images/programs/hero/pl/children_md.png" alt="<?php the_field('course_img_alt'); ?>"
			  width="609" height="558" />
  		 </picture>
	<?php endif;?>
  <div class="container hero__title-wrapper">
    <h1 class="hero__title"><?php the_field('course_hero_title'); ?></h1>
	  <?php if(get_locale() == 'pl_PL'):?>
		<p class="hero__text"><?php the_field('course_text'); ?></p>
		<?php endif	;?>
    <button type="button" class="main-btn" data-modal-open><?php the_field('page_button'); ?></button>
  </div>
</section>
<section class="programs">
  <div class="container">
    <ul class="programs__list list grid">
		   <?php
		$programs_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'courses',
			'suppress_filters' => false
		);
		$programs_list = get_posts( $programs_section );
		foreach ( $programs_list as $item ) {
			$result = '';
			setup_postdata( $item );
			?>

      <li class="programs__item grid__item <?php if($item->is_course_active) echo $item->is_course_active ;?>">
        <a
          class="programs__item-link"
          href="<?php if ( $item->course_page_link ) {
          
            echo get_permalink( $item->course_page_link );
              
          } else {
          
            echo $item->external_link;  
              
          } ?> "
          target="_blank"
          rel="noreferrer noopener nofollow"
        >
          <div class="programs__item-wrapper program-<?php echo $item->course_id; ?> ">
            <h3 class="item__title programs__item-title"><?php echo $item->course_title; ?></h3>
            <p class="programs__item-descript"><?php echo $item->course_description; ?></p>
			  
			  
			  <ul class="list features__list features-<?php echo $item->course_id; ?>">
  <li class="features__item">
    <p class="features__title"><?php echo $item->course_format; ?></p>
    <svg class="features__icon" width="270" height="3">
      <use href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#pr-online"></use>
    </svg>
  </li>
  <li class="features__item">
    <p class="features__title"><?php echo $item->age_title; ?></p>
    <svg class="features__icon" width="270" height="10">
      <use href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#<?php echo $item->age_svg; ?>"></use>
    </svg>
    <div class="features__age">
      <span class="features__age-from"><?php echo $item->age_from; ?></span>
  
      <span class="features__age-to"><?php echo $item->age_to; ?></span>

    </div>
  </li>
  <li class="features__item">
    <p class="features__title"><?php echo $item->level_title; ?></p>
    <svg class="features__icon" width="270" height="10">
      <use href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#<?php echo $item->level_svg; ?>"></use>
    </svg>
    <span class="features__level"><?php echo $item->course_level; ?></span>
  </li>
</ul>	  
          </div>
        </a>
      </li>
 <?php } ?>
    </ul>
  </div>
</section>

<section class="hero-footer programs-hero-footer">
    <div class="container hero-footer__wrapper">
        <h2 class="hero-footer__title">
          <?php the_field('course_footer_title'); ?>
        </h2>
        <p class="hero-footer__description text-yellow">
               <?php the_field('footer_description'); ?>
        </p>
        <button type="button" class="main-btn" data-modal-open> <?php the_field('hero_footer_btn'); ?></button>
    </div>
</section>
<?php get_template_part( 'template-parts/main-footer' ); ?>

<?php
get_footer();