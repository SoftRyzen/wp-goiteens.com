<section class="section how" id="how">

	<div class="how__header-wrapper">
    <div class="how__header">
    	<h2 class="section__title how__header-title"><?php the_field('how_title'); ?></h2>
      	<p class="section__subtitle how__header-text"><?php the_field('how_title_descript'); ?></p>
		<?php 
			$logoList = get_field('logo_list');
			if( $logoList ): ?> 
      		<ul class="list grid how__logo-list">
				<?php foreach( $logoList as $item ): ?>
        			<li class="grid__item how__logo-item">
          				<svg class="company-logo__icon" width="<?php echo "{$item['width']}"; ?>" height="<?php echo "{$item['height']}"; ?>">
            			<use href="<?php echo get_template_directory_uri(); ?>/assets/images/frontend/sprite.svg#icon-<?php echo "{$item['id']}"; ?>"></use>
         				</svg>
        			</li>
      			<?php endforeach; ?>
    		</ul>
		<?php endif; ?>
		<p class="text__description how__header-desc"><?php the_field('how_title_descript2'); ?></p>
    </div>
  </div>
	<div class="container">
	<div class="how__content-wrapper">
		<?php $programList = get_field('program_list');
			if( $programList ): ?> 
			<ul class="list grid how__program-list">
				<?php foreach( $programList as $item ): ?>
					<li class="grid__item how__program-item">
						<h3 class="section__title how__program-title"><?php echo "{$item['title']}"; ?></h3>
						<p class="text__description how__program-text"><?php echo "{$item['text']}"; ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<h2 class="text-label how__formula-label"><?php the_field('formula_title'); ?></h2>
		<?php $formulaList = get_field('formula_list');
			if( $formulaList ): ?> 
      		<ul class="list grid how__formula-list">
		  		<?php foreach( $formulaList as $item ): ?>        
        			<li class="grid__item how__formula-item">
          				<div class="how__formula-circle"><?php echo "{$item['numb']}"; ?></div>
          				<h3 class="section__subtitle how__formula-title"><?php echo "{$item['title']}"; ?></h3>
          				<p class="text__description how__formula-text"><?php echo "{$item['text']}"; ?></p>
        			</li>
       			<?php endforeach; ?>
    		</ul>
		<?php endif; ?>

      <div class="how__slogan">
        <p class="section__subtitle how__slogan-text"><?php the_field('slogan'); ?></p>
        <div class="how__slogan-img"></div>
      </div>
    </div>
  </div>
</section>