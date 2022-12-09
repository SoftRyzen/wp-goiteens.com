<section class="home__appeal section">
	<div class="home__appeal-wrapper container">
		<h2 class="home__appeal-title">
			<?php the_field('appeal_title'); ?>
		</h2>
		<p class="home__appeal-text">
			<?php the_field('appeal_description'); ?>
		</p>
		<button type="button" class="main-btn" data-modal-open>
			<?php the_field('page_button'); ?>
		</button>
	</div>
</section>