<?php
/*
Template Name: Frontend Page
*/
get_header();
?>

<main class="main">
    <?php get_template_part( 'template-parts/frontend/header', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/profession', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/for', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/result', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/study', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/how', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/schedule', get_post_type()  ); ?>	
	<?php get_template_part( 'template-parts/frontend/projects', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/free_lesson', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/teachers', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/lesson', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/study_principles', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/awards', get_post_type()  ); ?>
	<?php get_template_part( 'template-parts/frontend/help', get_post_type()  ); ?>
</main>

<?php get_template_part( 'template-parts/main-footer'  ); ?>
<?php
get_footer();