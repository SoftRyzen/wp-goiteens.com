<?php
defined('ABSPATH') || exit;

if (!is_admin()) {
    $hide = get_field('block10_show');
    if ($hide) return;
}

$title = get_field('block10_title');
$first_title = get_field('block10_first_title');
$first_text = get_field('block10_first_text');
$first_image = get_field('block10_first_photo');
$list = get_field('block10_list');

?>
<section class="programme">
    <div class="container">
        <?php if ($title) { ?>
            <h2 class="section-title"><?= $title ?></h2>
        <?php } ?>
        <?php if ($list) { ?>
            <ul class="programme_list">
                <li class="programme_item">
                    <?php if ($first_title) { ?>
                        <h3><?= $first_title ?></h3>

                    <?php } ?>
                    <?php if ($first_text) { ?>
                        <p>  <?= $first_text ?></p>
                    <?php } ?>
                    <?php if ($first_title) { ?>
                        <img class="programme_img" width="83" height="171" loading="lazy"
                             alt=""
                             src=" <?= $first_image ?>"
                             srcset="<?= $first_image ?> 2x"/>

                    <?php } ?>
                </li>
                <?php foreach ($list as $item) { ?>
                    <li class="programme_item">
                        <?php if ($item['list']) { ?>
                            <ul class="programme_details-list">
                                <?php foreach ($item['list'] as $second_list_item) { ?>
                                    <li class="programme_details-item">
                                        <h3><?=$second_list_item['title']?></h3>
                                        <p><?=$second_list_item['text']?></p>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</section>
