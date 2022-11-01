<section class="section lessons">
  <div class="container">

    <h2 class="section-title lessons__title"><?php the_field('lessons_title') ;?></h2>
	<?php $imgList= get_field('img_list');
	  if($imgList):?>
    <ul class="list grid lessons__img-list">
      <?php foreach($imgList as $item): ?>
      <li class="grid__item lessons__img-item">

        <p><?php echo"{$item['img_items_text']}"  ;?></p>
      </li>
      <?php endforeach ;?>
    </ul>
	<?php endif;?>
	 <?php $lessonsList= get_field('lessons_list');
	  if($lessonsList):?>
    <div class="grid lessons__cont-wrapper">
      <?php foreach($lessonsList as $list): ?>
      <div class="grid__item lessons__cont">
        <h3 class="item-title text-accent lessons__cont-title"><?php echo"{$list['item_title']}"  ;?></h3>
        <ul class="lessons__cont-list ">
           <?php foreach($list['item_list'] as $item): ?>
          <li class="lessons__cont-item "><?php echo"{$item['item_text']}"  ;?></li>
           <?php endforeach ;?>
        </ul>
      </div>
      <?php endforeach ;?>
    </div>
	 <?php endif;?>
  </div>
</section>