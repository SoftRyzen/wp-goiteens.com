<section class="section study" id="study">
  <div class="container">
    <h2 class="section__title"><?php the_field('study_title'); ?></h2>
    <p class="study__subtitle"><?php the_field('study_subtitle'); ?></p>
	<?php $studyList = get_field('study_lists');
	if( $studyList ): ?> 
    <ul class="list grid study__list">
      <?php foreach( $studyList as $list ): ?>
      <li class="item grid__item study__item">
        <h3 class="section__subtitle study__item-title"><?php echo "{$list['title']}"; ?></h3>
        <ul class="list">
           <?php foreach( $list['list'] as $item ): ?>
          <li class="study__item-list"><?php echo "{$item['text']}"; ?></li>
           <?php endforeach; ?>
        </ul>
      </li>
      <?php endforeach; ?>
    </ul>
	<?php endif; ?>
		<?php  $btnText= get_field('free_btn');
		$btnStyle="study__btn main-btn--violet";
		$btnDataModal="data-modal-open"
		?>
	 <?php get_template_part( 'template-parts/itmarathon/components/btn', null, ['btnText' => $btnText, 'btnStyle' => $btnStyle, 'btnDataModal' => $btnDataModal ]  ); ?>
  </div>
</section>