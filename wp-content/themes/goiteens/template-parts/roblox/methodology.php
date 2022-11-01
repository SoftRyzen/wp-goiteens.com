<section class="section methodology">
  <div class="container">

    <div class="methodology__header-wrapper">
      <div class="methodology__header">
        <h2 class="section-title"><?php the_field('methodology_title'); ?></h2>
      
		<?php $methodologyList = get_field('methodology_description');?>
		  <?php foreach ($methodologyList['methodology_item'] as $item): ?>
		 <p><?php echo "{$item['methodology_text']}"; ?></p>
        <?php endforeach; ?>
		</div>
		
		<?php $logoList = get_field('logo_list');?>
		       <ul class="list grid methodology__logo-list">
			<?php foreach ($logoList['logo_items'] as $item): ?>
          <li class="grid__item methodology__logo-item"> 
			  <svg class="methodology__logo-icon" width="<?php echo "{$item['logo_width']}"; ?>" height="<?php echo "{$item['logo_height']}"; ?>">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/images/roblox/sprite.svg<?php echo "{$item['logo_id']}"; ?>"></use>
          </svg>
			 </li>
        <?php endforeach; ?>
		  </ul>
    </div>

    <div class="methodology__content-wrapper">
		<?php $programList = get_field('program_list');?>
		       <ul class="list grid methodology__program-list">
			<?php foreach ($programList['program_items'] as $item): ?>
          <li class="grid__item methodology__program-item"> 
			   <svg class="methodology__icon" width="80" height="80" aria-hidden="true">
          <use href="<?php echo get_template_directory_uri(); ?>/assets/images/roblox/sprite.svg#check-circle"></use>
        </svg>
			  <h3 class="text-dark methodology__program-title"><?php echo "{$item['program_title']}"; ?></h3>
          <p><?php echo "{$item['program_text']}"; ?></p>
				   </li>
        <?php endforeach; ?>
		  </ul>

      <p class="text-label methodology__formula-label"><?php the_field('formula_title'); ?></p>

		<?php $formulaList = get_field('formula_list');?>
      <ul class="list grid methodology__formula-list">
      <?php foreach ($formulaList['formula_item'] as $item): ?>
        <li class="grid__item methodology__formula-item">
          <div class="methodology__formula-card"><?php echo "{$item['item_numb']}"; ?></div>
          <h3 class="text-dark methodology__formula-title"><?php echo "{$item['item_title']}"; ?></h3>
          <p><?php echo "{$item['item_text']}"; ?></p>
        </li>
     <?php endforeach; ?>
      </ul>
    </div>
  <button type="button" class="main-btn methodology__btn" data-modal-open>
            <?php the_field('roblox_trial_btn'); ?>
           </button>

  </div>
</section>