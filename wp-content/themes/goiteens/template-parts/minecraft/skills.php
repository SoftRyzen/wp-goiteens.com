<section class="section skills">
  <div class="container">
    <h2 class="section__title"><?php the_field('skills_title');?></h2>
    <p class="section__title text-accent">
      <span class="text-yellow"><?php the_field('skills_text');?></span>
    </p>
<?php $skillsList = get_field('skills_list');
	if( $skillsList ): ?> 
    <ul class="list grid skills__list">
    	<?php foreach( $skillsList as $item ): ?>
      <li class="item grid__item skills__item">
        <p><?php echo "{$item['description']}"; ?></p>
      </li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
  </div>
</section>
