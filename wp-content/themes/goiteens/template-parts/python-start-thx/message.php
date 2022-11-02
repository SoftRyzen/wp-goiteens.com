<section class="section message">
  <div class="container">
    <h1 class="title"><?php the_field('thx_title'); ?></h1>
   <?php $thxList = get_field('thx_list');
		if( $thxList ): ?>
	  	<?php foreach( $thxList as $item ): ?>
      <p class="<?php echo "{$item['class']}"; ?>"><?php echo "{$item['text']}"; ?></p>
         <?php endforeach; ?>
		<?php endif; ?>
      <a class="btn" href="<?php the_field('tg_link'); ?>"><?php the_field('btn_txt'); ?></a>
  </div>
</section>
