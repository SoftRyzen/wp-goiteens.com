<section class="section free-lesson">
  <div class="container">
    <div class="free-lesson__wrapper">
      <h2 class="section-title free-lesson__title"><?php the_field('all_free_lesson_title'); ?></h2>
<?php $freeLessonList= get_field('all_free_lesson_list');
	  if($freeLessonList): ?>
      <ul class="free-lesson__list list">
        <?php foreach($freeLessonList as $key=> $item): ?>
        <li class="free-lesson__list-item"><?php echo"{$item['text']}" ;?></li>
       <?php endforeach ;?>
      </ul>
	<?php endif ;?>
    </div>
    <div class="free-lesson__blue-wrapper">
      <h3 class="item-title free-lesson__subtitle"><?php the_field('all_free_lesson_subtitle'); ?></h3>
      <div>
<?php $freeLessonLabels= get_field('all_free_lesson_labels');
	  if($freeLessonLabels): ?>
        <ul class="free-lesson__labels list">
          <?php foreach($freeLessonLabels as $key=> $item): ?>
          <li class="free-lesson__label-item"><?php echo"{$item['text']}" ;?></li>
          <?php endforeach ;?>
        </ul>
	<?php endif ;?>
		<?php $btnType= "button";
		$btnClass= "free-lesson__btn";
		$btnText= get_field('all_free_lesson_text');
		  $btnData= "data-modal-open";
		?>
	 <?php get_template_part( 'template-parts/courses-all/components/btn', null, ['btnType' => $btnType, 'btnClass' => $btnClass, "btnData" => $btnData, "btnText" => $btnText ]  ); ?> 
		  
      </div>
    </div>
  </div>
</section>