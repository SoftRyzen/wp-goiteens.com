<?php $euPage=strpos($_SERVER['REQUEST_URI'], '-eu');?>
<section class="section formula-section">
  <div class="container">
    <div class="header-wrapper">
      <div class="section__header">
        <h2 class="title section__title"><?php the_field('logo_title');?></h2>
       <?php $logoItems = get_field('logo_items');
		if( $logoItems ):
		 foreach( $logoItems as $item ): ?>
        <p><?php echo "{$item['text']}"; ?></p>
       	<?php endforeach; ?>
		<?php endif; ?>
      </div>
		<?php $logoList = get_field('logo_list');
		if( $logoList ): ?> 
      <ul class="list grid company-logo">
        <?php foreach( $logoList as $item ): ?>
        <li class="grid__item company-logo__item">
          <svg class="company-logo__icon" width="<?php echo "{$item['width']}"; ?>" height="<?php echo "{$item['height']}"; ?>">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/sprite.svg#formula-icon-<?php echo "{$item['id']}"; ?>"></use>
          </svg>
        </li>
     <?php endforeach; ?>
			</ul>
		<?php endif; ?>
    </div>

    <div class="content-wrapper">
		<?php $hspList = get_field('hsp_list');
		if( $hspList ): ?> 
      <ul class="list grid program__list">
        <?php foreach( $hspList as $item ): ?>
        <li class="item grid__item program__item">
          <h3 class="item__title"><?php echo "{$item['title']}"; ?></h3>
          <p><?php echo "{$item['description']}"; ?></p>
        </li>
         <?php endforeach; ?>
			</ul>
		<?php endif; ?>

      <h2 class="section__title formula-section__title"><?php the_field('education_title');?></h2>
		<?php $educationList = get_field('education_list');
		if( $educationList ): ?> 
      <ul class="list grid formula__list">
         <?php foreach( $educationList as $item ): ?>
        <li class="item grid__item formula__item">
          <div class="formula__item-card"><?php echo "{$item['item_card']}"; ?></div>
          <p class="text-bold formula__item-title"><?php echo "{$item['title']}"; ?></p>
          <p><?php echo "{$item['description']}"; ?></p>
        </li>
         <?php endforeach; ?>
			</ul>
		<?php endif; ?>
    </div>
    <button class="main-btn btn-icon main-btn--violet" data-modal-open>
		<?php 
		if($euPage){
			the_field('btn_text_eu');
		}else if(get_locale() == 'pl_PL' || get_locale() == 'en_US'){
			the_field('btn_short_text');
		}else{
			the_field('btn_text');
		};?>
     
    </button>
  </div>
</section>
 
