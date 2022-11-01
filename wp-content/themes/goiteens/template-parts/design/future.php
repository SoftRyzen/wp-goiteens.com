<section class="section future">
    <div class="container">
        <h2 class="section-title future__title"><?php the_field('future_title'); ?></h2>
 <?php $futureList = get_field('future_list');
		if( $futureList ): ?>
   
        <ul class="list grid future__list">
             <?php foreach($futureList as $key=>$item ): ?>
            <li class="grid__item future__item">
                <div class="future__icon-wrap">
                    <svg class="future__icon" width="48" height="48">
                        <use href="<?php echo get_template_directory_uri(); ?>/assets/images/design/sprite.svg#future-<?php echo $key+1; ?>"></use>
                    </svg>
                </div>
                <p><?php echo "{$item['future_item_text']}"; ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
<?php endif; ?>
    </div>
</section>