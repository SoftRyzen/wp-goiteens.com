<?php
/*
Template Name: New Minecraft Page
*/
get_header();
?>
<?php get_template_part('template-parts/main-header'); ?>
<main>
    <?= the_content() ?>
</main>
<?php get_template_part( 'template-parts/main-footer'  ); ?>

<?php
get_footer();
