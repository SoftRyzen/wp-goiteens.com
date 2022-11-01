<?php $euPage=strpos($_SERVER['REQUEST_URI'], '-eu');?>
<section class="section how">
  <div class="container">
    <h2 class="section-title how__title"><?php the_field('how_title'); ?></h2>
    <p class="text-label how__description"><?php the_field('how_description'); ?></p>
    <div class="how__header-wrapper">
      <div class="how__header">
        <h2 class="section-title"><?php the_field('hsp_title'); ?></h2>
        <?php $hspList = get_field('hsp_descript');
		if( $hspList ):
     	foreach($hspList as $item ): ?>
        	<p><?php echo "{$item['hsp_text']}"; ?></p>
        <?php endforeach; ?>
    	<?php endif; ?>
      </div>
		<?php $logoList = get_field('logo_list');
		if( $logoList ):?>
      <ul class="list grid how__logo-list">
        <?php foreach($logoList as $item ): ?>
        <li class="grid__item how__logo-item">
          <svg class="how__logo-icon" width="<?php echo "{$item['logo_width']}"; ?>" height="<?php echo "{$item['logo_height']}"; ?>">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/images/design/sprite.svg#icon-<?php echo "{$item['logo_id']}"; ?>"></use>
          </svg>
        </li>
        <?php endforeach; ?>
      </ul>
	<?php endif; ?>
    </div>

    <div class="how__content-wrapper">
	<?php $programList = get_field('program_list');
	if( $programList ):?>
      <ul class="list grid how__program-list">
        <?php foreach($programList as $item ): ?>
        <li class="grid__item how__program-item">
          <h3 class="text-black how__program-title"><?php echo "{$item['program_list_title']}"; ?></h3>
          <p><?php echo "{$item['program_list_text']}"; ?></p>
        </li>
        <?php endforeach; ?>
      </ul>
	<?php endif; ?>	
      <p class="text-label how__formula-label"><?php the_field('formula_title'); ?></p>
	<?php $formulaList = get_field('formula_list');
	if( $formulaList ):?>
      <ul class="list grid how__formula-list">
        <?php foreach($formulaList as $item ): ?>
        <li class="grid__item how__formula-item">
          <div class="how__formula-card"><?php echo "{$item['item_numb']}"; ?></div>
          <h3 class="text-black how__formula-title"><?php echo "{$item['item_title']}"; ?></h3>

          <p><?php echo "{$item['item_text']}"; ?></p>
        </li>
        <?php endforeach; ?>
      </ul>
	<?php endif; ?>
    </div>
	  <button type="button" class="main-btn how__btn btn-icon " data-modal-open >
		  <?php  $euPage ? the_field('btn_main_text_eu') : the_field('btn_main_text'); ?>
	  </button>
  </div>
</section>