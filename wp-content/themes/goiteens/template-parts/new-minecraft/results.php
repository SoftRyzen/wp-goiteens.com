<?php
defined('ABSPATH') || exit;

if (!is_admin()) {
    $hide = get_field('block7_show');
    if ($hide) return;
}

$title = get_field('block7_title');
$first_list = get_field('block7_first_list');
$title_after_list = get_field('block7_second-title');
$second_list = get_field('block7_second_list');
$review = get_field('block7_review');
$text_before_review = get_field('block7_before_review');
$button = get_field('block7_button');

?>
<section class="results">
    <div class="container">
        <?php if ($title) { ?>
            <h2 class="section-title"><?= $title ?></h2>
        <?php } ?>
        <?php if ($first_list) { ?>
            <ul class="results_list">
                <?php foreach ($first_list as $item) { ?>
                    <li class="results_item">

                        <svg class="results_icon">

                            <use href="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/sprite1.svg#<?= $item['icon'] ?>"></use>

                        </svg>
                        <div>
                            <h4><?= $item['title'] ?></h4>
                            <p><?= $item['text'] ?></p>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if ($title_after_list) { ?>
            <h3 class="subtitle-blog">
                <?= $title_after_list ?>
            </h3>
        <?php } ?>
        <?php if ($second_list) { ?>
            <ul class="results_development-list">
                <?php foreach ($second_list as $item) { ?>
                    <li class="results_development-item">
                        <p><?= $item['text'] ?></p>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if ($review) { ?>
            <div class="info-box">
                <?= $review ?>
            </div>
        <?php } ?>
        <?php if ($text_before_review) { ?>
            <?= $text_before_review ?>
        <?php } ?>
        <?php if ($button) { ?>
            <button class="main-btn btn_registration" data-modal-open><?= $button ?></button>
        <?php } ?>
    </div>
</section>
