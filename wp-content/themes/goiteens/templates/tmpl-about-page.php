<?php
/*
Template Name: About Page
*/
get_header(); 
?>
<?php if(get_locale() == 'uk'):?>
	<?php get_template_part( 'template-parts/banner-zsu' ); ?>
<?php endif; ?>
	<?php get_template_part( 'template-parts/main-header' ); ?>
<section class="hero">
  <picture class="hero__image-wrapper">
    <source srcset="
         <?php echo get_template_directory_uri(); ?>/assets/images/about/hero/boy_lg.webp    1x,
         <?php echo get_template_directory_uri(); ?>/assets/images/about/hero/boy_lg@2x.webp 2x
      " media="(min-width: 1280px)" type="image/webp" />
    <source srcset=" <?php echo get_template_directory_uri(); ?>/assets/images/about/hero/boy_lg.png 1x,  <?php echo get_template_directory_uri(); ?>/assets/images/about/hero/boy_lg@2x.png 2x"
      media="(min-width: 1280px)" type="image/png" />
    <source srcset=" <?php echo get_template_directory_uri(); ?>/assets/images/about/hero/boy_md.webp 1x" media="(max-width: 1279px)" type="image/webp" />
    <img class="hero__image" src=" <?php echo get_template_directory_uri(); ?>/assets/images/about/hero/boy_md.png" alt="{{aboutHero.img_alt}}" width="515"
      height="587" />
  </picture>
  <div class="container hero__title-wrapper">
    <h1 class="hero__title"><?php the_field('title'); ?></h1>
   <?php $heroList = get_field('hero_list');
        if( $heroList ): ?>
	  <?php foreach ( $heroList as $item): ?>
    <p class="hero__description"><?php echo "{$item['hero_item']}"; ?></p>
   <?php endforeach; ?>
	  
	    <?php endif; ?>
  </div>
</section>

<?php if(!(get_locale() == 'pl_PL')):?>
<section class="partners section">
  <div class="container">
    <h2 class="partners__title title"><?php the_field('partners_title'); ?></h2>
	<?php $partnersList = get_field('partners_list');
    if( $partnersList ): ?>
    <ul class="list partners__list">
    
	  <?php foreach ( $partnersList as $item): ?>
      <li class="partners__item">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about/partners/partner-<?php echo "{$item['partners_img_id']}"; ?>.svg" alt="<?php echo "{$item['partners_name']}"; ?>" width="<?php echo "{$item['partners_img_width']}"; ?>" height="<?php echo "{$item['partners_img_height']}"; ?>">
      </li>
      <?php endforeach; ?>
    </ul>
	  <?php endif; ?>
  </div>
</section>

<section class="courses section">
  <div class="container">
    <h2 class="courses__title title">
     <?php the_field('courses_title'); ?>
    </h2>
    <p class="courses__description">
      <?php the_field('courses_description'); ?>
    </p>
    <section class="courses-list">
      <div class="grid-item courses-list__age"> <?php the_field('label_7_8'); ?></div>
      <div class="grid-item courses-list__wrapper callout" data-text="<?php the_field('mark_main'); ?>">
        <h3 class="courses-list__title"><?php the_field('programming_title'); ?></h3>
        <p class="courses-list__description">
			<?php the_field('programming_descript'); ?>
         
        </p>
        <a
          class="more-link"
          href="<?php echo site_url() ?>/course/programming4kids/"
          target="_blank"
          rel="noreferrer noopener nofollow"
          ><?php the_field('link_text'); ?></a
        >
        <ul class="courses-mark">
          <li class="courses-mark__about"><?php the_field('mark_main'); ?></li>
        </ul>
      </div>
      <div class="grid-item courses-list__age"><?php the_field('label_9_11'); ?></div>
		  <div class="grid-item courses-list__wrapper">
        <h3 class="courses-list__title"><?php the_field('minecraft_title'); ?></h3>
        <p class="courses-list__description">
          <?php the_field('minecraft_descript'); ?>
        </p>
        <a class="more-link" href="<?php echo site_url() ?>/course/minecraft/" target="_blank"
          rel="noreferrer noopener nofollow"><?php the_field('link_text'); ?></a>
        <ul class="courses-mark">
          <li class="courses-mark__about"><?php the_field('mark_main'); ?></li>
          <li class="courses-mark__about"><?php the_field('mark_fs'); ?></li>
        </ul>
      </div>
      <div class="grid-item courses-list__wrapper callout down-large" data-text="<?php the_field('mark_additional'); ?>">
        <h3 class="courses-list__title"><?php the_field('skills_title'); ?></h3>
        <p class="courses-list__description">
          <?php the_field('skills_descript'); ?>
        </p>
        <a class="more-link" href="https://course.goiteens.ua/it-start" target="_blank"
          rel="noreferrer noopener nofollow"><?php the_field('link_text'); ?></a>
        <ul class="courses-mark">
          <li class="courses-mark__about"><?php the_field('mark_additional'); ?></li>
        </ul>
      </div>
      <div class="grid-item courses-list__age"><?php the_field('label_12_13'); ?></div>
      <div class="grid-item courses-list__wrapper">
        <h3 class="courses-list__title"><?php the_field('web_title'); ?></h3>
        <p class="courses-list__description">
          <?php the_field('web_descript'); ?>
        </p>
        <a
          class="more-link"
          href="<?php echo site_url() ?>/course/frontend/"
          target="_blank"
          rel="noreferrer noopener nofollow"
          ><?php the_field('link_text'); ?></a
        >
        <ul class="courses-mark">
          <li class="courses-mark__about"><?php the_field('mark_main'); ?></li>
          <li class="courses-mark__about"><?php the_field('mark_fs'); ?></li>
        </ul>
      </div>
      <div class="grid-item courses-list__wrapper">
        <h3 class="courses-list__title"><?php the_field('design_title'); ?></h3>
        <p class="courses-list__description">
          <?php the_field('design_descript'); ?>
        </p>
        <a
          class="more-link"
          href="<?php echo site_url() ?>/course/design/"
          target="_blank"
          rel="noreferrer noopener nofollow"
          ><?php the_field('link_text'); ?></a
        >
        <ul class="courses-mark">
          <li class="courses-mark__about"><?php the_field('mark_additional'); ?></li>
          <li class="courses-mark__about"><?php the_field('mark_itd'); ?></li>
        </ul>
      </div>
      <div class="grid-item courses-list__wrapper">
        <h3 class="courses-list__title"><?php the_field('game_title'); ?></h3>
        <p class="courses-list__description">
         <?php the_field('game_descript'); ?>
        </p>
        <a
          class="more-link"
          href="https://course.goiteens.ua/gamedev"
          target="_blank"
          rel="noreferrer noopener nofollow"
          ><?php the_field('link_text'); ?></a
        >
        <ul class="courses-mark">
          <li class="courses-mark__about"><?php the_field('mark_additional'); ?></li>
          <li class="courses-mark__about"><?php the_field('mark_gd'); ?></li>
        </ul>
      </div>
      <div class="grid-item courses-list__age"><?php the_field('label_14_15'); ?></div>
      <div class="grid-item courses-list__wrapper">
        <h3 class="courses-list__title"><?php the_field('python_title'); ?></h3>
        <p class="courses-list__description">
          <?php the_field('python_descript'); ?>
        </p>
        <a
          class="more-link"
          href="<?php echo site_url() ?>/course/python/"
          target="_blank"
          rel="noreferrer noopener nofollow"
          ><?php the_field('link_text'); ?></a
        >
        <ul class="courses-mark">
          <li class="courses-mark__about"><?php the_field('mark_main'); ?></li>
          <li class="courses-mark__about"><?php the_field('mark_fs'); ?></li>
        </ul>
      </div>
      <div class="grid-item courses-list__wrapper">
        <h3 class="courses-list__title"><?php the_field('3d_title'); ?></h3>
        <p class="courses-list__description">
          <?php the_field('3d_descript'); ?>
        </p>
        <a
          class="more-link"
          href="https://course.goiteens.ua/3ddesign"
          target="_blank"
          rel="noreferrer noopener nofollow"
          ><?php the_field('link_text'); ?></a
        >
        <ul class="courses-mark">
          <li class="courses-mark__about"><?php the_field('mark_additional'); ?></li>
          <li class="courses-mark__about"><?php the_field('mark_itd'); ?></li>
        </ul>
      </div>
      <div class="grid-item courses-list__wrapper desktop-hidden">
        <h3 class="courses-list__title"><?php the_field('game_title'); ?></h3>
        <p class="courses-list__description">
          <?php the_field('game_descript'); ?>
        </p>
        <a
          class="more-link"
          href=" https://course.goiteens.ua/gamedev"
          target="_blank"
          rel="noreferrer noopener nofollow"
          ><?php the_field('link_text'); ?></a
        >
        <ul class="courses-mark">
          <li class="courses-mark__about"><?php the_field('mark_additional'); ?></li>
          <li class="courses-mark__about"><?php the_field('mark_gd'); ?></li>
        </ul>
      </div>
      <ul class="grid-item courses-name__list">
        <li class="courses-name__item large"><?php the_field('mark_fs'); ?></li>
        <li class="courses-name__item"><?php the_field('mark_itd'); ?></li>
        <li class="courses-name__item"><?php the_field('mark_gd'); ?></li>
      </ul>
      <div class="grid-item courses-list__age"><?php the_field('label_16_18'); ?></div>
      <div class="grid-item courses-list__wrapper">
        <h3 class="courses-list__title"><?php the_field('management_title'); ?></h3>
        <p class="courses-list__description">
          <?php the_field('management_descript'); ?>
        </p>
        <ul class="courses-mark">
          <li class="courses-mark__about"><?php the_field('mark_main'); ?></li>
        </ul>
      </div>
    </section>
    <button class="main-btn courses__btn" data-modal-open><?php the_field('page_button'); ?></button>
  </div>
</section>
<?php endif	;?>



<section class="skills section">
  <div class="container">
    <h2 class="skills__title title">
      <span class="skills__title-span text-accent"><?php the_field('title_skills_span'); ?></span> <?php the_field('title_skills'); ?>
    </h2>
    <div class="skills__list">
      <p class="skills__item-grid skills__description text-accent"><?php the_field('descript skills'); ?></p>
		<?php $skillsLists = get_field('skills_lists');
        if( $skillsLists ): ?>
		<?php foreach ($skillsLists as $list): ?>

      <div class="skills__item-grid text-label skills__label"><?php echo "{$list['title']}"; ?></div>
      <?php foreach ($list['items'] as $item): ?>
		<div class="skills__item-grid skills__item skills-<?php echo "{$item['item_id']}"; ?>">
        <p class="skills__item-title"><?php echo "{$item['item_title']}"; ?></p>
        <p><?php echo "{$item['item_descript']}"; ?></p>
      </div>
		 <?php endforeach; ?>
     <?php endforeach; ?>
		<?php endif; ?>
	  </div>
  </div>
</section>

<section class="complex section">
  <div class="container">
    <h2 class="complex__title title"><?php the_field('complex_title'); ?></h2>
    <p class="text-label complex__label"><?php the_field('complex_description'); ?></p>
	  	<?php $complexList = get_field('complex_list');
        if( $complexList ): ?>
		
    <ul class="complex__list list grid">
		<?php foreach ($complexList as $item): ?>

      <li class="complex__item grid__item complex-<?php echo "{$item['item_id']}"; ?>">
        <p class="text-bold complex__item-title"><?php echo "{$item['item_title']}"; ?></p>
        <p><?php echo "{$item['item_description']}"; ?></p>
      </li>
		 <?php endforeach; ?>

    </ul>
	  <?php endif; ?>
  </div>
</section>



<section class="proff-skills section">
  <div class="container">
    <div class="grid proff-skills__title-wrapper">
      <div class="grid__item">
        <h2 class="proff-skills__title title"><?php the_field('proffskills_title'); ?></h2>
		<?php $descriptionList = get_field('description_list');?>
       
        <p class="proff-skills__descript"><?php echo "{$descriptionList['description_text']}"; ?></p>
		  		
        <ul class="list proff-skills__descript-list">
			<?php foreach ($descriptionList['description_items'] as $item): ?>
          <li class="proff-skills__descript-item"><?php echo "{$item['item_text']}"; ?></li>
        <?php endforeach; ?>
		  </ul>
      </div>
      <div class="grid__item">
		  
		  <?php 
				$pl="";
				if(get_locale() == 'pl_PL' ){
					$pl = true;
				}; 
		  ?>
		  
        <picture class="proff-skills__img-wrap">
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/about/proff-skills/<?php if($pl): echo 'pl/'; endif?>title-img_lg.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/about/proff-skills/<?php if($pl): echo 'pl/'; endif?>title-img_lg@2x.webp 2x
            " media="(min-width: 320px)" type="image/webp" />
          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/about/proff-skills/<?php if($pl): echo 'pl/'; endif?>title-img_lg@2x.jpg 2x" media="(min-width: 320px)"
            type="image/jpeg" />
          <img class="proff-skills__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/about/proff-skills/<?php if($pl): echo 'pl/'; endif?>title-img_lg.jpg"
            alt="<?php the_field('proffskills_alt'); ?>" width="470" height="341" loading="lazy" />
        </picture>
        <p><?php the_field('proffskills_description'); ?></p>
      </div>
    </div>
	  <?php $proffskillsList = get_field('proffskills_list'); ?>
    <ul class="list proff-skills__list">
			<?php foreach ($proffskillsList['proffskills_item'] as $item): ?>
      <li class="grid proff-skills__item">
        <div class="grid__item proff-skills__item-wrap">
          <h3 class="proff-skills__title title"><?php echo $item['item_title']; ?></h3>
          <p><?php echo "{$item['item_description']}"; ?></p>
        </div>
        <picture class="grid__item proff-skills__img-wrap">
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/about/proff-skills/<?php if($pl): echo 'pl/'; endif?>list-img-<?php echo $item['item_id']; ?>_lg.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/about/proff-skills/<?php if($pl): echo 'pl/'; endif?>list-img-<?php echo $item['item_id']; ?>_lg@2x.webp 2x
            " media="(min-width: 320px)" type="image/webp" />
          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/about/proff-skills/<?php if($pl): echo 'pl/'; endif?>list-img-<?php echo $item['item_id']; ?>_lg@2x.jpg 2x"
            media="(min-width: 320px)" type="image/jpeg" />
          <img class="proff-skills__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/about/proff-skills/<?php if($pl): echo 'pl/'; endif?>list-img-<?php echo $item['item_id']; ?>_lg.jpg"
            alt="<?php echo $item['item_alt']; ?>" width="470" height="341" loading="lazy" />
        </picture>
      </li>
		   <?php endforeach; ?>

    </ul>
  </div>
</section>


<?php if(!(get_locale() == 'pl_PL')):?>
<?php get_template_part( 'template-parts/teachers', get_post_type() ); ?>
<?php get_template_part( 'template-parts/speakers', get_post_type() ); ?>
<section class="about-projects section">
  <div class="container">
	<?php get_template_part( 'template-parts/projects', get_post_type() ); ?>
	</div>
</section>
<?php endif	;?>





<section class="hero-footer about-hero-footer">
  <div class="container hero-footer__wrapper">
    <h2 class="hero-footer__title"><?php the_field('hero_footer_title'); ?></h2>
    <p class="hero-footer__description text-yellow"><?php the_field('hero_footer_description'); ?></p>
    <button type="button" class="main-btn" data-modal-open>
     <?php the_field('hero_footer_btn'); ?>
    </button>
  </div>
</section>

<?php get_template_part( 'template-parts/main-footer' ); ?>

<?php
get_footer();