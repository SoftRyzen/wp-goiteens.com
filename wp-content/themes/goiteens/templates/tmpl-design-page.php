<?php
/*
Template Name: Design Page
*/
get_header();
?>
<main>
<?php get_template_part( 'template-parts/design/header'  ); ?>
<?php get_template_part( 'template-parts/design/why'  ); ?>
<?php get_template_part( 'template-parts/design/creative'  ); ?>
<?php get_template_part( 'template-parts/design/while'  ); ?>
<?php get_template_part( 'template-parts/design/portfolio'  ); ?>
<?php get_template_part( 'template-parts/design/skills'  ); ?>
<?php get_template_part( 'template-parts/design/lessons'  ); ?>
<?php get_template_part( 'template-parts/design/how'  ); ?>
<?php get_template_part( 'template-parts/design/projects'  ); ?>
<?php get_template_part( 'template-parts/teachers', get_post_type() ); ?>
<?php get_template_part( 'template-parts/design/easy'  ); ?>
<?php get_template_part( 'template-parts/design/trust'  ); ?>
<?php get_template_part( 'template-parts/design/awards'  ); ?>

<?php get_template_part( 'template-parts/design/future'  ); ?>
<?php get_template_part( 'template-parts/design/success'  ); ?>
<?php get_template_part( 'template-parts/design/questions'  ); ?>
</main>
<?php get_template_part( 'template-parts/design/footer'  ); ?>

<?php get_footer();