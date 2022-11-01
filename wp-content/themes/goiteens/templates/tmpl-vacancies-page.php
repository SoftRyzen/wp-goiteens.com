<?php
/*
Template Name: Vacancies Page
*/
get_header();
?>

<main class="main">
    <?php get_template_part( 'template-parts/vacancies/header', get_post_type()  ); ?>
    <?php get_template_part( 'template-parts/vacancies/vacancies'); ?>

</main>
<?php get_template_part( 'template-parts/main-footer' ); ?>
<?php
get_footer();
