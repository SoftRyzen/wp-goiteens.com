<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block2_show');
    if( $hide ) return;
}

$title = get_field('block2_title');
$description = get_field('block2_text');
$timeline = get_field('block2_timeline');
?>

<section class="studding-process">

    <?php if( !empty($title) ) { ?>
        <h2 class="sales-section-title"><?= $title ?></h2>
    <?php } ?>

    <div class="container-sales container-sales--flex-desk">

        <?php if( !empty($description) ) { ?>
            <div class="studding-process_description">
                <?= $description ?>
            </div>
        <?php } ?>

        <?php if( $timeline ) { ?>
            <div class="studding-process_timeline">
                <ul class="studding-process_list-timeline">
                    <?php
                    foreach ( $timeline as $item ) {

                        $rating = '';
                        switch (trim($item['rating'])) {
                            case 0:
                                $rating = '0%';
                                break;
                            case 1:
                                $rating = '20%';
                                break;
                            case 2:
                                $rating = '40%';
                                break;
                            case 3:
                                $rating = '60%';
                                break;
                            case 4:
                                $rating = '80%';
                                break;
                            case 5:
                                $rating = '100%';
                                break;
                        }

                        ?>
                        <li class="studding-process_item-timeline">
                            <h3 class="studding-process_subtitle">
                                <?= $item['title'] ?>
                            </h3>
                            <div class="rating">
                                <div class="rating__box">
                                    <div class="rating__elements">
                                        <div class="rating__active" style="width:<?= $rating ?>;"></div>
                                        <input type="radio"class="rating__elem" value="1" name="rating">
                                        <input type="radio"class="rating__elem" value="2" name="rating">
                                        <input type="radio"class="rating__elem" value="3" name="rating">
                                        <input type="radio"class="rating__elem" value="4" name="rating">
                                        <input type="radio"class="rating__elem" value="5" name="rating">
                                    </div>
                                </div>
                            </div></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

    </div>
</section>
