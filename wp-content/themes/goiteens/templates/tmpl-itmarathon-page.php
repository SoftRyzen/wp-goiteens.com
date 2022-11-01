<?php
/*
Template Name: Itmarathon Page
*/
get_header();
?>

<?php get_template_part( 'template-parts/itmarathon/header'  ); ?>

<main>
		 <?php get_template_part( 'template-parts/itmarathon/profession', get_post_type()  ); ?> 
		 <?php get_template_part( 'template-parts/itmarathon/for', get_post_type()  ); ?>
		<?php get_template_part( 'template-parts/itmarathon/result', get_post_type()  ); ?>
		 <?php get_template_part( 'template-parts/itmarathon/study', get_post_type()  ); ?>
		<?php get_template_part( 'template-parts/itmarathon/projects', get_post_type()  ); ?>
		<?php get_template_part( 'template-parts/itmarathon/how', get_post_type()  ); ?>
		<?php get_template_part( 'template-parts/itmarathon/schedule', get_post_type()  ); ?>
		<?php get_template_part( 'template-parts/itmarathon/lesson', get_post_type()  ); ?>
		<?php get_template_part( 'template-parts/itmarathon/why', get_post_type()  ); ?>
		<?php get_template_part( 'template-parts/itmarathon/help', get_post_type()  ); ?>
   
</main>
<?php get_template_part( 'template-parts/main-footer'  ); ?>
<?php
get_footer();