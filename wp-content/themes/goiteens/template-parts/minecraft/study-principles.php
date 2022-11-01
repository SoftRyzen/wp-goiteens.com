<section class="section study-principles">
  <div class="container">
    <h2 class="section__title"><?php the_field('principles_title');?></h2>
	<?php $principlesList = get_field('principles_list');
	if( $principlesList ): ?>
		<ul class="list grid study-principles__list">
		  <?php foreach( $principlesList as $item ): ?>
		  <li class="item grid__item study-principles__item">
			<svg class="study-principles__item-icon" width="70" height="73">
			  <use href="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/sprite.svg#icon-study-<?php echo "{$item['id']}"; ?>"></use>
			</svg>
			<p class="study-principles__item-text"><?php echo "{$item['description']}"; ?></p>
			<div class="mask1"></div>
		  </li>
		  <?php endforeach; ?>
		</ul>
	  <?php endif; ?>
  </div>
</section>
