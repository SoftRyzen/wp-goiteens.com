<?php $euPage=strpos($_SERVER['REQUEST_URI'], '-eu');?>
<section class="hero">
	
  <div class="container">
    <div class="hero__box-text">

		
		
      <p class="hero__label"><?php the_field('hero_label');?></p>
		
	<?php if(get_locale() == 'pl_PL' || get_locale() == 'en_US'):?>
			  <picture>
          <source
            srcset="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/hero/me-logo.webp 1x, 
					<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/hero/me-logo.webp 2x"
            media="(min-width: 280px)"
            type="image/webp"
          />

          <source
            srcset="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/hero/me-logo.png 2x"
            media="(min-width: 280px)"
            type="image/png"
          />
		<img class="minecraft-logo" src='<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/hero/me-logo.png' alt="minecraft logo" width="200" height="50" loading="lazy"/>
 
        </picture>

		<?php endif	;?>
		
      <h1 class="hero__title"><?php the_field('hero_title');?></h1>
      <h2 class="hero__subtitle"><?php the_field('hero_description');?></h2>
		<?php $heroList = get_field('hero_list');
		if( $heroList ): ?> 
		   <ul class="list hero__list">
			<?php foreach( $heroList as $listItem ): ?>
				 <li class="hero__list-item" >
					<?php echo "{$listItem['text']}"; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>
      
    </div>
    <div class="hero__box-btn">
      <button type="button" class="hero__btn main-btn btn-icon main-btn--violet" data-modal-open>
        <?php 
		  $euPage ? the_field('btn_text_eu') : the_field('btn_text');
		  ?>
      </button>
      <span class="hero__notation"> <?php  $euPage ? the_field('btn_notation_eu') : the_field('btn_notation');?></span>
    </div>
  </div>
</section>
