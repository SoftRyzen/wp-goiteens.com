<section class="home__main-awards section">
	<div class="container">
		<h2 class="home__main-awards-title title">
			<?php the_field('home_awards_title'); ?>
		</h2>
	</div>
	<?php get_template_part('template-parts/awards', get_post_type()); ?>
</section>