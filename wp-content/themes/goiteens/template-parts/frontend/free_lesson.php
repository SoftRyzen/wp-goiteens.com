<?php $euPage=strpos($_SERVER['REQUEST_URI'], '-eu');?>
<section class="section free-lesson">
  <div class="container">
    <h2 class="section__title free-lesson__title"><?php the_field('free_lesson_title'); ?></h2>
    <p class="section__subtitle free-lesson__subtitle"><?php the_field('free_lesson_subtitle'); ?></p>
	<?php $free_lessonList = get_field('free_lesson_list');
		if( $free_lessonList ): ?> 
    	<ul class="list grid free-lesson__list">
		<?php foreach( $free_lessonList as $item ): ?>
      		<li class="grid__item text__description free-lesson__item">
        		<p><?php echo "{$item['text']}"; ?></p>
      		</li>
      	<?php endforeach; ?>
		</ul>
	<?php endif; ?>
  </div>
  <div class="free-lesson__wrapper">
    <div class="container">
      <p class="text__description free-lesson__description"><?php the_field('free_lesson_description'); ?></p>
		<button type="button" class="main-btn free-lesson__btn btn-icon main-btn--violet" data-modal-open><?php $euPage ? the_field('button_eu') : the_field('button'); ?></button>
    </div>
  </div>
</section>