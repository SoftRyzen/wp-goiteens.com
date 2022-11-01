<section class="section rates">
  <div class="container">
    <h2 class="section__title rates__title"><?php the_field('rates_title');?></h2>
_   <p class="text-label rates__description"><?php the_field('rates_description');?></p>
    <div class="list grid rates__wrapper">
		<?php $unitsList = get_field('units_list');
		if( $unitsList ): ?> 
		<?php foreach( $unitsList as $item ): ?>
      <div class="grid__item rates__unit">
        <h3 class="text-black rates__unit-title"><?php echo "{$item['title']}"; ?></h3>
        <p class="rates__unit-price"><?php echo "{$item['price']}"; ?></p>
		<?php $ratesList = get_field('rates_list');
			if( $ratesList ): ?> 
        <ul class="list rates__list">
			<?php foreach( $ratesList as $items ): ?>
          <li class="rates__item"><?php echo "{$items['text']}"; ?></li>
          <?php endforeach; ?>
		</ul>
		<?php endif; ?>
        <p class="text-black"><?php the_field('duration');?></p>
        <p class="text-black rates__unit-start"><?php echo "{$item['start']}"; ?></p>
        <p class="rates__unit-note"><?php the_field('note');?></p>
        <button type="button" class="main-btn rates__btn main-btn--violet" data-modal-open> <?php echo "{$item['button']}"; ?> </button>
      </div>
      <?php endforeach; ?>
	<?php endif; ?>
    </div>
  </div>
</section>
