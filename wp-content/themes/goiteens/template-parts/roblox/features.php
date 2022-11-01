
<section class="section features">
  <div class="container ">
    <h2 class="section-title features__title"><?php the_field('features_title'); ?></h2>
	  <?php $featuresList = get_field('features_list');?>
    <ul class="list grid features__list">
     <?php foreach ($featuresList as $item): ?>
      <li class="grid__item features__item">
        <p class="features__item-text"><?php echo "{$item['item_text']}"; ?></p>
      </li>
      <?php endforeach; ?>
    </ul>

  </div>
</section>