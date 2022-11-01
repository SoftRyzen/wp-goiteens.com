
<section class="section results">
  <div class="container">
    <h2 class="section-title results__title"><?php the_field('results_title'); ?></h2>
	
	<?php $resultsList = get_field('results_list');?>
    <ul class="list results__list">
   <?php foreach ($resultsList['results_items'] as $item): ?>
      <li class="results__item results__item--<?php echo "{$item['item_modificator']}"; ?>">
        <svg class="results__icon" width="48" height="48" aria-hidden="true">
          <use href="<?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/sprite.svg#orange-circle"></use>
        </svg>
        <p><?php echo "{$item['item_text']}"; ?></p>
      </li>
     <?php endforeach; ?>
    </ul>
    <div class="results__wrapper">
      <h3 class="results__subtitle"><?php the_field('results_description'); ?></h3>
      <p class="text-white"><?php the_field('results_text'); ?></p>
		 <button type="button" class="main-btn results__btn" data-modal-open><?php the_field('programming4kids_btn'); ?></button>
    </div>
  </div>
</section>
