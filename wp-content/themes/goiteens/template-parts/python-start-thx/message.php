<section class="section message">
  <div class="container">
    <h1 class="title"><?php the_field('thx_title'); ?></h1>
   <?php $thxList = get_field('thx_list');
		if( $thxList ): ?>
	  	<?php foreach( $thxList as $item ): ?>
      <p class="<?php echo "{$item['class']}"; ?>"><?php echo "{$item['text']}"; ?></p>
         <?php endforeach; ?>
		<?php endif; ?>

      <?php if( isset($_GET['btn_registered']) ) { ?>
          <a class="btn" href="https://edu.goit.global/uk/dl/teens-wishdashboard?rtr=true">Розпочати</a>
      <?php }else{ ?>
        <a class="btn" href="<?php the_field('tg_link'); ?>"><?php the_field('btn_txt'); ?></a>
      <?php } ?>
  </div>
</section>
