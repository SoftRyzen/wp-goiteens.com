<section class="section program">
    <div class="container program__wrapper">
        <h2 class="section-title program__title"><?php the_field('program_title'); ?></h2>
		
       <?php $programList = get_field('program_lists');?>
		<?php foreach ($programList['program_item'] as $item): ?>
        <div class="program__content program__content-<?php echo "{$item['wrapper_id']}"; ?>">
            <h3 class="item-title text-accent program__content-title "><?php echo "{$item['item_title']}"; ?></h3>
			
            <ul class="program__content-list">
				<?php foreach ($item['item_list']['item'] as $item): ?>
             
                <li class="program__content-item"><?php echo "{$item['item_text']}"; ?></li>
               
				 <?php endforeach; ?>
            </ul>
			
        </div>
           <?php endforeach; ?>
		
        <p class="program__description"><?php the_field('program_description'); ?></p>
    </div>
</section>