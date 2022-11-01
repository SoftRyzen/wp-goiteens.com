<section class="results">
  <div class="results__container">
    <div class="container ">
      <h2 class="results__title section-title"><?php the_field('all_results_title') ;?></h2>
<?php $resultsList= get_field('all_results_list');
	  if($resultsList): ?>
      <ul class="results__list list grid">
        <?php foreach($resultsList as $key=> $item): ?>
        <li class="results__item grid__item">
          <h3 class="results__item-title">
            <span><?php echo"{$item['title']}" ;?></span>
          </h3>

          <p class="results__description"><?php echo"{$item['description']}" ;?></p>
        </li>
        <?php endforeach ;?>
      </ul>
		<?php endif ;?>
    </div>
  </div>
</section>