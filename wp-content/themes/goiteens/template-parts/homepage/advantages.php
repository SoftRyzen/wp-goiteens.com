<section class="home__advantages section">
	<div class="container">
		<h2 class="home__advantages-title title">
			<?php the_field('advantages_title'); ?>
		</h2>

		<?php $advantagesList = get_field('advantages_list');
        if ($advantagesList): ?>
		<ul class="home__advantages-list grid list">
			<?php foreach ($advantagesList as $item): ?>
			<li class="home__advantages-item grid__item" data-aos="fade-up"
				data-aos-delay="<?php echo "{$item['delay']}"; ?>" data-aos-anchor=".home__advantages">
				<svg class="home__advantages-icon" width="72" height="72">
					<use
						href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg<?php echo "{$item['svg']}"; ?>">
					</use>
				</svg>
				<p class="text-bold home__advantages-text">
					<?php echo "{$item['title']}"; ?>
				</p>
				<p>
					<?php echo "{$item['text']}"; ?>
				</p>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>

		<a class="home__advantages-btn main-btn" href="<?php the_field('advantages_link'); ?>">
			<?php the_field('advantages_btn'); ?>
		</a>
	</div>
</section>