<section class="section study-principles">
  <div class="container">
    <h2 class="section__title"><?php the_field('study_principles_title'); ?></h2>
	  <?php $studyPrinciplesList = get_field('study_principles_list');
		if( $studyPrinciplesList ): ?> 
    	<ul class="list grid study-principles__list">
		<?php foreach( $studyPrinciplesList as $item ): ?>
      		<li class="item grid__item study-principles__item">
        		<picture>
          			<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/frontend/study-principles/memo<?php echo $item['id']; ?>.webp    1x, 
									<?php echo get_template_directory_uri(); ?>/assets/images/frontend/study-principles/memo<?php echo $item['id']; ?>@2x.webp 2x " media="(min-width: 320px)" type="image/webp" />
					<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/frontend/study-principles/memo<?php echo $item['id']; ?>@2x.png 2x" media="(min-width: 320px)" type="image/png" />
					<img class="study-principles__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/frontend/study-principles/memo<?php echo $item['id']; ?>.png" 
						 alt="<?php echo $item['img_alt']; ?>" width="<?php echo $item['img_width']; ?>" height="<?php echo $item['img_height']; ?>" loading="lazy" />
				</picture>

        		<p class="text__description study-principles__item-text"><?php echo "{$item['text']}"; ?></p>
      		</li>
    <?php endforeach; ?>
	</ul>
	<?php endif; ?>
  </div>
</section>