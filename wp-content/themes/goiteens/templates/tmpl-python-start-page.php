<?php
/*
Template Name: Python-start Page
*/
get_header();
?>

 <?php get_template_part( 'template-parts/python-start/header'); ?>

<main class="main">
	<?php get_template_part( 'template-parts/python-start/why', get_post_type()  ); ?> 
	<?php get_template_part( 'template-parts/python-start/for-you', get_post_type()  ); ?> 
	<?php get_template_part( 'template-parts/python-start/statistics', get_post_type()  ); ?> 
	<?php get_template_part( 'template-parts/python-start/study', get_post_type()  ); ?> 
	<?php get_template_part( 'template-parts/python-start/project', get_post_type()  ); ?> 
	<?php get_template_part( 'template-parts/python-start/awards', get_post_type()  ); ?> 
	<?php get_template_part( 'template-parts/python-start/step', get_post_type()  ); ?> 
		

</main>

	<?php get_template_part( 'template-parts/main-footer'  ); ?>

<?php
get_footer();