<section class="section study-principles">
	<div class="container">
		<h2 class="section__title"><?php the_field('study_principles_title');?></h2>
	  	<?php $study_principlesList = get_field('study_principles_list');
	  	if( $study_principlesList ): ?> 
    		<ul class="list grid study-principles__list">
				<?php foreach( $study_principlesList as $item ): ?>  
      				<li class="item grid__item study-principles__item">
        				<svg class="study-principles__item-icon" width="70" height="73">
							<use href="<?php echo get_template_directory_uri(); ?>/assets/images/python/sprite.svg#icon-<?php echo "{$item['svg_id']}"; ?>"></use>
						</svg>
						<p class="study-principles__item-text"><?php echo "{$item['text']}"; ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
  	</div>
</section>
