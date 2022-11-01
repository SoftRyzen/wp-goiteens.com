<section class="section lesson">
  <div class="container">
    <h2 class="section__title lesson__title"><?php the_field('lesson_title'); ?></h2>
    <div class="lesson__content">
		<?php $lessonList = get_field('lesson_list');
		if( $lessonList ): ?> 
      	<ul class="list grid lesson__list">
			<?php foreach( $lessonList as $item ): ?>
        		<li class="grid__item lesson__item">
          		<p class="text__description lesson__item-text"><?php echo "{$item['text']}"; ?></p>
        		</li>
      		<?php endforeach; ?>
		</ul>
		<?php endif; ?>
      <p class="text__description lesson__item-text"><?php the_field('lesson_description'); ?></p>
      <button type="button" class="main-btn lesson__btn main-btn--violet" data-modal-open> <?php the_field('lesson_button'); ?></button>
    </div>
  </div>
</section>