<?php
defined('ABSPATH') || exit;

if (!is_admin()) {
    $hide = get_field('block12_show');
    if ($hide) return;
}

$title = get_field('block12_title');
$list = get_field('block12_list');
$text_before_list = get_field('block12_before_text');
$button = get_field('block12_button');

?>
<section class="questions">
    <div class="container">
        <?php if ($title) { ?>
            <h2 class="section-title"><?= $title ?></h2>
        <?php } ?>
        <?php if ($list) { ?>
            <ul class="questions_list">
                <?php foreach ($list as $item) { ?>
                    <li class="questions_item">
                        <h3><?= $item['title'] ?></h3>
                        <p><?= $item['text'] ?></p>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if ($text_before_list) { ?>
            <?= $text_before_list ?>
        <?php } ?>
        <?php if ($button) { ?>
            <button class="main-btn btn_registration" data-modal-open><?= $button ?></button>
        <?php } ?>
    </div>
</section>
