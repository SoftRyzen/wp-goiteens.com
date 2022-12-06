<?php
function goiteens_sale_page_class( $classes )
{

    $classes[] = 'sale_page';

    return $classes;
}
add_filter( 'body_class', 'goiteens_sale_page_class' );

/*
Template Name: Sales Page
*/
get_header();
?>

<?php get_template_part('template-parts/main-header'); ?>

<main class="main">
    <?= the_content() ?>
</main>

<?php get_template_part( 'template-parts/main-footer'  ); ?>
<?php
get_footer();
