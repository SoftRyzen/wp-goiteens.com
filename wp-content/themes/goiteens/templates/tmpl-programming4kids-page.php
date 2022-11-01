<?php
/*
Template Name: Programming4kids Page
*/
get_header(); 
?>
<?php get_template_part( 'template-parts/programming4kids/header'  ); ?>

<main>
	<?php get_template_part( 'template-parts/programming4kids/capability' ); ?>
	<?php get_template_part( 'template-parts/programming4kids/promo' ); ?>
	<?php get_template_part( 'template-parts/programming4kids/methodology' ); ?>
	<?php get_template_part( 'template-parts/programming4kids/results' ); ?>
	<?php get_template_part( 'template-parts/programming4kids/program' ); ?>
	<?php get_template_part( 'template-parts/programming4kids/study-flow' ); ?>
	<?php get_template_part( 'template-parts/programming4kids/projects' ); ?>
	<?php get_template_part( 'template-parts/programming4kids/trial-lesson' ); ?>
    <?php get_template_part( 'template-parts/programming4kids/features' ); ?>
	<?php get_template_part( 'template-parts/programming4kids/reviews' ); ?>
	


</main>
<?php get_template_part( 'template-parts/programming4kids/footer'); ?>
<?php
get_footer();