<section class="section capability">
    <div class="container">
        <h2 class="section-title capability__title"><?php the_field('capability_title'); ?></h2>
		
		<?php $capabilityList = get_field('capability_list'); ?>
		    <ul class="list grid capability__list">
			<?php foreach ($capabilityList['capability_item'] as $item): ?>
          <li class="grid__item  capability__item"> 
			   <p class="item-title capability__item-text"><?php echo "{$item['capability_text']}"; ?></p>
				   </li>
        <?php endforeach; ?>
		  </ul>
		
        <div class="capability__future">
            <div class="capability__future-wrapper">
                <h3 class="item-title capability__future-title"><?php the_field('future_title'); ?></h3>
                <p><?php the_field('future_description'); ?></p>
            </div>
					
		<?php $futureList = get_field('future_list');?>
		    <ul class="list grid capability__future-list">
			<?php foreach ($futureList['future_items'] as $item): ?>
          <li class="grid__item capability__future-item"> 
			   <p class="capability__future-text"><?php echo "{$item['future_item_text']}"; ?></p>
				   </li>
        <?php endforeach; ?>
		  </ul>
        </div>
    </div>
</section>