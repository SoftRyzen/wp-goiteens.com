<section class="how">
  <div class="container">
    <h2 class="section-title how__title"><?php the_field('referral_how_title'); ?></h2>
<?php $howList= get_field('referral_how_list');
	  if($howList): ?>
    <ul class="list grid how__list">
      <?php foreach($howList as $key=> $item): ?>
      <li class="grid__item how__item">
        <p class=" how__step"><?php echo"{$item['step']}" ;?></p>
        <p class="how__text"><?php echo"{$item['text']}" ;?></p>
      </li>
     <?php endforeach ;?>
    </ul>
<?php endif ;?>
  </div>
</section>