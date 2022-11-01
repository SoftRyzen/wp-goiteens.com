<?php
/*
Template Name: Game of Teens Page
*/
get_header();
?>

<?php get_template_part( 'template-parts/game-of-teens/header'  ); ?>
<main>

    <?php get_template_part( 'template-parts/game-of-teens/hero'  ); ?>
    <?php get_template_part( 'template-parts/game-of-teens/about'  ); ?>
    <?php get_template_part( 'template-parts/game-of-teens/advantage'  ); ?>
    <?php get_template_part( 'template-parts/game-of-teens/categories'  ); ?>
    <?php get_template_part( 'template-parts/game-of-teens/registration'  ); ?>
    <?php get_template_part( 'template-parts/game-of-teens/speakers'  ); ?>
    <?php get_template_part( 'template-parts/game-of-teens/develop'  ); ?>
    <?php get_template_part( 'template-parts/game-of-teens/partners'  ); ?>
    <?php get_template_part( 'template-parts/game-of-teens/faq'  ); ?>


</main>

<?php get_template_part( 'template-parts/main-footer'  ); ?>
<?php
get_footer();