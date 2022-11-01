<section class="section specialists">
    <div class="container">
        <h2 class="section__title specialists__title"><?php the_field('specialists_title'); ?></h2>
		<?php $specialistsList = get_field('specialists_list');
		if( $specialistsList ): ?> 		
        <ul class="list">
			<?php foreach( $specialistsList as $list ): ?>
            <li class="grid specialists__item">
				<?php if( $list['text_items'] ):?>		
					<div class="grid__item">
						<p class="specialists__item-text"><?php echo "{$list['text']}"; ?></p>
						<ul class="specialists__item-list">
							<?php foreach( $list['text_items'] as $item ): ?>
								<li class="specialists__item-elem"><?php echo "{$item['text']}"; ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php else: ?>
					<p class="grid__item specialists__item-text"><?php echo "{$list['text']}"; ?></p>
				<?php endif; ?>
				<?php if( $list['label'] ): ?>
	<!--                 {% endif %} {% if item.label %} -->

					<p class="grid__item specialists__item-label">
						<span class="specialists__label"><?php echo "{$list['label']}"; ?></span>
						<?php echo "{$list['about']}"; ?>
					</p>
				<?php else: ?>
					<div class="grid__item specialists__img-wrapper">
						<svg class="specialists__img" width="<?php echo "{$list['img_width']}"; ?>" height="<?php echo "{$list['img_height']}"; ?>">
							<use href="<?php echo get_template_directory_uri(); ?>/assets/images/python/sprite.svg#specialists-<?php echo "{$list['id']}"; ?>" />
						</svg>
					</div>
				<?php endif; ?>
            </li>
            <?php endforeach; ?>
    		</ul>
		<?php endif; ?>
    </div>
</section>