<section class="section rates">
  <div class="container">
    <h2 class="section__title rates__title"><?php the_field('rates_title'); ?></h2>
    <p class="text-label rates__undertitle"><?php the_field('rates_description'); ?></p>
    <div class="rates-wrapper">
		 <?php $ratesList = get_field('rates_lists'); if( $ratesList ): ?>	
		  <?php foreach ($ratesList as $list): ?>
      <section class="rates-type">
        <h3 class="item__title <?php if( $list['title_style']) echo $list['title_style']; ?>"><?php echo $list['title']; ?></h3>
        <p class="rates-type__price"><?php echo $list['price']; ?></p>
    
        <ul class="list rates-type__list">
         <?php foreach ($list['list'] as $item): ?>
          <li class="rates-type__list--item <?php if( $item['style']) echo $item['style']; ?>"><?php echo $item['text']; ?></li>
           <?php endforeach; ?>
        </ul>
	
        <p class="item__title rates-type__title rates-type__firsttitle"><?php echo $list['duration']; ?></p>
        <p class="item__title rates-type__title"><?php echo $list['start_date']; ?></p>
        <p class="rates-type__description"><?php the_field('rates_info_description'); ?></p>
        <button type="button" class="main-btn main-btn--violet rates__button" data-modal-open>
          <?php the_field('btn_course_text'); ?>
        </button>
      </section>
		
		 <?php endforeach; ?>
		<?php endif; ?>
    </div>
  </div>
</section>
