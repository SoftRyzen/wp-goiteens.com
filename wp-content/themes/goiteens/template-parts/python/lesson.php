<section class="section lesson">
  <div class="container lesson__title-wrapper">
    <h2 class="section__title lesson__title"><?php the_field('lesson_title');?></h2>
    <p class="text-label lesson__description"><?php the_field('lesson_description');?></p>
  </div>
  <div class="lesson__wrapper">
    <div class="container">
      <div class="lesson__content">
        <div class="lesson__side">
			<?php $lessonList = get_field('lesson_list');
			if( $lessonList ): ?> 
			  	<ul class="list lesson__list">
				  	<?php foreach( $lessonList as $item ): ?>
					<li class="lesson__item"><?php echo "{$item['text']}"; ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
        </div>
        <picture class="lesson__img-wrapper">
          <source srcset="
						  <?php echo get_template_directory_uri(); ?>/assets/images/python/lesson/boy_lg.webp 1x, 
						  <?php echo get_template_directory_uri(); ?>/assets/images/python/lesson/boy_lg@2x.webp 2x" type="image/webp" />
          <img srcset="<?php echo get_template_directory_uri(); ?>/assets/images/python/lesson/boy_lg.jpg 1x, 
					   <?php echo get_template_directory_uri(); ?>/assets/images/python/lesson/boy_lg@2x.jpg 2x"
			   src="<?php echo get_template_directory_uri(); ?>/assets/images/python/lesson/boy_lg.jpg"
			   class="lesson__img" alt="<?php the_field('lesson_img_alt');?>" width="470" height="519" loading="lazy" />
        </picture>
      </div>
    </div>
  </div>
</section>
