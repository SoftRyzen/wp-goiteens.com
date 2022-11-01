
<section class="section trial-lesson">
  <div class="container">
    <h2 class="trial-lesson__title section-title"><?php the_field('trial_title'); ?></h2>
	    <?php $trialList = get_field('trial_list'); ?>
    <ul class="trial-lesson__list list">
      <?php foreach ($trialList['trial_item'] as $item): ?>
      <li class="trial-lesson__item">
        <svg class="trial-lesson__icon" width="80" height="80">
          <use href="<?php echo get_template_directory_uri(); ?>/assets/images/programming4kids/sprite.svg#orange-circle"></use>
        </svg>
        <p class="text-white"><?php echo "{$item['item_text']}"; ?></p>
      </li>
         <?php endforeach; ?>
    </ul>
	  
    <p class="text-bold text-upper"><?php the_field('trial_description'); ?></p>
	   <button type="button" class="main-btn trial-lesson__btn" data-modal-open><?php the_field('programming4kids_trial_btn'); ?></button>
  </div>
</section>
