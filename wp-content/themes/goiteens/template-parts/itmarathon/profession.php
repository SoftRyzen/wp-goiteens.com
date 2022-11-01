<section class="section profession">
  <div class="container">
	  	<?php $titleList = get_field('profession_title');
		if( $titleList ): ?> 
   		 <h2 class="section__title grid profession__title">
			<?php foreach( $titleList as $item ): ?>	
			<span class="grid__item"><?php echo "{$item['text']}"; ?></span>
			<?php endforeach; ?>
	  	</h2>
	  	<?php endif; ?>
	<?php $professionList = get_field('profession_items');
	if( $professionList ): ?> 
    <ul class="list grid profession__list">
      	<?php foreach( $professionList as $index=>$item ): ?>	
      <li class="grid__item profession__item">
        <div class="profession__item-wrap">
          <picture>
            <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/profession/profession-icon-<?php echo $index + 1; ?>.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/profession/profession-icon-<?php echo $index + 1; ?>@2x.webp 2x" type="image/webp" />
            <source srcset="
			<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/profession/profession-icon-<?php echo $index + 1; ?>.png 1x, 
			<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/profession/profession-icon-<?php echo $index + 1; ?>@2x.png 2x" type="image/png" />
            <img class="profession__img " src="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/profession/profession-icon-<?php echo $index + 1; ?>.png"
              alt="<?php echo "{$item['img_alt']}"; ?>" width="<?php echo "{$item['img_width']}"; ?>" height="<?php echo "{$item['img_height']}"; ?>" loading="lazy" />
          </picture>
          <p class="profession__text"><?php echo "{$item['text']}"; ?></p>
        </div>
      </li>
       <?php endforeach; ?>
    </ul>
	   <?php endif; ?>
  </div>
</section>