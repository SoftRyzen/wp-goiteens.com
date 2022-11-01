<section class="section develop">
    <div class="container">
        <h2 class="registration__title section__title-accent ">
            <?php the_field('develop_title'); ?>
        </h2>
        <?php $btnText = get_field('registration_btn-text'); ?>
        <?php $btnClass = "registration__btn"; ?>
        <?php $btnData = "data-modal-open"; ?>
        <?php get_template_part('template-parts/game-of-teens/components/button', null, ['btnText' => $btnText, 'btnClass' => $btnClass, 'btnData' => $btnData]); ?>

    </div>
</section>