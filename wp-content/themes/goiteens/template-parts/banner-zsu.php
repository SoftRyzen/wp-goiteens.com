<section class="banner">
    <div class="container">
        <div class="banner-wrapper">
            <div class="banner-box">
                <h2 class="banner-box__title"><?php the_field('banner_title');?></h2>
                <img class="banner-box__icon" src=" <?php echo get_template_directory_uri(); ?>/assets/images/components/banner/icon-ukraine.svg"
                    alt="icon-ukraine">
            </div>
            <p class="banner-wrapper__text"><?php the_field('banner_text');?></p>
        </div>
    </div>
</section>

