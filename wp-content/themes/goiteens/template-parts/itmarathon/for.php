<section class="section for" id="marathon">
    <div class="container">
        <h2 class="section__title for-title"><?php the_field('for_title'); ?></h2>
        <?php $forList = get_field('for_list');
		if( $forList ): ?> 
		<ul class="list grid for__reasons-list">
            <?php foreach( $forList as $item ): ?>
            <li class="grid__item for__reasons-item">
                <p class="text__description for__reasons-text"><?php echo "{$item['text']}"; ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
		<?php endif; ?>
    </div>
</section>