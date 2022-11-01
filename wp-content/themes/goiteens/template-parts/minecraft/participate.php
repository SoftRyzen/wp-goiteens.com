<?php $euPage=strpos($_SERVER['REQUEST_URI'], '-eu');?>
<section class="section participate">
  <div class="container">
    <h2 class="participate__title"><?php the_field('participate_title');?></h2>
	<?php $participateList = get_field('participate_list');
	if( $participateList ): ?> 
    <ul class="list grid">
      <?php foreach( $participateList as $item ): ?>
      <li class="item grid__item">
        <div class="participate__icon-cont">
          <svg class="participate__icon" width="70" height="70">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/sprite.svg#icon-participate-<?php echo "{$item['id']}"; ?>"></use>
          </svg>
        </div>
        <p class="participate__icon-description"><?php echo "{$item['description']}"; ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
	<?php endif; ?>

    <div class="participate__wrapper">
      <picture>
        <source
          srcset="
            <?php echo get_template_directory_uri(); ?>/assets/images/minecraft/participate/portrait.webp    1x,
            <?php echo get_template_directory_uri(); ?>/assets/images/minecraft/participate/portrait@2x.webp 2x
          "
          type="image/webp"
       
        />
		  <source
          srcset="
            <?php echo get_template_directory_uri(); ?>/assets/images/minecraft/participate/portrait.jpg    1x,
            <?php echo get_template_directory_uri(); ?>/assets/images/minecraft/participate/portrait@2x.jpg 2x
          "	
          type="image/jpeg"
				  />
        <img

          src="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/participate/portrait.jpg"
          class="participate__img"
          alt="<?php the_field('participate_img_alt');?>"

          width="470"
          height="440"
          loading="lazy"
        />
      </picture>
      <div class="participate__side">
        <div class="participate__header">
          <svg class="participate__logo" width="146" height="36">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/sprite.svg#logo-yellow" />
          </svg>
        </div>
        <div class="participate__content">
          <p class="participate__text"><?php $euPage ? the_field('participate_description_eu') : the_field('participate_description');?></p>
          <button class="main-btn btn--yellow participate__btn" data-modal-open>
            <?php $euPage ? the_field('btn_text_eu') : the_field('btn_text');?>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>
