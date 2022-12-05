<?php
/*
Template Name: Sales Page
*/
get_header();
?>

<?php get_template_part('template-parts/main-header'); ?>

<main class="main">
	<?php get_template_part( 'template-parts/sales/sales-hero'  ); ?>
	<?php get_template_part( 'template-parts/sales/studding'  ); ?>
	<?php get_template_part( 'template-parts/sales/learn-profitably'  ); ?>
	<?php get_template_part( 'template-parts/sales/gift-certificate'  ); ?>
</main>

<?php get_template_part( 'template-parts/main-footer'  ); ?>
<?php
get_footer();
