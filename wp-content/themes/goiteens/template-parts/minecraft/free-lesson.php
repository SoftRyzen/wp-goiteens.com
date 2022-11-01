 <?php $euPage=strpos($_SERVER['REQUEST_URI'], '-eu');?>
<section class="section lesson-promo">
    <div class="container">
      <h2 class="section__title text-accent"><?php $euPage ? the_field('free_lesson_eu') : the_field('free_lesson');?></h2>
      <button class="main-btn btn-icon main-btn--violet" data-modal-open>
       <?php $euPage ? the_field('btn_text_eu') : the_field('btn_text');?>
      </button>
      <p class="lesson-promo__undertext text-accent">
         <?php $euPage ? the_field('btn_notation_eu') : the_field('btn_notation');?>
      </p>
    </div>
  </section>
