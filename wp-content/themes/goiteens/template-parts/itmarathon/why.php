<section class="section why">

  <div class="why__wrapper">
    <div class="container">
      <h2 class="section__title why__title"><?php the_field('why_title'); ?></h2>
		<?php $whyList = get_field('why_list');
		if( $whyList ): ?> 
		  <ul class="list grid why__list">
			 <?php foreach( $whyList as $item ): ?>	
			<li class="grid__item why__item">

			  <h3 class="section__subtitle text-accent why__item-title"><?php echo "{$item['title']}"; ?></h3>
			 <?php if( $item['text_list'] ): ?> 
			   <?php foreach( $item['text_list'] as $text ): ?>	
			  <p class="why__item-descript"><?php echo "{$text['text']}"; ?></p>
			   <?php endforeach; ?>
			  <?php endif; ?>
			   <?php if( $item['items_list'] ): ?> 
			  <ul class="list why__item-list">
				<?php foreach( $item['items_list'] as $text ): ?>	
				<li class=" why__item-text">
				  <?php echo "{$text['text']}"; ?>
				</li>
				 <?php endforeach; ?>
			  </ul>
			   <?php endif; ?>
			</li>
			 <?php endforeach; ?>
		  </ul>
		<?php endif; ?>
    </div>
  </div>
</section>