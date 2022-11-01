<section class="section advantage">
    <div class="container advantage__container">

        <h2 class="advantage__title section__title-accent text-accent title-shadow"
            data-text=" <?php the_field('advantage_title'); ?>">
            <?php the_field('advantage_title'); ?>
        </h2>
        <p class="advantage__description"> <?php the_field('advantage_description'); ?></p>
        <?php $advantageList = get_field('advantage_list');
        if( $advantageList ): ?>
        <ul class="list advantage__list">
            <?php foreach( $advantageList as $item ): ?>
            <li class="advantage__item">
                <h3 class="advantage__item-title"><?php echo "{$item['title']}"; ?></h3>
                <p><?php echo "{$item['text']}"; ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>



    </div>
</section>