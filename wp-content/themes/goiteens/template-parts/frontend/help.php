<?php $euPage=strpos($_SERVER['REQUEST_URI'], '-eu');?>
<section class="section help">
  <div class="container help__wrapper">
    <h2 class="section__title help__title"><?php the_field('help_title'); ?></h2>
    <p class="block__title help__description"><?php the_field('help_description'); ?></p>
    <button type="button" class="main-btn help__btn main-btn--violet" data-modal-open><?php $euPage ?  the_field('button_eu') : the_field('help_button'); ?></button>
  </div>
</section>
