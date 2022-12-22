<?php
defined('ABSPATH') || exit;

if (!is_admin()) {
    $hide = get_field('block8_show');
    if ($hide) return;
}

$title = get_field('block8_title');
$list = get_field('block8_list');
$awards_text = get_field('block8_awards_text');
$awards_list = get_field('block8_awards_list');
$review = get_field('block8_review');

?>
<section class="ten-reasons">
    <div class="container">
        <?php if ($title) { ?>
            <h2 class="section-title"><?= $title ?></h2>
        <?php } ?>
        <?php if ($list) { ?>
            <ul class="ten-reasons_list">
                <?php foreach ($list as $item) { ?>
                    <li class="ten-reasons_item">
                        <h3><?= $item['title'] ?></h3>
                        <p><?= $item['text'] ?></p>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if ($awards_text) { ?>
            <p class="ten-reasons_info"><?= $awards_text ?></p>
        <?php } ?>
        <?php if ($awards_list) { ?>
            <ul class="awards_list">
                <?php foreach ($awards_list as $item) {

                    ?>
                    <li class="awards_item">
                        <img src="<?= $item['icon'] ?>" alt="">
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if ($review) { ?>
            <div class="info-box">
                <?= $review ?>
            </div>
        <?php } ?>
    </div>
</section>
