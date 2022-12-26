<?php
defined('ABSPATH') || exit;

if (!is_admin()) {
    $hide = get_field('block6_show');
    if ($hide) return;
}

$title = get_field('block6_title');
$first_list = get_field('block6_first_list');
$second_title = get_field('block6_second_title');
$second_list = get_field('block6_second_list');
$text_before_button = get_field('block6_third_title');
$button = get_field('block6_button_text');

?>
<section class="lessons">
    <div class="container">
        <?php if ($title) { ?>
            <h2 class="section-title"><?= $title ?></h2>
        <?php } ?>
        <?php if ($first_list) { ?>
            <ul class="lessons_list">
                <?php foreach ($first_list as $item) { ?>
                    <li class="lessons_item">
                        <svg width="70" height="70">

                            <use href="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/sprite1.svg#<?= $item['icon'] ?>"></use>

                        </svg>
                        <p><?= $item['text'] ?></p>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>

        <?php if ($second_title) { ?>
            <h3 class="lessons_subtitle"><?= $second_title ?></h3>
        <?php } ?>
        <?php if ($second_list) { ?>
            <ul class="lessons_details-list">
                <?php foreach ($second_list as $item) { ?>
                    <li class="lessons_details-item">
                        <p><?= $item['text'] ?></p>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if ($text_before_button) { ?>
            <strong class="suggestion-block"><?= $text_before_button ?></strong>
        <?php } ?>
        <?php if ($button) { ?>
            <button class="main-btn btn_registration" data-modal-open><?= $button ?></button>
        <?php } ?>
    </div>
</section>
