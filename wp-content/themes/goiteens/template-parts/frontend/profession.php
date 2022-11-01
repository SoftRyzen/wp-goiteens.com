<section class="section profession">
  <div class="container">
    <h2 class="section__title profession__title"><?php the_field('profession_title'); ?></h2>
	  <?php
		$professionList = get_field('profession_list');
		if( $professionList ): ?>
    	<ul class="list grid profession__list">
      	<?php foreach ($professionList as $item): ?>
      <li class="grid__item profession__item">
        <picture class="profession__img">
          <source srcset="
			<?php echo get_template_directory_uri(); ?>/assets/images/frontend/profession/profession-icon-<?php echo "{$item['id']}"; ?>_lg.webp    1x,
            <?php echo get_template_directory_uri(); ?>/assets/images/frontend/profession/profession-icon-<?php echo "{$item['id']}"; ?>_lg@2x.webp 2x " media="(min-width: 768px)" type="image/webp" />
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/frontend/profession/profession-icon-<?php echo "{$item['id']}"; ?>_lg.png    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/frontend/profession/profession-icon-<?php echo "{$item['id']}"; ?>_lg@2x.png 2x " media="(min-width: 768px)" type="image/png"/>
          <source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/frontend/profession/profession-icon-<?php echo "{$item['id']}"; ?>.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/frontend/profession/profession-icon-<?php echo "{$item['id']}"; ?>@2x.webp 2x " media="(max-width: 767px)" type="image/webp" />
          <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/frontend/profession/profession-icon-<?php echo "{$item['id']}"; ?>@2x.png 2x" media="(max-width: 767px)" type="image/png" />
          <img class="profession__img profession__<?php echo "{$item['style']}"; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/images/frontend/profession/profession-icon-<?php echo "{$item['id']}"; ?>.png" alt="<?php echo "{$item['img_alt']}"; ?>" width="<?php echo "{$item['img_width']}"; ?>" height="<?php echo "{$item['img_height']}"; ?>" loading="lazy" />
        </picture>
        <p class="profession__text"><?php echo "{$item['text']}"; ?></p>
      </li>
	<?php endforeach; ?>    
    </ul>
	<?php endif; ?>
  </div>
</section>
