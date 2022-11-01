<section class="section problems">
  <div class="container">
    <h2 class="section__title"><?php the_field('problems_title');?></h2>
<?php $problemsList = get_field('problems_list');
  if( $problemsList ): ?> 
    <ul class="problems__list grid list">
     <?php 
		 $pl="";
		if(get_locale() == 'pl_PL' || get_locale() == 'en_US'){
			$pl = true;
		};
		foreach( $problemsList as $item ): ?>
      <li class="problems__item problems__item--<?php echo "{$item['id']}"; ?> grid__item <? if( $pl ): echo "pl"; endif?> ">
        <p class="problems__text"><?php echo "{$item['description']}"; ?></p>
      </li>
     <?php endforeach; ?>
	</ul>
  <?php endif; ?>
  </div>
</section>
