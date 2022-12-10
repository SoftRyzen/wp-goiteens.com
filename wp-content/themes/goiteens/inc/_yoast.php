<?php
defined( 'ABSPATH' ) || exit;

/* Exclude One Content Taxonomy From Yoast SEO Sitemap */
add_filter( 'wpseo_sitemap_exclude_taxonomy', 'goiteens_sitemap_exclude_taxonomy', 10, 2 );
function goiteens_sitemap_exclude_taxonomy( $value, $taxonomy)
{

    $taxonomy_to_exclude = array('qsm_category');
    if( in_array( $taxonomy, $taxonomy_to_exclude) ) return true;

}

/* Exclude One Content Post Type From Yoast SEO Sitemap */
function sitemap_exclude_post_type( $value, $post_type )
{

    $post_type_to_exclude = [
        'qsm_quiz',
        'qmn_log',
        'student_projects',
        'testemonials',
        'parent_review',
        'courses',
        'teachers',
        'speakers',
        'game_speakers',
        'partners',
        'awards'
    ];

    if( in_array( $post_type, $post_type_to_exclude) ) return true;

}
add_filter( 'wpseo_sitemap_exclude_post_type', 'sitemap_exclude_post_type', 10, 2 );
