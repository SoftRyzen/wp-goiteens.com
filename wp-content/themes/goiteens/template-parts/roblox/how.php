
<section class="section-accent how">
    <div class="container ">
        <h2 class="section-title how__title"><?php the_field('how_title'); ?></h2>
		<?php $howList = get_field('how_list');?>
        <ul class="list grid how__list ">
             <?php foreach ($howList as $item): ?>
            <li class="grid__item how__item  ">
                <p><?php echo "{$item['item_text']}"; ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="how__btn-wrapper">
            <p class="item-title text-green how__sub-title"><?php the_field('how_sub_title'); ?></p>
			 <button type="button" class="main-btn how__btn" data-modal-open><?php the_field('roblox_booking_btn'); ?></button>
        </div>
    </div>
</section>