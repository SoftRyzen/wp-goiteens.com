<?php
/*
Template Name: Courses All Page
*/
get_header();
?>

<?php get_template_part( 'template-parts/courses-all/header'  ); ?>
<main>



<?php get_template_part( 'template-parts/courses-all/about'  ); ?>
<?php get_template_part( 'template-parts/courses-all/info'  ); ?>
<?php get_template_part( 'template-parts/courses-all/advantages'  ); ?>
<?php get_template_part( 'template-parts/courses-all/courses'  ); ?>
<?php get_template_part( 'template-parts/courses-all/free-lesson'  ); ?>
<?php get_template_part( 'template-parts/courses-all/choice'  ); ?>
<?php get_template_part( 'template-parts/courses-all/how'  ); ?>
<?php get_template_part( 'template-parts/courses-all/results'  ); ?>
<?php get_template_part( 'template-parts/courses-all/projects'  ); ?>
<?php get_template_part( 'template-parts/courses-all/reviews'  ); ?>
<?php get_template_part( 'template-parts/courses-all/contact-us'  ); ?>

</main>

<?php get_template_part( 'template-parts/main-footer' ); ?>

<?php get_footer();