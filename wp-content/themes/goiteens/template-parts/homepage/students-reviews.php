<section class="home__students-reviews section">
	<div class="container">
		<h2 class="home__students-reviews-title title">
			<?php the_field('home_students_reviews_title'); ?>
		</h2>
	</div>
	<?php get_template_part('template-parts/students-reviews', get_post_type()); ?>
</section>