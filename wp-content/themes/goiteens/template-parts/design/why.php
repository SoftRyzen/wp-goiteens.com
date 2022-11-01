<section class="section why">
  <div class="container why__template">
    <h2 class="section-title why__title"><?php the_field('why_title'); ?></h2>
	 <?php $whyList = get_field('design_why_lists');
		if( $whyList ):
     foreach($whyList as $key=>$list ): ?>
    <ul class="list  why__list why__list-<?php echo $key+1; ?>">
      <?php foreach($list['item'] as $item ): ?>
      <li class="why__item"><?php echo "{$item['text']}"; ?></li>
       <?php endforeach; ?>
    </ul>
	  <?php endforeach; ?>
    <?php endif; ?>

    <p class="text-upper why__text"><?php the_field('why_text'); ?></p>
    <div class="why__img-wrap">
      <picture>
        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/design/why/boy.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/design/why/boy@2x.webp 2x" type="image/webp" />
        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/design/why/boy@2x.jpg 2x" type="image/jpeg" />
        <img class="why__img why__img-boy" src="<?php echo get_template_directory_uri(); ?>/assets/images/design/why/boy.jpg" alt="<?php the_field('boy_img_alt'); ?>" width="300"
          height="363" loading="lazy" />
      </picture>
      <picture>
        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/design/why/girl.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/design/why/girl@2x.webp 2x" type="image/webp" />
        <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/design/why/girl@2x.jpg 2x" type="image/jpeg" />
        <img class="why__img why__img-girl" src="<?php echo get_template_directory_uri(); ?>/assets/images/design/why/girl.jpg" alt="<?php the_field('girl_img_alt'); ?>" width="362"
          height="416" loading="lazy" />
      </picture>
    </div>
  </div>
</section>