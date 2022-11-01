<section class="section register">
  <div class="register__wrapper">
    <div class="container">
      	<h2 class="section__title register__title"><?php the_field('register_title'); ?></h2>
		<button type="button" class="main-btn register__btn btn-icon main-btn--violet" data-modal-open><?php the_field('header_button'); ?></button>
      	<span class="text-notation register__notation"><?php the_field('register_notation'); ?></span>
		<?php $registerList = get_field('register_list');
			if( $registerList ): ?> 
			<ul class="list register__list">
				<?php foreach( $registerList as $item ): ?>
				<li class="register__item">
					<?php if( $item['label'] ): ?>
				  		<p class="register__text">
							<span class="register__label"><?php echo "{$item['label']}"; ?></span> <?php echo "{$item['text']}"; ?>
				  		</p>
					<?php else: ?> 				 
				  		<p class="text-cursive register__text-only"><?php echo "{$item['text']}"; ?></p>
				  <?php endif; ?> 
				</li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>
    </div>
  </div>
</section>
