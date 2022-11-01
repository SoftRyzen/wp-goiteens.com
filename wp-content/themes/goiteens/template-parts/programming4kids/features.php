
<section class="section features">
  <div class="container features__content">
    <h2 class="section-title features__title"><?php the_field('features_title'); ?></h2>
	    <?php $featureList = get_field('features_list'); ?>
    <ul class="list grid features__list">
      <?php foreach ($featureList['feature_item'] as $item): ?>
      <li class="grid__item features__item">
          <svg class="features__icon" width="76" height="76">
              <use href="<?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/sprite.svg<?php echo "{$item['item_icon']}"; ?>"></use>
          </svg>
        <p class="features__item-text"><?php echo "{$item['item_text']}"; ?></p>
      </li>
     <?php endforeach; ?>
    </ul>
    <div class="features__wrapper">
      <p class="features__description"><?php the_field('features_description'); ?></p>
		<button type="button" class="main-btn features__btn" data-modal-open><?php the_field('programming4kids_btn'); ?></button>
    </div>
  </div>
</section>
