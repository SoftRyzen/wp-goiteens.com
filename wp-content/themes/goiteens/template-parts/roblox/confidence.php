<section class="section confidence">
    <div class="container ">
        <div class="confidence__wrapper ">
            <div class="confidence__title-wrapper ">
                <h2 class="section-title text-green confidence__title"><?php the_field('confidence_title'); ?></h2>
				<button type="button" class="main-btn confidence__btn" data-modal-open>
            <?php the_field('roblox_free_btn'); ?>
           </button>
            </div>
            <picture class="confidence__img-wrapper ">

                <source srcset="
                          <?php echo get_template_directory_uri(); ?>/assets/images/roblox/confidence/girl.webp    1x,
                          <?php echo get_template_directory_uri(); ?>/assets/images/roblox/confidence/girl@2x.webp 2x
                        " media="(min-width: 280px)" type="image/webp" />

                <source srcset=" <?php echo get_template_directory_uri(); ?>/assets/images/roblox/confidence/girl@2x.jpg 2x" media="(min-width: 280px)"
                    type="image/png" />
                <img class="confidence__img" src=" <?php echo get_template_directory_uri(); ?>/assets/images/roblox/confidence/girl.png" alt="<?php the_field('confidence_img_alt'); ?>"
                    width="500" height="464" loading="lazy" />
            </picture>
        </div>
    </div>
</section>