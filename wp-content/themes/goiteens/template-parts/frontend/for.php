<section class="section for">
    <div class="container">
        <h2 class="section__title for-title"><?php the_field('for_title'); ?></h2>
		<?php 
			$reasonList = get_field('reasons_list');
			if( $reasonList ): ?> 
        	<ul class="list grid for__reasons-list">
				<?php foreach( $reasonList as $item ): ?>
            	<li class="grid__item for__reasons-item">
                	<p class="text__description for__reasons-text"><?php echo "{$item['text']}"; ?></p>
            	</li>
           	<?php endforeach; ?>
    		</ul>
		<?php endif; ?>
    </div>
</section>