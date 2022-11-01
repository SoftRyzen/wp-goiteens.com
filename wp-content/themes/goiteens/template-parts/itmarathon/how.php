<section class="section how" id="how">
  <div class="container">
    <h2 class="section__title how__title"><?php the_field('how_title'); ?></h2>
	  <?php $howList = get_field('how_formula_list');
	  if( $howList ): ?> 
    <ul class="list grid how__formula-list">
     <?php foreach( $howList as $item ): ?>	
      <li class="grid__item how__formula-item">
        <div class="how__formula-circle"><?php echo "{$item['numb']}"; ?></div>
        <h3 class="section__subtitle how__formula-title"><?php echo "{$item['title']}"; ?></h3>
        <p class="text__description how__formula-text"><?php echo "{$item['text']}"; ?></p>
      </li>
     <?php endforeach; ?>
    </ul>
<?php endif; ?>
    <div class="how__slogan">
      <p class="section__subtitle how__slogan-text"><?php the_field('how_slogan'); ?></p>
    </div>
  </div>

</section>