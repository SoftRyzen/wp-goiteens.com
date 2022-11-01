<?php
/*
Template Name: Contacts Page
*/
get_header();
?>
<?php if(get_locale() == 'uk'):?>
	<?php get_template_part( 'template-parts/banner-zsu' ); ?>
<?php endif; ?>
	<?php get_template_part( 'template-parts/main-header', get_post_type() ); ?>
<section class="hero">
  <div class="hero__wrapper">
    <picture class="hero__image-wrapper">
		<?php 
				$pl="";
				if(get_locale() == 'pl_PL' ){
					$pl = true;
				}; 
		  ?>
      <source srcset="
           <?php echo get_template_directory_uri();?>/assets/images/contacts/hero/<?php if($pl): echo 'pl/'; endif?>boy-bg_lg.webp    1x,
           <?php echo get_template_directory_uri();?>/assets/images/contacts/hero/<?php if($pl): echo 'pl/'; endif?>boy-bg_lg@2x.webp 2x
        " media="(min-width: 1280px)" type="image/webp" />
      <source srcset="
           <?php echo get_template_directory_uri();?>/assets/images/contacts/hero/<?php if($pl): echo 'pl/'; endif?>boy-bg_lg.png    1x,
           <?php echo get_template_directory_uri();?>/assets/images/contacts/hero/<?php if($pl): echo 'pl/'; endif?>boy-bg_lg@2x.png 2x
        " media="(min-width: 1280px)" type="image/png" />
      <source srcset=" <?php echo get_template_directory_uri();?>/assets/images/contacts/hero/<?php if($pl): echo 'pl/'; endif?>boy-bg_md.webp 1x" media="(max-width: 1279px)" type="image/webp" />
      <img class="hero__image" src=" <?php echo get_template_directory_uri();?>/assets/images/contacts/hero/<?php if($pl): echo 'pl/'; endif?>boy-bg_md.png" alt="<?php the_field('contacts_img_alt'); ?>"
        width="768" height="599" />
    </picture>
    <div class="container hero__title-wrapper">
      <div class="hero__text-wrapper">
        <p class="text-label hero__label"><?php the_field('contacts_text_label'); ?></p>
        <h1 class="hero__title"><?php the_field('contacts_title'); ?></h1>
        <p class="hero__text"><?php the_field('contacts_description'); ?></p>
      </div>
       <button type="button" class="main-btn" data-modal-open><?php the_field('page_button');?></button>
    </div>
  </div>
	<?php get_template_part( 'template-parts/branches', get_post_type() ); ?>
</section>

<section class="contacts section">
  <div class="container contacts__wrapper">
    <h2 class="contacts__title title"><?php the_field('contacts_section_title');?></h2>
    <div class="grid contacts__content">
      <div class="grid__item">
        <p class="contacts__item-title"><?php the_field('email_title');?></p>
        <ul class="list">
          <li class="contacts__item">
            <a class="contacts__link link" href="mailto:<?php echo get_field('contact_mail', 'option'); ?>"><?php echo get_field('contact_mail', 'option'); ?></a>
          </li>
        </ul>
      </div>
      <div class="grid__item">
        <p class="contacts__item-title"><?php the_field('phone_title');?></p>

<?php $phoneList = get_field('phone_list', 'option');
        if( $phoneList ): ?>
 
        <ul class="list">
			<?php foreach ($phoneList as $item): ?>
			
          <li class="contacts__item">
            <a class="contacts__link link" href="tel:<?php echo "{$item['phone_href']}"; ?>"><?php echo "{$item['phone_text']}"; ?></a>
          </li>
			
        <?php endforeach; ?>
			
        </ul>
		   <?php endif; ?>
		  
      </div>
      <div class="grid__item">
        <p class="contacts__item-title"><?php the_field('socials_title');?></p>
     
<?php $socialList = get_field('socials_list', 'option');
 if( $socialList ): ?>
<ul class="list social__list">
<?php foreach ($socialList as $item): ?>
			  
  <li class="social__item">
    <a
      class="social__link"
      href="<?php echo "{$item['social_link']}"; ?>"
      aria-label="<?php echo "{$item['social_id']}"; ?>"
      target="_blank"
      rel="noopener noreferrer nofollow"
    >
      <svg class="social__svg" width="32"  height="32">
        <use href="<?php echo get_template_directory_uri(); ?>/assets/images/footer/socials.svg<?php echo "{$item['svg_id']}"; ?>"></use>
      </svg>
    </a>
  </li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
		  
		  
      </div>
    </div>
<?php if(!(get_locale() == 'pl_PL')):?>
 	<div class="contacts__call-us">
      <p><?php the_field('contact_text');?></p>
    </div>
    <div class="grid contacts__btn-wrapper">
      <button class="grid__item main-btn" type="button" data-modal-open>
     <?php the_field('contacts_button');?>
      </button>
    </div>
<?php endif;?>
   
  </div>
</section>


<?php if(!(get_locale() == 'pl_PL')):?>

<section class="contacts-awards">
  <div class="container">
    <h2 class="contacts-awards__title title">
      <?php the_field('awards_section_title'); ?>
    </h2>
  </div>
	<?php get_template_part( 'template-parts/awards', get_post_type() ); ?>

</section>
<?php endif;?>

<?php get_template_part( 'template-parts/main-footer' ); ?>
<?php
get_footer();