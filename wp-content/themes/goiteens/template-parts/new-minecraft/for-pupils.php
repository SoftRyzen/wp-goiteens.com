<?php
defined('ABSPATH') || exit;

if (!is_admin()) {
    $hide = get_field('block3_show');
    if ($hide) return;
}

$title = get_field('block3_title');
$under_title_text = get_field('block3_under');
$list = get_field('block3_list');
$icon = get_field('block3_icon');
$yellow_text = get_field('block3_yellow');

?>
<section class="for-pupils">
    <div class="container">
        <?php if ($title) { ?>
            <h2 class="section-title">
                <?= $title ?>
            </h2>
        <?php } ?>
        <?php if ($under_title_text) { ?>
            <p class="text"><?= $under_title_text ?></p>
        <?php } ?>

        <?php if ($list) { ?>
            <ul class="for-pupils_list">
                <?php foreach ($list as $item) { ?>
                    <li class="for-pupils_item">
                        <img alt="bit red heart" width="40" height="32" loading="lazy"
                             src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-1x.png"
                             srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-2x.png 2x"/>
                        <h3><?= $item['title']; ?></h3>
                        <img alt="bit red heart" width="26" height="32" loading="lazy"
                             src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-1x.png"
                             srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-2x.png 2x"/>
                        <p><?= $item['text']; ?></p>
                    </li>
                <?php } ?>

            </ul>
        <?php } ?>
        <div class="for-pupils_info-block">
            <?php if($icon) { ?>
            <svg>

                <use href="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/sprite1.svg#<?= $icon ?>"></use>

            </svg>
            <?php } ?>
            <?php if ($yellow_text) { ?>
                <p><?= $yellow_text ?></p>
            <?php } ?>
        </div>
    </div>
</section>
