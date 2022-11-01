<section class="section rates">
  <div class="container">
    <h2 class="section-title rates__title"><?php the_field('rates_title'); ?></h2>
    <p class="text-label rates__description"><?php the_field('rates_description'); ?></p>
    <div class="list grid rates__wrapper">
     <?php $ratesLists = get_field('rates_units');
	 if( $ratesLists ):
     foreach($ratesLists as $list ): ?>
      <div class="grid__item rates__unit">
        <h3 class="text-black rates__unit-title"><?php echo "{$list['title']}"; ?></h3>
        <p class="rates__unit-price"><?php if($list['title']==="Pro") {the_field('design_price_pro');} else {the_field('design_price_standard');} ?></p>
		   <?php $ratesItems = get_field('rates_items');
	       if( $ratesItems ):?>
        <ul class="list rates__list">
          <?php foreach($ratesItems as $item ): ?>
          <li class="rates__item"><?php echo "{$item['text']}"; ?></li>
            <?php endforeach; ?>
        </ul>
		 <?php endif; ?>

		  <p class="text-black rates__unit-start"><?php the_field('rates_start_text'); ?> <?php if($list['title']==="Pro") {the_field('design_start_pro');} else {the_field('design_start_standard');} ?></p>
        <p class="rates__unit-note"><?php the_field('rates_note'); ?></p>
        <button type="button" class="main-btn rates__btn main-btn--violet" data-modal-open>
         <?php the_field('btn_rates_text'); ?>
        </button>
      </div>
  	  <?php endforeach; ?>
    <?php endif; ?>
    </div>
  </div>
</section>