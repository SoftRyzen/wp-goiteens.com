<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block5_show');
    if( $hide ) return;
}

$title = get_field('block5_title');
$image = get_field('block5_image');
$description = get_field('block5_text');
$button_title = get_field('block5_button_text');
$button_url = get_field('block5_button_url');
?>

<section class="gift-certificate">
    <div class="container-sales ">

        <?php if( !empty($title) ) { ?>
            <h2 class="sales-section-title "><?= $title ?></h2>
        <?php } ?>

        <div class="gift-certificate__box">

            <?php if( $image ) { ?>
                <picture class="gift-certificate_img-wrap">
                    <?= wp_get_attachment_image( $image, [500, 1000], false, array('class' => 'gift-certificate_img') ) ?>
                </picture>
            <?php } ?>

            <?php if( !empty( $description ) ) { ?>
                <div class="gift-certificate__info">
                    <?= $description ?>
                </div>
            <?php } ?>

        </div>

        <?php if( !empty($button_title) ) { ?>
            <a href="<?= $button_url ?>" class="gift-certificate_order-link"><?= $button_title ?></a>
        <?php } ?>

    </div>
</section>
