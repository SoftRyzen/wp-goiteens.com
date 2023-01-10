<?php
/*
Template Name: Blog Page
@package GoITeens
*/

get_header();
?>
    <?php get_template_part('template-parts/main-header'); ?>

    <?php if( isset($_GET['search']) && !empty($_GET['search']) ) { ?>

        <?php get_template_part( 'template-parts/blog/search'); ?>
        <?php get_template_part( 'template-parts/blog/search', 'result'); ?>


    <?php }else{ ?>

        <?php get_template_part( 'template-parts/blog/hero'); ?>
        <?php get_template_part( 'template-parts/blog/search'); ?>
        <?php get_template_part( 'template-parts/blog/articles-card'); ?>
        <?php get_template_part( 'template-parts/blog/subscribe'); ?>
        <?php get_template_part( 'template-parts/blog/popular'); ?>

    <?php } ?>

    <?php get_template_part( 'template-parts/blog/specials'); ?>
    <?php get_template_part( 'template-parts/blog/order'); ?>

    <?php get_template_part('template-parts/main-footer'); ?>

<?php
get_footer();
