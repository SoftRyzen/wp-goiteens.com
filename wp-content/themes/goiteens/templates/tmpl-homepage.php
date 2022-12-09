<?php
/*
 *	Template Name: Home Page
 */
get_header();

$pl = "";
if (get_locale() == 'pl_PL')
	$pl = true;

// Banner ZSU
if (get_locale() == 'uk')
	get_template_part('template-parts/banner-zsu');

// Main Header
get_template_part('template-parts/main-header', get_post_type());

// Section Hero
get_template_part('template-parts/homepage/hero', get_post_type());

// Section Advantages
get_template_part('template-parts/homepage/advantages', get_post_type());

// Section Achievments
get_template_part('template-parts/homepage/achievments', get_post_type());

if (get_locale() !== 'pl_PL')
	// Section Main Awards
	get_template_part('template-parts/homepage/main-awards', get_post_type());

// Section Dignity
get_template_part('template-parts/homepage/dignity', get_post_type());

if (get_locale() !== 'pl_PL') {
	// Section Students Reviews
	get_template_part('template-parts/homepage/students-reviews', get_post_type());
	// Section Main Projects
	get_template_part('template-parts/homepage/main-projects', get_post_type());
}

// Section Appeal
get_template_part('template-parts/homepage/appeal', get_post_type());

// Main Footer
get_template_part('template-parts/main-footer');

get_footer();