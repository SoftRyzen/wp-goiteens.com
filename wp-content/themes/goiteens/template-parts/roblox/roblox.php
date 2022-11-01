<section class="section roblox">
  <div class="container">
    <h2 class="section-title roblox__title"><?php the_field('roblox_title'); ?></h2>
	   <?php $robloxList = get_field('roblox_list');?>
    <ul class="list roblox__list">
       <?php foreach ($robloxList as $item): ?>
      <li class="roblox__item roblox__item--<?php echo "{$item['item_modificator']}"; ?>">
        <svg class="roblox__icon" width="48" height="48" aria-hidden="true">
          <use href="<?php echo get_template_directory_uri(); ?>/assets/images/roblox/sprite.svg#check-circle"></use>
        </svg>
        <p><?php echo "{$item['item_text']}"; ?></p>
      </li>
     <?php endforeach; ?> 
    </ul>
  <?php get_template_part( 'template-parts/roblox/roblox_svg' ); ?>
  </div>
</section>