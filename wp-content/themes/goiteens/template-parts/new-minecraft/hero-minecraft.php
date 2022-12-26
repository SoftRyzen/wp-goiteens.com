<?php
defined('ABSPATH') || exit;

if (!is_admin()) {
    $hide = get_field('block1_show');
    if ($hide) return;
}

$title = get_field('block1_title');
$yellow_test = get_field('block1_yellow_text');
$text_over_title = get_field('block1_over_text');
$text_before_title = get_field('block1_text_before_title');
$button_text = get_field('block1_button_text');

?>
<section class="hero-nm">
    <div class="container">
        <div class="hero-nm_marked">
            <?php if ($yellow_test) { ?>
                <p class="hero-nm_marked-text"><?= $yellow_test ?></p>
            <?php } ?>
        </div>
        <?php if ($text_over_title) { ?>
            <p class="hero-nm_start--info"><?= $text_over_title ?></p>
        <?php } ?>
        <?php if ($title) { ?>
            <h1 class="hero-nm_page-title">
                <?= $title ?>
            </h1>
        <?php } ?>
        <?php if ($text_before_title) { ?>
            <p class="hero-nm_try-free"><?= $text_before_title ?></p>
        <?php } ?>
        <?php if ($button_text) { ?>
            <button class="main-btn btn_registration" data-modal-open><?= $button_text ?></button>
        <?php } ?>
    </div>
</section>