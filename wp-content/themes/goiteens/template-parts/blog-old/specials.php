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
                <?php foreach ( $specials as $special ) { ?>
                    <li>
                        <a href="<?= $special['url'] ?>">
                            <?php echo wp_get_attachment_image($special['image'], [370, 370], '', ['class' => 'offers-image', 'title' => $special['title'], 'alt' => $special['title'] ]) ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <!-- end list -->

        </div>
        <!-- end container -->

    </section>
    <!-- End Offers -->
<?php } ?>
