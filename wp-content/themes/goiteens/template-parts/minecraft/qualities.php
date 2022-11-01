<section class="section qualities">
  <div class="container">
    <div class="qualities__maincont grid">
      <div class="qualities__leftcont grid__item">
        <h2 class="section__title"><?php the_field('qualities_title');?></h2>
		<?php $qualitiesList = get_field('qualities_list');
		  $qualityListTitle = get_field('qualities_list_title');
		if( $qualitiesList ): ?> 
		  <?php if($qualityListTitle): ?>
		  <p>
			 <?php echo $qualityListTitle; ?> 
		  </p>
		  <?php endif ;?>
			<ul class="list qualities__leftcont-list">
			  <?php foreach( $qualitiesList as $item ): ?>
			  <li class="item qualities__leftcont-item"><?php echo "{$item['text']}"; ?></li>
			  <?php endforeach; ?>
			</ul>
		 <?php endif; ?> 
        <p class="qualities__leftcont-undertext"><?php the_field('qualities_subtitle');?></p>
      </div>
      <div class="qualities__rightcont grid__item">
		  <?php
		  if(get_locale() == 'pl_PL' || get_locale() == 'en_US' ): ?>
		    
		  
        <picture>
          <source
            srcset="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/qualities/pl/boy.webp 1x,              <?php echo get_template_directory_uri(); ?>/assets/images/minecraft/qualities/pl/boy@2x.webp 2x"
            media="(min-width: 320px)"
            type="image/webp"
          />

          <source
            srcset="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/qualities/pl/boy@2x.jpg               2x"
            media="(min-width: 320px)"
            type="image/jpeg"
          />

          <img
            class="qualities__rightcont-img pl"
            src="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/qualities/pl/boy@2x.jpg"
            alt="<?php the_field('qualities_img_alt');?>"
            width="569"
            height="560"
            loading="lazy"
          />
        </picture>
		  
		<?php else: ?>
		  
		  <picture>
          <source
            srcset="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/qualities/boy.webp 1x, 
					<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/qualities/boy@2x.webp 2x"
            media="(min-width: 320px)"
            type="image/webp"
          />

          <source
            srcset="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/qualities/boy@2x.jpg 2x"
            media="(min-width: 320px)"
            type="image/jpeg"
          />

          <img
            class="qualities__rightcont-img"
            src="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/qualities/boy@2x.jpg"
            alt="<?php the_field('qualities_img_alt');?>"
            width="569"
            height="560"
            loading="lazy"
          />
        </picture>
		  <?php endif;?>
      </div>
    </div>
  </div>
</section>
