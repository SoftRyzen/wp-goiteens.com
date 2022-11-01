<?php
/*
Template Name: Roblox Page
*/
get_header();
?>
<?php get_template_part( 'template-parts/roblox/header'  ); ?>
<main>
	<?php get_template_part( 'template-parts/roblox/why' ); ?>
    <?php get_template_part( 'template-parts/roblox/notice' ); ?>
	<?php get_template_part( 'template-parts/roblox/program' ); ?>
	<?php get_template_part( 'template-parts/roblox/roblox' ); ?>
    <?php get_template_part( 'template-parts/roblox/how' ); ?>
	<?php get_template_part( 'template-parts/roblox/features' ); ?>
	<?php get_template_part( 'template-parts/roblox/awards' ); ?>
	<?php get_template_part( 'template-parts/roblox/projects' ); ?>
	<?php get_template_part( 'template-parts/roblox/teachers' ); ?>
    <?php get_template_part( 'template-parts/roblox/confidence' ); ?>
</main>

<?php get_template_part( 'template-parts/roblox/footer'); ?>
<?php
get_footer();