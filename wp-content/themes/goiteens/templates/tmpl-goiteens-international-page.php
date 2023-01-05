<?php
/*
Template Name: International Page
*/
get_header();
?>

<main class="international">

	<?php get_template_part( 'template-parts/goiteens-international/hero' ); ?>
	<?php get_template_part( 'template-parts/goiteens-international/goiteens-are'  ); ?>
	<?php get_template_part( 'template-parts/goiteens-international/free-projects'  ); ?>
	<?php get_template_part( 'template-parts/goiteens-international/students-projects'  ); ?>
	<?php get_template_part( 'template-parts/goiteens-international/it-direction'  ); ?>
	<?php get_template_part( 'template-parts/goiteens-international/choice-decision'  ); ?>	

</main>

<?php get_template_part( 'template-parts/main-footer'  ); ?>
<?php
get_footer();