<section class="section soft-skills" id="soft-skills">
  <div class="container">
    <h2 class="soft-skills__title section__title"><?php the_field('soft_skills_title');?></h2>
		<?php $skillsList = get_field('soft_skills_list');
		if( $skillsList ): ?> 
		   <ul class="soft-skills__list list grid">
			<?php foreach( $skillsList as $item ): ?>
				 <li class="soft-skills__item grid__item" >
					<svg  class="<?php echo "{$item['class']}"; ?>" width="100" height="100">
					  <use
						href="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/sprite.svg#soft-skills-<?php echo "{$item['id']}"; ?>"
					  ></use>
					</svg>
        			<p class="soft-skills__description"><?php echo "{$item['description']}"; ?></p>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	  
    <div class="soft-skills__wrapper grid">
      <div class="soft-skills__inner-box grid__item"></div>
      <div class="soft-skills__inner-box grid__item">
        <h2 class="section__title"><?php the_field('info_title');?></h2>
        <p><?php the_field('info_description');?></p>
      </div>
    </div>
  </div>
</section>
