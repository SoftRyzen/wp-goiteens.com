<section class="section program">
    <div class="container ">
        <h2 class="section-title program__title"><?php the_field('program_title'); ?></h2>
        <p class="program__description"><?php the_field('program_description'); ?></p>
		<?php $programList = get_field('prog_list');?>
        <div class="program__wrapper">
          <?php foreach ($programList as $item): ?>
            <div class="program__content">
                <h3 class="item-title text-blue program__content-title "><?php echo "{$item['item_title']}"; ?></h3>
				
                <ul class="program__content-list">
                   <?php foreach ($item['item_list'] as $item): ?>
                    <li class="program__content-item"><?php echo "{$item['item_text']}"; ?></li>
                   <?php endforeach; ?>
                </ul> 
            </div>
            <?php endforeach; ?> 
        </div>
		<?php get_template_part( 'template-parts/roblox/methodology' ); ?>
    </div>
</section>