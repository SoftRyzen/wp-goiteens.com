<section class="section lesson">
  <div class="container">
    <h2 class="section__title lesson__title"><?php the_field('lesson_title'); ?></h2>
    <div class="lesson__content">
	<?php $descriptionList = get_field('description_list');
	if( $descriptionList ): ?> 
      <ul class="list grid lesson__list">
       	<?php foreach( $descriptionList as $item ): ?>		
        <li class="grid__item lesson__item">
          <p class="text__description lesson__item-text"><?php echo "{$item['text']}"; ?></p>
        </li>
         <?php endforeach; ?>
      </ul>
		<?php endif; ?>
      <p class="text__description lesson__item-text"><?php the_field('lesson_ description'); ?></p>
      
		<?php  $btnText= get_field('reserve_btn');
		$btnStyle="lesson__btn main-btn--violet";
		$btnDataModal="data-modal-open"
		?>
	 <?php get_template_part( 'template-parts/itmarathon/components/btn', null, ['btnText' => $btnText, 'btnStyle' => $btnStyle, 'btnDataModal' => $btnDataModal ]  ); ?>
    </div>
  </div>
</section>