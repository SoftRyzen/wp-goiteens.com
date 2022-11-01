<?php
/*
Template Name: Python Page
*/
get_header();
?>

	

<?php get_template_part( 'template-parts/python/header'  ); ?>

<main class="main">
	<?php get_template_part( 'template-parts/python/course', get_post_type()  ); ?> 
	<?php get_template_part( 'template-parts/python/programming', get_post_type()  ); ?> 
	<?php get_template_part( 'template-parts/python/during', get_post_type()  ); ?> 
	<?php get_template_part( 'template-parts/python/skills', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/register', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/specialists', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/conclusion', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/how', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/projects', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/teachers', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/wish', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/lesson', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/study-principles', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/awards', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/future', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/python/questions', get_post_type()  ); ?>
</main>

	<?php get_template_part( 'template-parts/main-footer'  ); ?>
<?php
get_footer();