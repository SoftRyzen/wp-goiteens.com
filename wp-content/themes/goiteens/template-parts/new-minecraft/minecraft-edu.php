<?php
defined('ABSPATH') || exit;

if (!is_admin()) {
    $hide = get_field('block5_show');
    if ($hide) return;
}

$title = get_field('block5_title');
$yellow_picture = get_field('block5_yellow_picture');
$yellow_picture_webp = get_field('block5_yellow_picture_webp');
$yellow_title = get_field('block5_yellow_title');
$yellow_text = get_field('block5_yellow_text');
$text_after_title = get_field('block5_text_after_title');
$list = get_field('block5_list');

?>
<section class="minecraft-edu">
    <div class="container">
        <div class="minecraft-edu_info-wrapper">
            <?php if ($yellow_picture) { ?>
                <picture class="img-wrap">
                    <source media="(min-width: 1280px)" type="image/png" srcset="
        <?= $yellow_picture ?> 1x,
        <?= $yellow_picture ?> 2x" width="568"
                            height="349"/>

                    <source media="(min-width: 1280px)" type="image/webp" srcset="
        <?= $yellow_picture_webp ?> 1x,
        <?= $yellow_picture_webp ?> 2x" width="568"
                            height="349"/>

                    <source media="(min-width: 768px)" type="image/png" srcset="
        <?= $yellow_picture ?>1x,
        <?= $yellow_picture ?> 2x" width="316"
                            height="198"/>

                    <source media="(min-width: 768px)" type="image/webp" srcset="
       <?= $yellow_picture_webp ?> 1x,
        <?= $yellow_picture_webp ?> 2x" width="316"
                            height="198"/>

                    <img class="item_img" width="240" height="151" loading="lazy" alt="minecraft logo"
                         src="<?= $yellow_picture ?>"
                         srcset="<?= $yellow_picture ?>"/>
                </picture>
            <?php } ?>


            <div class="box-content">
                <?php if ($yellow_title) { ?>
                    <h3><?= $yellow_title ?></h3>
                <?php } ?>
                <?php if ($yellow_text) { ?>
                    <?= $yellow_text ?>
                <?php } ?>
            </div>
        </div>
        <?php if ($title) { ?>
            <h2 class="section-title"><?= $title ?></h2>
        <?php } ?>
        <?php if ($text_after_title) { ?>
            <?= $text_after_title ?>
        <?php } ?>


        <?php if ($list) {
        $i = 1; ?>
        <?php foreach ($list as $item) {
            $image = $item['image'];
            $title = $item['title'];
            $subtitle = $item['subtitle'];
            ?>
            <div class="minecraft-edu_box">
                <?php if ($i % 2 != 0) { ?>
                    <div class="box-content">
                        <?php if ($title) { ?>
                            <h3 class="box-content_subtitle"><?= $title ?></h3>
                        <?php } ?>
                        <?php if ($subtitle) { ?>
                            <p class="box-content_text"><?= $subtitle ?></p>
                        <?php } ?>
                        <?php if ($item['list']) { ?>
                            <ul class="minecraft-edu_list">
                                <?php foreach ($item['list'] as $second_item) { ?>
                                    <li class="minecraft-edu_item minecraft-edu_item--objects"><?= $second_item['text'] ?></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <?php if ($image) { ?>
                        <picture class="img-wrap">
                            <source media="(min-width: 1280px)" type="image/png" srcset="
        <?= $image ?> 1x,
        <?= $image ?> 2x" width="589"
                                    height="392"/>

                            <source media="(min-width: 1280px)" type="image/webp" srcset="
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-desk-1x.webp 1x,
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-desk-2x.webp 2x" width="589"
                                    height="392"/>

                            <source media="(min-width: 768px)" type="image/png" srcset="
        <?= $image ?> 1x,
        <?= $image ?> 2x" width="336"
                                    height="256"/>

                            <source media="(min-width: 768px)" type="image/webp" srcset="
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-tab-1x.webp 1x,
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-tab-2x.webp 2x" width="336"
                                    height="256"/>

                            <img class="item_img" width="272" height="208" loading="lazy" alt="coliseum in minecraft"
                                 src="<?= $image ?>"
                                 srcset="<?= $image ?> 2x"/>
                        </picture>
                    <?php } ?>
                <?php } else { ?>
                    <picture class="img-wrap">
                        <source media="(min-width: 1280px)" type="image/png" srcset="
        <?= $image ?> 1x,
        <?= $image ?> 2x" width="589"
                                height="392"/>

                        <source media="(min-width: 1280px)" type="image/webp" srcset="
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-desk-1x.webp 1x,
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-desk-2x.webp 2x" width="589"
                                height="392"/>

                        <source media="(min-width: 768px)" type="image/png" srcset="
        <?= $image ?> 1x,
        <?= $image ?> 2x" width="336"
                                height="256"/>

                        <source media="(min-width: 768px)" type="image/webp" srcset="
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-tab-1x.webp 1x,
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-tab-2x.webp 2x" width="336"
                                height="256"/>

                        <img class="item_img" width="272" height="208" loading="lazy" alt="coliseum in minecraft"
                             src="<?= $image ?>"
                             srcset="<?= $image ?> 2x"/>
                    </picture>
                    <div class="box-content">
                        <?php if ($title) { ?>
                            <h3 class="box-content_subtitle"><?= $title ?></h3>
                        <?php } ?>
                        <?php if ($subtitle) { ?>
                            <p class="box-content_text"><?= $subtitle ?></p>
                        <?php } ?>
                        <?php if ($item['list']) { ?>
                            <ul class="minecraft-edu_list">
                                <?php foreach ($item['list'] as $second_item) { ?>
                                    <li class="minecraft-edu_item minecraft-edu_item"><?= $second_item['text'] ?></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <?php $i++;
        } ?>
    </div>
    <?php } ?>

</section>
