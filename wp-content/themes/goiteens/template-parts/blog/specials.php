<?php
$specials = get_field('specials');
if( $specials ) {
    ?>
    <!-- Offers -->
    <section class="offers">
        <div class="container">

            <?php
            echo sprintf( __( '<h2 class="offers-title">%s<br>%s</h2>', 'goiteens' ), 'Спеціальні пропозиції для читачів', 'GoITeens Journal' );
            ?>

            <ul class="offers-list">
                <?php foreach ( $specials as $special ) { ?>
                    <li>
                        <a href="<?= $special['url'] ?>">
                            <?php echo wp_get_attachment_image($special['image'], [370, 370], '', ['class' => 'offers-image', 'title' => $special['title'], 'alt' => $special['title'] ]) ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </section>
    <!-- End Offers -->
<?php } ?>
