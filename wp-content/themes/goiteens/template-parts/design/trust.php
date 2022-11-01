<section class="section trust">
    <div class="container">
        <h2 class="section-title trust__title"><?php the_field('trust_title'); ?></h2>
 <?php $trustList = get_field('trust_list');
		if( $trustList ): ?>
   
        <ul class="list grid trust__list">
            <?php foreach( $trustList as $key=>$item ): ?>
            <li class="grid__item trust__item">
                <div class="trust__icon-wrap">
                    <svg class="trust__icon" width="48" height="48">
                        <use href="<?php echo get_template_directory_uri(); ?>/assets/images/design/sprite.svg#trust-<?php echo $key+1; ?>"></use>
                    </svg>
                </div>
                <p><?php echo "{$item['trust_item_text']}"; ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
 <?php endif; ?>
    </div>
</section>