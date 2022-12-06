<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block4_show');
    if( $hide ) return;
}

$title = get_field('block4_title');
$image = get_field('block4_image');
$list = get_field('block4_list');

?>

<section class="learn-profitably">


    <?php if( $title ) { ?>
        <h2 class="sales-section-title sales-section-title--learn-profitably"><?= $title ?></h2>
    <?php } ?>

    <div class="container-sales container-sales--flex-tab">

        <?php if( $image ) { ?>
            <picture class="learn-profitably_img-wrap">
                <?= wp_get_attachment_image( $image, [500, 1000], false, array('class' => 'learn-profitably_img') ) ?>
            </picture>
        <?php } ?>

        <?php if( $list ) { ?>
            <ul class="learn-profitably_list">
                <?php foreach ( $list as $item ) { ?>
                    <li class="learn-profitably_item">
                        <svg  width="84" height="84">
                            <use href="<?= get_template_directory_uri() ?>/assets/images/sales-page/symbol-defs.svg#<?= $item['icon'] ?>"></use>
                        </svg>
                        <h3><?= $item['title'] ?></h3>
                        <p><?= $item['text'] ?></p>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>

    </div>
</section>
