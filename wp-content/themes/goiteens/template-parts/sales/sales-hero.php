<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block1_show');
    if( $hide ) return;
}

$title = get_field('block1_title');
$image = get_field('block1_image');

?>

<section class="sales-hero">
    <div class="sales-hero__wrapper">
        <div class="container-sales container-sales--hero">

            <?php if( $title ) { ?>
                <h1 class="sales-section-title sales-section-title--hero"><?= $title ?></h1>
            <?php } ?>

            <?php if( $image ) { ?>
                <picture class="sales-hero__img-wrap">
                    <?= wp_get_attachment_image( $image, [500, 1000], false, array('class' => 'sales-hero__img') ) ?>
                </picture>
            <?php } ?>

        </div>
    </div>
</section>
