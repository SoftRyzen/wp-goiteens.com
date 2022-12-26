<?php
defined('ABSPATH') || exit;

if (!is_admin()) {
    $hide = get_field('block11_show');
    if ($hide) return;
}

$title = get_field('block11_title');
$list = get_field('block11_list');

?>
<section class="reviews minecraftSwiperReviews">
    <div class="container">
        <?php if ($title) { ?>
            <h2 class="section-title"><?= $title ?></h2>
        <?php } ?>
        <?php if ($list) { ?>
            <div class="swiper">
                <div class="reviews_list swiper-wrapper">
                    <?php foreach ($list as $item) { ?>
                        <div class="swiper-slide">
                            <div class="reviews_item">
                                <?php if ($item['photo']) { ?>
                                    <img class="reviews_img" width="60" height="60" loading="lazy"
                                         alt="<?php echo $item['title'] ? $item['title'] : '' ?> "
                                         src="<?= $item['photo'] ?>"/>
                                <?php } ?>
                                <h3><?= $item['title'] ?></h3>
                                <a href="<?= $item['url'] ?>" class="social-link"><?php _e('Facebook'); ?></a>
                                <?= $item['text']; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        <?php } ?>
    </div>
</section>
