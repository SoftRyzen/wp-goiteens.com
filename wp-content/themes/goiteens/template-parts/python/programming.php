<section class="section programming">
  <div class="container">
    <h2 class="section__title programming__title"><?php the_field('programming_title'); ?></h2>

    <div class="grid programming__wrapper">
      <div class="grid__item">
        <p class="text-label programming__list-title"><?php the_field('list_title'); ?></p>
		  <?php $programmingList = get_field('programming_list');
			if( $programmingList ): ?> 
			<ul class="list grid programming__list">
				<?php foreach( $programmingList as $item ): ?>
			  <li class="grid__item programming__item"><?php echo "{$item['text']}"; ?></li>
			 <?php endforeach; ?>
			</ul>
		<?php endif; ?>
      </div>
      <div class="grid__item programming__label">
        <svg class="programming__img" width="143" height="37">
          <use href="<?php echo get_template_directory_uri(); ?>/assets/images/python/sprite.svg#logo-white" />
        </svg>
        <p class="programming__text"><?php the_field('programming_text'); ?></p>
		<button type="button" class="main-btn programming__btn btn-icon main-btn--violet" data-modal-open><?php the_field('header_button'); ?></button>
      </div>
    </div>
  </div>
</section>