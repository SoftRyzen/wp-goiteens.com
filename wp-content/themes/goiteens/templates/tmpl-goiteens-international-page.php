<?php
/*
Template Name: International Page
*/
add_action('wp_enqueue_scripts', 'goiteens_template_page_goiteens_international_enqueue_styles', 20);
function goiteens_template_page_goiteens_international_enqueue_styles()
{

    wp_enqueue_style('montserrat-alternates', 'https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400;500;700;800&display=swap');

}
get_header();
?>
<?php get_template_part('template-parts/main-header'); ?>
<main class="international">

	<?php get_template_part( 'template-parts/goiteens-international/hero' ); ?>
	<?php get_template_part( 'template-parts/goiteens-international/goiteens-are'  ); ?>
	<?php get_template_part( 'template-parts/goiteens-international/free-projects'  ); ?>
	<?php get_template_part( 'template-parts/goiteens-international/students-projects'  ); ?>
	<?php get_template_part( 'template-parts/goiteens-international/it-direction'  ); ?>
	<?php get_template_part( 'template-parts/goiteens-international/choice-decision'  ); ?>	
	<?php get_template_part( 'template-parts/goiteens-international/modal-int'  ); ?>	
</main>

<?php get_template_part( 'template-parts/main-footer'  ); ?>
<?php
get_footer();