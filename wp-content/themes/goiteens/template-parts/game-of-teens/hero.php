<section class="hero hero-js" id="home">
    <div class="container hero__content">
        <?php $dateList = get_field('date_list');
        if ($dateList) : ?>

        <ul class="list text-upper hero__start-list">
            <?php foreach ($dateList as $item) : ?>

            <li class="hero__start-item">

                <svg class="hero__start-icon" width="24" height="24">
                    <use
                        href="<?php echo get_template_directory_uri(); ?>/assets/images/game-of-teens/sprite.svg#<?php echo "{$item['icon']}"; ?>">
                    </use>
                </svg><?php echo "{$item['text']}"; ?>

            </li>
            <?php endforeach; ?>

        </ul>
        <?php endif; ?>

        <h1 class="hero__title"><?php the_field('hero_title'); ?></h1>
        <p class="hero__text"><?php the_field('hero_description'); ?></p>
        <div class="hero__btn-wrapper">
            <?php $btnText = get_field('register_text'); ?>
            <?php $btnClass = "hero__btn"; ?>
            <?php $btnData = "data-modal-open"; ?>
            <?php get_template_part('template-parts/game-of-teens/components/button', null, ['btnText' => $btnText, 'btnClass' => $btnClass, 'btnData' => $btnData]); ?>


            <a class="link main-btn" href="#categories" data-menu-link><?php the_field('categories_text'); ?></a>
        </div>


    </div>
</section>