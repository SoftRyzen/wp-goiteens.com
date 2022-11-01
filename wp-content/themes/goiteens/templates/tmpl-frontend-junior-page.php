<?php
/*
Template Name: Frontend-junior Page
*/
 get_header(); 
?>

	

<?php get_template_part( 'template-parts/frontend-junior/header'  ); ?>

<main class="main">
	<?php get_template_part( 'template-parts/frontend-junior/profession', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/for', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/result', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/study', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/modules', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/how', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/schedule', get_post_type()  ); ?>	
	<?php get_template_part( 'template-parts/frontend-junior/projects', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/free_lesson', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/teachers', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/lesson', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/study_principles', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/awards', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend-junior/help', get_post_type()  ); ?>
</main>
<?php get_template_part( 'template-parts/main-footer'  ); ?>
<?php
get_footer();