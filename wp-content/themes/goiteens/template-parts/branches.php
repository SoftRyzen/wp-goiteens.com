	<div class="branches">
  <div class="container">
	 <?php $branchesList = get_field('branches_list');
if( $branchesList ): ?>
    <ul class="grid branches__list list">

      <?php foreach ($branchesList as $item): ?>
		<li class="grid__item branches__item  <?php echo $item['item_id']; ?>-<?php the_field('page_lang'); ?>"><?php echo $item['item_text']; ?></li>
<?php endforeach; ?>
    </ul>
	    <?php endif; ?>
  </div>
</div>