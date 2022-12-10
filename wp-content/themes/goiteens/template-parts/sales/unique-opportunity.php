<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block6_show');
    if( $hide ) return;
}

$title = get_field('block6_title');
$list = get_field('block6_list');
?>

<section class="unique-opportunity">
    <div class="container-sales ">

        <?php if( !empty($title) ) { ?>
        <h2 class="sales-section-title sales-section-title__unique-opportunity"><?= $title ?></h2>
        <?php } ?>

        <?php if( $list ) { ?>
            <ul class="unique-opportunity_list">

                <?php foreach ( $list as $item ) { ?>
                    <li class="unique-opportunity_item">
                        <svg>

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
