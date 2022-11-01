<section class="section faq">
    <div class="container">
        <h2 class="faq__title  section__title "><?php the_field('faq_title'); ?></h2>
        <?php $faqList = get_field('faq_list');
        if( $faqList ): ?>
        <ul class="list faq__list">
            <?php foreach( $faqList as $item ): ?>
            <li class="faq__item" data-more-wrapper>

                <h3 class="faq__question"><?php echo "{$item['title']}"; ?></h3>

                <button type="button" class="faq__btn" data-show-more aria-label="{{faq.btn_aria_label}}"> <svg
                        class="faq__icon" width="44" height="44">
                        <use
                            href="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/sprite.svg#faq-btn">
                        </use>
                    </svg></button>

                <div class="faq__content visually-hidden " data-more-text>

                    <?php foreach( $item['text_list'] as $text ): ?>
                    <p><?php echo "{$text['text']}"; ?></p>
                    <?php endforeach; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

    </div>
</section>