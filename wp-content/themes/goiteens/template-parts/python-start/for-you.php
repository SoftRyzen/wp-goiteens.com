<section class="section for-you">
  <div class="container">
    <h2 class="section-title"><?php the_field('foryou_title'); ?></h2>
	  <?php $foryouList = get_field('foryou_list');
		if( $foryouList ): ?> 
    <ul class="list card-set">
       	<?php foreach( $foryouList as $item ): ?>	
      <li class="item card-set-item">
        <p class="item-title text-strong"><?php echo "{$item['title']}"; ?></p>
        <p><?php echo "{$item['description']}"; ?></p>
      </li>
       <?php endforeach; ?>
    </ul>
	  <?php endif; ?>
  </div>
</section>
