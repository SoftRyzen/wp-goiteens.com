<section class="section during" id="during">
    <div class="during__wrapper">
        <div class="container">
            <h2 class="section__title during__title"><?php the_field('during_title'); ?></h2>
            <p class="text-label during__description"><?php the_field('during_description'); ?></p>
        </div>
    </div>
    <div class="during__content">
        <div class="container">
			<?php $duringList = get_field('during_list');
				if( $duringList ): ?> 
            <ul class="list grid during__list">
                <?php foreach( $duringList as $items ): ?>
                <li class="grid__item during__item">
                    <h3 class="block-title during__item-title"><?php echo "{$items['list_title']}"; ?></h3>
                    <ul class="during__item-list">
                        <?php foreach( $items['items'] as $item ): ?>
                        <li class="during__item-text"><?php echo "{$item['text']}"; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
			</ul>
			<?php endif; ?>
        </div>
    </div>
</section>