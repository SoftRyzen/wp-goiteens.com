<?php
/*
Template Name: Home Page
*/
get_header();
?>

		<?php 
				$pl="";
				if(get_locale() == 'pl_PL' ){
					$pl = true;
				}; 


		  ?>
<?php if(get_locale() == 'uk'):?>
	<?php get_template_part( 'template-parts/banner-zsu' ); ?>
<?php endif; ?>
	<?php get_template_part( 'template-parts/main-header', get_post_type() ); ?>
<section class="hero">
  <div class="hero__wrapper">
    <picture class="hero__image-wrapper">
      <source srcset="
          <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if($pl): echo 'pl/'; endif?>boy_lg.webp    1x,
          <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if($pl): echo 'pl/'; endif?>boy_lg@2x.webp 2x
        " media="(min-width: 1280px)" type="image/webp" />
      <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if($pl): echo 'pl/'; endif?>boy_lg.png 1x, <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if($pl): echo 'pl/'; endif?>boy_lg@2x.png 2x"
        media="(min-width: 1280px)" type="image/png" />
		
		<source srcset="
          <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if($pl): echo 'pl/'; endif?>boy_md.webp    1x,
          <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if($pl): echo 'pl/'; endif?>boy_md@2x.webp 2x
        " media="(min-width: 768px)" type="image/webp" />
      <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if($pl): echo 'pl/'; endif?>boy_md.png"
        media="(min-width: 768px)" type="image/png" />
		
		<source srcset="
          <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if($pl): echo 'pl/'; endif?>boy_sm.webp"
				media="(max-width: 767px)" type="image/webp" />
		
      <img class="hero__image" src="<?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if($pl): echo 'pl/'; endif?>boy_sm.png" alt="<?php the_field('hero_img_alt'); ?>" width="320"
        height="565" />
    </picture>
    <div class="container hero__title-wrapper">
      <div class="hero__text-wrapper">
		 <?php 
			$heroLabel = get_field('text_label');
			if( $heroLabel ): ?>
		  		<p class="text-label hero__label"><?php the_field('text_label'); ?></p>
		 <?php endif;?>
        <h1 class="hero__title"><?php the_field('hero_title'); ?></h1>
        <p class="hero__text"><?php the_field('description'); ?></p>
		  <?php 
		  	$heroList = get_field('hero_list');
		  if( $heroList): ?>
		  	<ul class="list hero__list">
				<?php foreach( $heroList as $item ): ?>
					 <li class="hero__list-item" >
						<?php echo "{$item['hero_list_text']}"; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
      </div>
      <button type="button" class="main-btn" data-modal-open><?php the_field('page_button'); ?></button>
    </div>
  </div>

<?php get_template_part( 'template-parts/branches', get_post_type() ); ?>
	
</section>

<section class="advantages section">
  <div class="container">
    <h2 class="advantages__title title"><?php the_field('advantages_title'); ?></h2>
  
	  <?php 
$advantagesList = get_field('advantages_list');
if( $advantagesList ): ?> 
   <ul class="grid list advantages__list">
    <?php foreach( $advantagesList as $item ): ?>
         <li class="grid__item advantages__item" data-aos="fade-up" data-aos-delay="<?php echo "{$item['delay']}"; ?>" data-aos-anchor=".advantages">
			        <svg class="advantages__icon" width="72" height="72">
                        <use href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg<?php echo "{$item['svg']}"; ?>"></use>
                    </svg>
			        <p class="text-bold advantages__text"><?php echo "{$item['title']}"; ?></p>
                    <p><?php echo "{$item['text']}"; ?></p>
		        </li>
     
  	<?php endforeach; ?>
    </ul>
<?php endif; ?>
	  
	  
    <a class="main-btn advantages__btn" href="<?php the_field('advantages_link'); ?>"><?php the_field('advantages_btn'); ?></a>
  </div>
</section>


<section class="achievments section">
  <div class="achievments__cont">
    <div class="container">
      <div class="achievments__wrapper">
        <picture>
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/main/achievments/<?php if($pl): echo 'pl/'; endif?>vp_lg.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/main/achievments/<?php if($pl): echo 'pl/'; endif?>vp_lg@2x.webp 2x
            " media="(min-width: 1280px)" type="image/webp" />
          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/achievments/<?php if($pl): echo 'pl/'; endif?>vp_lg@2x.jpg 2x" media="(min-width: 1280px)"
            type="image/jpeg" />
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/main/achievments/<?php if($pl): echo 'pl/'; endif?>vp_lg.jpg" class="achievments__img" alt="<?php the_field('achievments_img_alt'); ?>"
			   <?php 
			   echo ($pl) ? 'width="325" height="427"' : 'width="470" height="580"'
			   ?>
             loading="lazy" />
        </picture>
        <div class="achievments__side">
          <h2 class="achievments__title"><?php the_field('achievments_title'); ?></h2>
          <div class="achievments__content">
           <?php the_field('achievments_description'); ?>
            <p class="achievments__text">
              <?php the_field('achievments_author'); ?>
              <span> <?php the_field('achievments_position'); ?> </span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if(!(get_locale() == 'pl_PL')):?>
<section class="main-awards section">
  <div class="container">
    <h2 class="main-awards__title title">
      <?php the_field('home_awards_title'); ?>
    </h2>
  </div>
	<?php get_template_part( 'template-parts/awards', get_post_type() ); ?>
</section>
<?php endif	;?>

<section class="dignity section">
  <div class="container">
    <h2 class="dignity__title title"><?php the_field('dignity_title'); ?></h2>
	   <?php
$dignityList = get_field('dignity_list');
if( $dignityList ): ?>
    <ul class="dignity__list list grid">
<?php foreach ($dignityList as $item): ?>
      <li class="dignity__item grid__item">
		 <?php if(!(get_locale() == 'pl_PL')):?>
        <picture>
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_lg.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_lg@2x.webp 2x" media="(min-width: 768px)" type="image/webp" />
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_lg.jpg    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_lg@2x.jpg 2x
            " media="(min-width: 768px)" type="image/jpeg" />
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_sm.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_sm@2x.webp 2x
            " media="(max-width: 767px)" type="image/webp" />
          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_sm@2x.jpg 2x" media="(max-width: 767px)"
            type="image/jpeg" />
          <img class="dignity__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_sm.jpg" alt="<?php echo "{$item['item_img_alt']}"; ?>"
            width="334" height="195" loading="lazy" />
        </picture>
		  <?php else: ?>
		  	<picture>
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_lg.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_lg@2x.webp 2x" media="(min-width: 768px)" type="image/webp" />
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_lg.jpg    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_lg@2x.jpg 2x
            " media="(min-width: 768px)" type="image/jpeg" />
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_sm.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_sm@2x.webp 2x
            " media="(max-width: 767px)" type="image/webp" />
          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_sm@2x.jpg 2x" media="(max-width: 767px)"
            type="image/jpeg" />
          <img class="dignity__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_sm.jpg" alt="<?php echo "{$item['item_img_alt']}"; ?>"
            width="334" height="195" loading="lazy" />
        </picture>
		  <?php endif;?>
        <h3 class="text-bold dignity__text"><?php echo "{$item['item_title']}"; ?></h3>
        <p><?php echo "{$item['item_text']}"; ?></p>
      </li>
<?php endforeach; ?>
    </ul>
	   <?php endif; ?>
  </div>
</section>

<?php if(!(get_locale() == 'pl_PL')):?>
<section class="students-reviews__main section">
  <div class="container">
    <h2 class="students-reviews__title title"> <?php the_field('home_students_reviews_title'); ?></h2>
  </div>
<?php get_template_part( 'template-parts/students-reviews', get_post_type() ); ?>
</section>
<section class="main-projects section">
	 <div class="container">
<?php get_template_part( 'template-parts/projects', get_post_type() ); ?>
	 </div>
</section>
<?php endif	;?>



<section class="appeal section">
  <div class="container appeal__wrapper">
    <h2 class="appeal__title"><?php the_field('appeal_title'); ?></h2>
    <p class="appeal__text"><?php the_field('appeal_description'); ?></p>
    <button type="button" class="main-btn" data-modal-open><?php the_field('page_button'); ?></button>
  </div>
</section>
<?php get_template_part( 'template-parts/main-footer' ); ?>
<?php
get_footer();
	
