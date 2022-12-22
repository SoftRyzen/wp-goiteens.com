<?php
defined('ABSPATH') || exit;

if (!is_admin()) {
    $hide = get_field('block9_show');
    if ($hide) return;
}

$title = get_field('block9_title');
$list = get_field('block9_list');

?>
<section class="methodology">
    <div class="container">
        <?php if ($title) { ?>
            <h2 class="section-title"><?= $title ?></h2>
        <?php } ?>
        <?php if ($list) { ?>
            <ul class="methodology_list">
                <?php foreach ($list as $item) { ?>
                    <li class="methodology_item">
                        <div class="percent-wrap">
                            <h3 class="percent-label"><?= $item['title'] ?></h3>
                        </div>
                        <?php if ($item['list']) { ?>
                            <ul class="methodology_details-list">
                                <?php foreach ($item['list'] as $second_list_item) { ?>
                                    <li class="methodology_details-item">
                                        <?= $second_list_item['text'] ?>
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
