<section class="section future">
  <div class="container future__top">
    <h2 class="future__title"><?php the_field('future_title');?></h2>
	  <?php $futureList = get_field('future_list');
	  if( $futureList ): ?>
		<ul class="list grid future__list">
		  <?php foreach( $futureList as $item ): ?>
		  <li class="grid__item future__item">
			<div class="future__item-wrapper">
			  <svg class="future__item-icon" width="70" height="70">
				<use href="<?php echo get_template_directory_uri(); ?>/assets/images/python/sprite.svg#icon-participate<?php echo "{$item['id']}"; ?>"></use>
			  </svg>
			</div>
			<p class="future__item-text"><?php echo "{$item['text']}"; ?></p>
		  </li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
  </div>

  <div class="future__under">
    <div class="container">
      <div class="future__under-content">
        <picture class="future__under-wrapper">
          <source
            srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/python/future/portrait.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/python/future/portrait@2x.webp 2x
            "
            type="image/webp"
          />
          <img
            srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/python/future/portrait.jpg    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/python/future/portrait@2x.jpg 2x
            "
            src="<?php echo get_template_directory_uri(); ?>/assets/images/python/future/portrait.jpg"
            class="future__under-img"
            alt="<?php the_field('future_img_alt');?>"
            width="470"
            height="422"
            loading="lazy"
          />
        </picture>
        <div class="future__under-side">
          <svg class="future__under-logo" width="143" height="37">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/images/python/sprite.svg#logo-yellow" />
          </svg>
          <p class="future__under-text"><?php the_field('future_side_text');?></p>
			<button type="button" class="main-btn future__btn btn-icon main-btn--yellow" data-modal-open><?php the_field('header_button'); ?></button>
        </div>
      </div>
    </div>
  </div>
  <p class="section__title text-accent future__label"><?php the_field('future_description');?></p>
</section>
