<?php 
     $pl="";
	 if(get_locale() == 'pl_PL' || get_locale() == 'en_US'){
		$pl=true;
};

?>


<section class="section lesson-plan">
  <div class="container">
    <h2 class="section__title"><?php the_field('lesson_title');?></h2>
    <p class="lesson-plan__undertitle text-accent"><?php the_field('lesson_subtitle');?></p>
    <ul class="list grid lesson-plan__list">
      <li class="item grid__item lesson-plan__item">
        <h3 class="text-accent text-bold lesson-plan__item-title">
          <?php the_field('first_list_title');?>
        </h3>
		<?php $firstList = get_field('first_list');
		if( $firstList ): ?>
        <ul class="list inner-list">
          <?php foreach( $firstList as $item ): ?>
          <li class="lesson-plan__item-descr"><?php echo "{$item['text']}"; ?></li>
          <?php endforeach; ?>
        </ul>
		<?php endif; ?>
      </li>

      <li class="item grid__item lesson-plan__item">
        <h3 class="text-accent text-bold lesson-plan__item-title">
          <?php the_field('second_list_title');?>
        </h3>
		<?php $secondList = get_field('second_list');
		if( $secondList ): ?>
        <ul class="list inner-list">
          <?php foreach( $secondList as $item ): ?>
          <li class="lesson-plan__item-descr"><?php echo "{$item['text']}"; ?></li>
          <?php endforeach; ?>
        </ul>
		<?php endif; ?>
      </li>
    </ul>
    <div class="lesson-plan__bottomcont grid">

      <div class="lesson-plan__bottomcont-left grid__item <? if( $pl ): echo "pl"; endif?>">
        <?php $thirdList = get_field('third_list');
		if( $thirdList ):
		foreach( $thirdList as $item ): ?>
        <p class="lesson-plan__bottomcont-text <? if( $pl ): echo "pl"; endif?>"><?php echo "{$item['text']}"; ?></p>
        <?php endforeach; ?>
		<?php endif; ?>
      </div>
		
		
		<?php if($pl): ?>
		<div class="lesson-plan__bottomcont-right grid__item pl">
      		<?php $plList = get_field('lesson_plan_pl');
			if( is_array($plList) ):
				foreach( $plList as $item ): ?>
        			<p class="lesson-plan__bottomcont-text pl"><?php echo "{$item['item']}"; ?></p>
        		<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php else :?>
	  <div class="lesson-plan__bottomcont-right grid__item">
        <p class="lesson-plan__bottomcont-text"><?php the_field('additional_info');?></p>
        <div class="lesson-plan__bottomcont-img"></div>
      </div>
		<?php endif ;?>
    </div>
  </div>
</section>