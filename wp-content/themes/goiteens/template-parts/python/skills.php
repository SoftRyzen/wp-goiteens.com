<section class="section skills">
    <div class="container">
        <h2 class="section__title skills__title"><?php the_field('skills_title'); ?></h2>
        <p class="text-label skills__description"><?php the_field('skills_description'); ?></p>
		<?php $skillsList = get_field('skills_list');
		if( $skillsList ): ?> 
        <ul class="list grid skills__list">           
			<?php foreach( $skillsList as $item ): ?>
            <li class="grid__item skills__item">
                <div class="skills__icon-wrap">
                    <svg class="skills__icon" width="70" height="71">
                        <use href="<?php echo get_template_directory_uri(); ?>/assets/images/python/sprite.svg#skills-<?php echo "{$item['id']}"; ?>"></use>
                    </svg>
                </div>
                <p><?php echo "{$item['text']}"; ?></p>
            </li>
			<?php endforeach; ?>
    	</ul>
		<?php endif; ?>
</section>