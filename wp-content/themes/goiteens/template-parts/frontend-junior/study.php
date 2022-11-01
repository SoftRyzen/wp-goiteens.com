<section class="section study">
  <div class="container">
    <h2 class="section__title"><?php the_field('study_title'); ?></h2>
    <p class="study__subtitle"><?php the_field('subtitle'); ?></p>
	
		<ul class="list grid study__list">
		  <li class="item grid__item study__item">
			<h3 class="section__subtitle study__item-title"><?php the_field('first_list_title'); ?></h3>
			  <?php 
				$firstList = get_field('first_list');
				if( $firstList ): ?> 
					<ul class="list">
					  <?php foreach( $firstList as $item ): ?>
					  <li class="study__item-list"><?php echo "{$item['text']}"; ?></li>
					 <?php endforeach; ?>
					</ul>
				<?php endif; ?>
		  </li>

		  <li class="item grid__item study__item">
			<h3 class="section__subtitle study__item-title"><?php the_field('second_list_title'); ?></h3>
			<?php 
				$secondList = get_field('second_list');
				if( $secondList ): ?> 
			  <ul class="list">
			  <?php foreach( $secondList as $item ): ?>
			  	<li class="study__item-list"><?php echo "{$item['text']}"; ?></li>
			  <?php endforeach; ?>
				</ul>
			<?php endif; ?>
		  </li>
		</ul>
	  <button type="button" class="main-btn study__btn btn-icon main-btn--violet" data-modal-open><?php the_field('button'); ?></button>
<!--     {{macro.btn(button, "study__btn btn-icon main-btn--violet", "data-modal-open")}} -->
  </div>
</section>