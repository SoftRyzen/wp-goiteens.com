<section class="section while">
  <div class="container">
    <div class="while__title-wrapper">
      <h2 class="section-title while__title"><?php the_field('while_title'); ?></h2>
      <p class="text-label"><?php the_field('while_description'); ?></p>
      	 <?php $iconList = get_field('icon_list');
		if( $iconList ): ?>
		<ul class="list grid while__icon-list">
        <?php foreach($iconList as $key=>$item ): ?>
        <li class="grid__item while__icon-item">

          <picture>
            <source
              srcset="<?php echo get_template_directory_uri(); ?>/assets/images/design/while/while-<?php echo $key+1; ?>.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/design/while/while-<?php echo $key+1; ?>@2x.webp 2x"
              type="image/webp" />
            <source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/design/while/while-<?php echo $key+1; ?>@2x.png  2x" type="image/png" />
            <img class="while__icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/design/while/while-<?php echo $key+1; ?>.png"
              alt="<?php the_field('icon_alt'); ?> <?php echo "{$item['icon_text']}"; ?>" width="61" height="61" loading="lazy" />
          </picture>
        </li>
        <?php endforeach; ?>
      </ul>
	 <?php endif; ?>
    </div>
	<?php $whileList = get_field('while_list');
	 if( $whileList ): ?>
    <div class="grid while__cont-wrapper">

      <?php foreach($whileList as $list ): ?>
      <div class="grid__item">
        <h3 class="item-title text-accent while__cont-title"><?php echo "{$list['item_title']}"; ?></h3>
        <ul class="while__cont-list ">
          <?php foreach($list['items_list'] as $item ): ?>
          <li class="while__cont-item "><?php echo "{$item['item_text']}"; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
       <?php endforeach; ?>
    </div>
	 <?php endif; ?>
  </div>
</section>