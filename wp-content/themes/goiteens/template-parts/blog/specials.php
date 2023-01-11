<?php
$specials = get_field('specials');
if( $specials ) {
    ?>
    <!-- Offers -->
    <section class="offers">

        <!-- container -->
        <div class="container">

            <!-- title -->
            <h2 class="offers-title">
                <?= get_field('specials_title') ?>
            </h2>
            <!-- end title -->

            <!-- list -->
            <ul class="offers-list">
                <li class="offers-item"> <img class="item_img" loading="lazy" alt="design" src="<?= get_template_directory_uri() ?>/assets/images/blog/design-1x.jpg "
        srcset="<?= get_template_directory_uri() ?>/assets/images/blog/design-2x.jpg  2x"/></li>
                <li class="offers-item"> <img class="item_img" loading="lazy" alt="python" src="<?= get_template_directory_uri() ?>/assets/images/blog/python-1x.jpg "
        srcset="<?= get_template_directory_uri() ?>/assets/images/blog/python-2x.jpg  2x"/></li>
                <li class="offers-item"> <img class="item_img" loading="lazy" alt="frontend" src="<?= get_template_directory_uri() ?>/assets/images/blog/frontend-1x.jpg"
        srcset="<?= get_template_directory_uri() ?>/assets/images/blog/frontend-2x.jpg 2x"/></li>
            
            </ul>
            <!-- end list -->

        </div>
        <!-- end container -->

    </section>
    <!-- End Offers -->
<?php } ?>
