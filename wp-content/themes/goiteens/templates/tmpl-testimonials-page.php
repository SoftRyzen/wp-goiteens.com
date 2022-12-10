<?php
/*
Template Name: Testimonials Page
*/
get_header();
?>
<?php if(get_locale() == 'uk'):?>
	<?php get_template_part( 'template-parts/banner-zsu' ); ?>
<?php endif; ?>

	<?php get_template_part( 'template-parts/main-header', get_post_type() ); ?>
<section class="hero">
  <picture class="hero__image-wrapper">

	   <?php 
		  $pl="";
		  if(get_locale() == 'pl_PL' ){
			  $pl = true;
		  }; 
		?>
	  
    <source srcset="
          <?php echo get_template_directory_uri(); ?>/assets/images/testimonials/hero/<?php if($pl): echo 'pl/'; endif?>bg-boy_lg.webp    1x,
          <?php echo get_template_directory_uri(); ?>/assets/images/testimonials/hero/<?php if($pl): echo 'pl/'; endif?>bg-boy_lg@2x.webp 2x
        " media="(min-width: 1280px)" type="image/webp" />
    <source srcset="
          <?php echo get_template_directory_uri(); ?>/assets/images/testimonials/<?php if($pl): echo 'pl/'; endif?>hero/bg-boy_lg.png    1x,
          <?php echo get_template_directory_uri(); ?>/assets/images/testimonials/<?php if($pl): echo 'pl/'; endif?>hero/bg-boy_lg@2x.png 2x
        " media="(min-width: 1280px)" type="image/png" />
    <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/testimonials/hero/<?php if($pl): echo 'pl/'; endif?>bg-boy_md.webp 1x" media="(max-width: 1279px)"
      type="image/webp" />
    <img class="hero__image" src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonials/hero/<?php if($pl): echo 'pl/'; endif?>bg-boy_md.png" alt="<?php the_field('testimonials_img_alt'); ?>"
      width="768" height="677" />
  </picture>
  <div class="container hero__title-wrapper">
    <h1 class="hero__title"><?php the_field('title'); ?></h1>
    <button type="button" class="main-btn" data-modal-open><?php the_field('page_button'); ?></button>
  </div>
</section>

<section class="last-projects section">
  <div class="container">
	  <h2 class="last-projects__title title"><?php the_field('last_projects_title'); ?></h2>
  </div>
  <div class="last-projects__cont">
    <div class="container">
      <div class="last-projects__wrapper">
        <picture>
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/testimonials/last-projects/author_lg.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/testimonials/last-projects/author_lg@2x.webp 2x
            " media="(min-width: 320px)" type="image/webp" />
          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/testimonials/last-projects/author_lg@2x.jpg 2x" media="(min-width: 320px)"
            type="image/jpeg" />
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonials/last-projects/author_lg.jpg" class="last-projects__img"
            alt="<?php the_field('last_projects_author_alt'); ?>-<?php the_field('last_projects_author'); ?>" width="470" height="440" loading="lazy" />
        </picture>
        <div class="last-projects__side">
          <p class="last-projects__side-title"><?php the_field('last_projects_author'); ?>            
            <span><?php the_field('last_projects_course'); ?></span>
          </p>
          <p class="last-projects__side-title"><?php the_field('last_projects_project_name'); ?></p>
          <p class="last-projects__side-title"><?php the_field('last_projects_project_title'); ?></p>

          <p class="last-projects__content"><?php the_field('last_projects_project_description'); ?></p>
          <p class="last-projects__side-title"><?php the_field('last_projects_project_technologies_title'); ?></p>
          <p><?php the_field('last_projects_project_technologies'); ?></p>
          <a class="main-btn main-btn--yellow" href="https://yablo4ko23.github.io/Money-App/" target="_blank"
            rel="noreferrer noopener nofollow"><?php the_field('last_projects_link_text'); ?></a>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
	  <?php $lastProjectList = get_field('project_list'); if( $lastProjectList ): ?>
    <ul class="last-projects__list grid list">
		<?php foreach ($lastProjectList as $item): ?>
      <li class="last-projects__item grid__item">
        <picture>
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/testimonials/last-projects/project-<?php echo $item['lp_item']; ?>.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/testimonials/last-projects/project-<?php echo $item['lp_item']; ?>@2x.webp 2x
            " media="(min-width: 320px)" type="image/webp" />
          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/testimonials/last-projects/project-<?php echo $item['lp_item']; ?>@2x.png 2x"
            media="(min-width: 320px)" type="image/png" />
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonials/last-projects/project-<?php echo $item['lp_item']; ?>.png" class="last-projects__list-img"
            alt="<?php the_field('last_projects_project_alt'); ?>-<?php the_field('last_projects_project_name'); ?>" width="470" height="440" loading="lazy" />
        </picture>
      </li>
    <?php endforeach; ?>
    </ul>
	   <?php endif; ?>
  </div>
</section>
	  
	  

<section class="winners-project section">
  <div class="container">
    <div class="winners-project__wrapper grid">
      <div class="winners-project__video-wrap grid__item">
        <div class="winners-project__video youtube-js" data-embed="ppGpsoegMGQ">
			<div class="play-btn">
	  			<svg class="play-btn__svg" width="70" height="70">
    			<use href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-play-btn"></use>
  				</svg>
			</div>
			<img src="https://img.youtube.com/vi/ppGpsoegMGQ/sddefault.jpg" alt="відео з Youtube">
        </div>
      </div>
      <div class="grid__item">
        <h2 class="winners-project__title title"><?php the_field('winners_project_title'); ?></h2>
        <p class="winners-project__descript text-label"><?php the_field('winners_project_description'); ?></p>
        <p class="winners-project__text text-bold"><?php the_field('winners_project_text_how'); ?></p>
        <p><?php the_field('winners_project_text_winners'); ?></p>
      </div>
    </div>
  </div>
</section>	  
	  
	  
<section class="testimonials-projects section">
  <div class="container">
	  <?php get_template_part( 'template-parts/projects', get_post_type() ); ?>
</div>
    
</section>
	  

<section class="students-reviews__testimonials section">
  <div class="container">
    <h2 class="students-reviews__title title"><?php the_field('testimonials_students_reviews'); ?></h2>
  </div>
	<?php get_template_part( 'template-parts/students-reviews', get_post_type() ); ?>

</section>




<section class="parents-reviews section">
  <div class="container">
    <h2 class="parents-reviews__title title"><?php the_field('parents_reviews_title'); ?></h2>
    <div class="parent-review-slider-js parents-reviews__list">
		 <?php
		$parentsReviews = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'parent_review',
			'category_name'    => 'goiteens',
			'suppress_filters' => false
		);
		$parentsReviews_list = get_posts( $parentsReviews );
		foreach ( $parentsReviews_list as $item ) {
			$result = '';
			setup_postdata( $item );
			?>
      <div class="parents-reviews__item">
        <div class="parents-reviews__wrap">
          <picture>
            <source srcset="
                <?php echo get_template_directory_uri(); ?>/assets/images/testimonials/parent-reviews/<?php echo $item->parents_img_id; ?>.webp    1x,
                <?php echo get_template_directory_uri(); ?>/assets/images/testimonials/parent-reviews/<?php echo $item->parents_img_id; ?>@2x.webp 2x
              " media="(min-width: 320px)" type="image/webp" />
            <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/testimonials/parent-reviews/<?php echo $item->parents_img_id; ?>@2x.png 2x"
              media="(min-width: 320px)" type="image/png" />
            <img class="parents-reviews__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonials/parent-reviews/<?php echo $item->parents_img_id; ?>.png"
              alt="<?php the_field('img_alt'); ?>-<?php echo $item->parents_name; ?>" width="62" height="62" loading="lazy" />
          </picture>
          <p class="parents-reviews__description custom-scroll"><?php echo $item->parents_description; ?></p>
          <p><?php echo $item->parents_name; ?></p>
        </div>
      </div>
<? } ?>
    </div>
    <div class="parents-reviews__btn-wrap">
      <button class="parents-reviews__prev-btn parent-prev-but-js" type="button"
        aria-label="<?php the_field('perev_btm'); ?>"></button>
      <button class="parents-reviews__next-btn parent-next-but-js" type="button"
        aria-label="<?php the_field('next_btm'); ?>"></button>
    </div>
  </div>
</section>


<?php get_template_part( 'template-parts/main-footer' ); ?>

<?php
get_footer();
	  






	   