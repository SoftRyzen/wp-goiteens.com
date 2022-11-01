<?php
/*
Template Name: Referral Page
*/
get_header();
?>

<?php get_template_part( 'template-parts/referral/header'  ); ?>
<main>
<?php get_template_part( 'template-parts/referral/link'  ); ?>
<?php get_template_part( 'template-parts/referral/about'  ); ?>
<?php get_template_part( 'template-parts/referral/info'  ); ?>
<?php get_template_part( 'template-parts/referral/advantages'  ); ?>
<?php get_template_part( 'template-parts/referral/courses'  ); ?>
<?php get_template_part( 'template-parts/referral/how'  ); ?>
<?php get_template_part( 'template-parts/referral/results'  ); ?>
<?php get_template_part( 'template-parts/referral/reviews'  ); ?>
<?php get_template_part( 'template-parts/referral/registration'  ); ?>


</main>

<?php get_template_part( 'template-parts/main-footer' ); ?>

<?php get_footer();