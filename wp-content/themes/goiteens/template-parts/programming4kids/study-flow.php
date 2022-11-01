<section class="section study-flow">
  <div class="container">
    <h2 class="section-title study-flow__title"><?php the_field('study_title'); ?></h2>
	  
	  <?php $studyList = get_field('study_list'); ?>
    <ul class="list grid study-flow__list">
     <?php foreach ($studyList['study_item'] as $item): ?>
      <li class="grid__item study-flow__item">
        <h3 class="item-title study-flow__item-title"><?php echo "{$item['study_item_title']}"; ?></h3>
        <p class="study-flow__item-text"><?php echo "{$item['study_item_text']}"; ?></p>
      </li>
    <?php endforeach; ?>
    </ul>
    <div class="study-flow__wrapper">
      <p class="study-flow__description"><?php the_field('study_description'); ?></p>

		<?php get_template_part( 'template-parts/programming4kids/study-flow_svg' ); ?>

    </div>
  </div>
</section>
