<?php
/*
Template Name: Minecraft Page
*/

/**
 * Add Classes
 */
add_filter( 'body_class', 'goiteens_minecraft_page_class' );
function goiteens_minecraft_page_class( $classes )
{

	if( get_locale() == 'pl_PL' )
	{
		$classes[] = 'minecraft_pl';
	}

	return $classes;

}


get_header();
?>
<?php get_template_part( 'template-parts/minecraft/header'); ?>
<?php get_template_part( 'template-parts/minecraft/hero'); ?>
<?php get_template_part( 'template-parts/minecraft/soft-skills'); ?>
<?php get_template_part( 'template-parts/minecraft/problems'); ?>
<?php get_template_part( 'template-parts/minecraft/skills'); ?>
<?php get_template_part( 'template-parts/minecraft/formula'); ?>
<?php get_template_part( 'template-parts/minecraft/qualities'); ?>
<?php get_template_part( 'template-parts/minecraft/free-lesson-watch'); ?>
<?php get_template_part( 'template-parts/minecraft/lesson-plan'); ?>

<?php if(!(get_locale() == 'pl_PL') && !(get_locale() == 'en_US')):?>
<?php get_template_part( 'template-parts/teachers', get_post_type() ); ?>
<?php endif	;?>

<?php if(get_locale() == 'pl_PL' || get_locale() == 'en_US' ):?>
<?php get_template_part( 'template-parts/minecraft/price'); ?>
<?php endif	;?>

<?php get_template_part( 'template-parts/minecraft/free-lesson'); ?>
<?php get_template_part( 'template-parts/minecraft/study-principles'); ?>

<?php if(!(get_locale() == 'pl_PL') && !(get_locale() == 'en_US')):?>
<?php get_template_part( 'template-parts/minecraft/awards', get_post_type() ); ?>
<?php endif	;?>

<?php
$ratesSection = get_field('rates_title');
if($ratesSection){
	get_template_part( 'template-parts/minecraft/rates');
} ?>

<?php get_template_part( 'template-parts/minecraft/participate'); ?>
<?php get_template_part( 'template-parts/minecraft/questions'); ?>

<?php get_template_part( 'template-parts/minecraft/footer'); ?>

<?php
get_footer();
