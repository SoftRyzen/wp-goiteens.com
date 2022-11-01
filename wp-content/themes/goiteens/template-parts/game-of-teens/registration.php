<section class="section registration" id="registration">
    <div class="container">
        <h2 class="registration__title section__title-accent ">
            <?php the_field('registration_title'); ?>
        </h2>
        <p class="registration__text"><?php the_field('registration_descript'); ?></p>

        <?php $btnText = get_field('registration_btn-text'); ?>
        <?php $btnClass = "registration__btn"; ?>
        <?php $btnData = "data-modal-open"; ?>
        <?php get_template_part('template-parts/game-of-teens/components/button', null, ['btnText' => $btnText, 'btnClass' => $btnClass, 'btnData' => $btnData]); ?>
    </div>
</section>