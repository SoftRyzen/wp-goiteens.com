<?php
/*
Template Name: New Minecraft Page
*/
get_header();
?>
<?php get_template_part('template-parts/main-header'); ?>
<main class="new-minecraft">
    <?php

    //TODO При использовании функции "get_template_part" не нужно указывать окончание .php

    get_template_part( 'template-parts/new-minecraft/hero-minecraft');
    get_template_part( 'template-parts/new-minecraft/advantages');
    get_template_part( 'template-parts/new-minecraft/for-pupils');
    get_template_part( 'template-parts/new-minecraft/interesting-math');
    get_template_part( 'template-parts/new-minecraft/minecraft-edu');
    get_template_part( 'template-parts/new-minecraft/lessons-details');
    get_template_part( 'template-parts/new-minecraft/results');
    get_template_part( 'template-parts/new-minecraft/ten-reasons');
    get_template_part( 'template-parts/new-minecraft/unique-methodology');
    get_template_part( 'template-parts/new-minecraft/programme');
    get_template_part( 'template-parts/new-minecraft/reviews');
    get_template_part( 'template-parts/new-minecraft/questions');

    ?>
</main>
<?php get_template_part( 'template-parts/main-footer'  ); ?>

<?php
get_footer();