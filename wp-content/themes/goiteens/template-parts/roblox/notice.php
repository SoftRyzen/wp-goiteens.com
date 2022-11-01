
<section class="section-accent notice">

    <div class="container notice__wrapper">
        <h2 class="section-title notice__title"><?php the_field('notice_title'); ?></h2>
		
		 <?php $noticeList = get_field('notice_list');?>
        <ul class="list grid notice__list ">
        <?php foreach ($noticeList as $item): ?>
            <li class="grid__item notice__item  ">

                <p><?php echo "{$item['item_text']}"; ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
		 <?php $noticeDescription = get_field('notice_description');?>
        <div class="notice__content">
             <?php foreach ($noticeDescription as $item): ?>
            <p class="notice__description"><?php echo "{$item['item_text']}"; ?></p>
             <?php endforeach; ?>
        </div>
        <picture class="notice__img-wrapper">

            <source srcset="
      <?php echo get_template_directory_uri(); ?>/assets/images/roblox/notice/notice-boy.webp    1x,
      <?php echo get_template_directory_uri(); ?>/assets/images/roblox/notice/notice-boy@2x.webp 2x
     " media="(min-width: 280px)" type="image/webp" />

            <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/roblox/notice/notice-boy@2x.jpg 2x" media="(min-width: 280px)" type="image/png" />
            <img class="notice__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/roblox/notice/notice-boy.png" alt="<?php the_field('notice_img_alt'); ?>" width="500"
                height="464" loading="lazy" />
        </picture>
        <div class="notice__btn-wrapper">
            <p class="item-title notice__sub-title"><?php the_field('notice_sub_title'); ?></p>
			 <button type="button" class="main-btn notice__btn" data-modal-open><?php the_field('roblox_free_btn'); ?></button>
        </div>
    </div>
</section>