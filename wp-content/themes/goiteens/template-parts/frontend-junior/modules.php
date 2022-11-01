<section class="section modules" id="modules">
  <h2 class="section__title modules__title"><?php the_field('modules_title');?></h2>
  <div class="container">
    <div class="modules-slider-pagination modules__pagination">
		
 <?php $paginationItems = get_field('pagination');
	if( $paginationItems ):
	foreach( $paginationItems as $item ): ?>
		
        <p class="modules__pagination-text"><?php echo "{$item['text']}"; ?></p>
		
    <?php endforeach; ?>
 <?php endif; ?>

    </div>
  </div>
  <div class="slider modules-slider-js">
	<?php $blocksList = get_field('modules_blocks');
		if( $blocksList ): ?>
 		<?php foreach( $blocksList as $block ): ?>
			<div class="slider-item">
			  <div class="modules__wrapper">
				<div class="container">
				  <ul class="list modules__yellow-list">
					<li class="section__subtitle modules__yellow-title"><?php echo "{$block['title']}"; ?></li>

					<li>
					  <img
						class="modules__stars-img"
						src="<?php echo get_template_directory_uri(); ?>/assets/images/frontend-junior/modules/<?php echo "{$block['img_star']}"; ?>.svg"
						alt="<?php the_field('block_img_alt');?>"
						width="88"
						height="24"
						loading="lazy"
					  />
					</li>

					<li class="modules__item-duration">
					  <p class="text-bold modules__duration"><?php the_field('block_duration');?></p>
					  <p class="text-accent text-bold"><?php echo "{$block['duration']}"; ?></p>
					</li>

					<li>
					  <ul class="list">					  
						<?php foreach( $block['description'] as $description ): ?>
						<li> 
							<p><?php echo "{$description['text']}"; ?></p>
						</li>
						<?php endforeach; ?>
					  </ul>
					</li>
				  </ul>
				</div>
			  </div>

			<?php foreach( $block['lists'] as $list ): ?>
			  <div class="modules__list-wrapper">
				<div class="container">
				  <ul class="list grid modules__common-list modules__main-list">
					
					 <?php foreach( $list['item'] as $item ): ?>
					<li class="grid__item modules__list-item">
					
					 <?php if( $item['label'] ): ?>
					  <p class="text-accent text-bold modules__label"><?php echo "{$item['label']}"; ?></p>
					  <?php endif; ?>

					  <h3><?php echo "{$item['title']}"; ?></h3>
						
					  <?php if( $item['description'] ): ?>
					  <p class="modules__description"><?php echo "{$item['description']}"; ?></p>
					  <?php endif; ?> 
						
					<?php if( $item['logos'] ): ?>
					  <ul class="list modules__common-list modules__logos-list">
						 <?php foreach( $item['logos'] as $logo ): ?>
						<li class="modules__logos-item">
						  <img
							class=""
							src="<?php echo get_template_directory_uri(); ?>/assets/images/frontend-junior/modules/<?php echo "{$logo['id']}"; ?>.png"
							alt="<?php echo "{$logo['id']}"; ?>"
							width="<?php echo "{$logo['logo_width']}"; ?>"
							height="<?php echo "{$logo['logo_height']}"; ?>"
							loading="lazy"
						  />
						</li>

						<?php endforeach; ?>
					  </ul>
					  <?php endif; ?>
					</li>
					<?php endforeach; ?>
				  </ul>
				</div>
			  </div>
			  <?php endforeach; ?>
			</div>
<?php endforeach; ?>
<?php endif; ?>
    
  </div>
</section>
