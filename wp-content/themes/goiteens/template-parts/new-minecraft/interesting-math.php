<?php
defined('ABSPATH') || exit;

if (!is_admin()) {
    $hide = get_field('block4_show');
    if ($hide) return;
}

$title = get_field('block4_title');
$text_before_title = get_field('block4_text_before_title');
$main_text = get_field('block4_text');
$main_image = get_field('block4_image');
$list = get_field('block4_list');
$purple_title = get_field('block4_purple_title');
$purple_text = get_field('block4_purple_text');
$review = get_field('block4_review');
$title_before_review = get_field('block4_before_review');
$text_before_review = get_field('block4_text_before_review');
$button = get_field('block4_button_text');
$purple_image = get_field('block4_purple_image');

?>
<section class="int-math">
    <div class="container">
        <?php if ($title) { ?>
            <h2 class="section-title">
                <?= $title ?>
            </h2>
        <?php } ?>
        <div class="int-math_box">
            <div class="box-content">
                <?php if ($text_before_title) { ?>
                    <h3 class="int-math_subtitle"><?= $text_before_title ?></h3>
                <?php } ?>
                <?php if ($main_text) { ?>
                    <?= $main_text ?>
                <?php } ?>
                <?php if ($list) { ?>
                    <ul class="int-math_year-list">
                        <?php foreach ($list as $item) { ?>
                            <li class="int-math_year-item">
                                <h4><?= $item['title'] ?></h4>
                                <p><?= $item['text'] ?></p>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
            <?php if ($main_image) { ?>
                <picture class="int-math_img-wrap">
                    <source media="(min-width: 1280px)" type="image/png" srcset="
        <?= $main_image ?> 1x,
         <?= $main_image ?> 2x" width="448"
                            height="382"/>
                    <source media="(min-width: 768px)" type="image/png" srcset="
         <?= $main_image ?> 1x,
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/couple-tab-2x.png 2x" width="335" height="287"/>
                    <img class="int-math_img" width="272" height="233" loading="lazy" alt=""
                         src="<?= $main_image ?>"
                         srcset="<?= $main_image ?> 2x"/>

                </picture>
            <?php } ?>
        </div>

        <div class="int-math_info-wrapper">
            <?php if ($purple_image) { ?>
                <picture class="int-math_img-wrap">
                    <source media="(min-width: 1280px)" type="image/png" srcset="
        <?= $purple_image ?> 1x,
        <?= $purple_image ?> 2x" width="455" height="384"/>

                    <source media="(min-width: 768px)" type="image/png" srcset="
        <?= $purple_image ?> 1x,
        <?= $purple_image ?> 2x" width="315" height="268"/>

                    <img class="int-math_img" width="181" height="154" loading="lazy" alt="Дерево в майнкрафті"
                         src="<?= $purple_image ?>"
                         srcset="<?= $purple_image ?>2x"/>

                </picture>
            <?php } ?>
            <div class="info-wrapper_content">
                <?php if ($purple_title) { ?>
                    <h3 class="info-subtitle"> <?= $purple_title ?></h3>
                <?php } ?>
                <?php if ($purple_text) { ?>
                    <?= $purple_text ?>
                <?php } ?>
            </div>
        </div>
        <?php if ($review) { ?>
            <div class="info-box">
                <?= $review ?>
            </div>
        <?php } ?>
        <?php if ($title_before_review) { ?>
            <h3 class="subtitle-blog"><?= $title_before_review ?></h3>
        <?php } ?>
        <?php if ($text_before_review) { ?>
            <strong><?= $text_before_review ?></strong>
        <?php } ?>
        <?php if ($button) { ?>
            <button class="main-btn btn_registration" data-modal-open><?= $button ?></button>
        <?php } ?>
    </div>
</section>
