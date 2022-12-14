<?php
/*
Template Name: Itmarathon Page
*/

/**
 * Google Fonts
 */
add_action('wp_enqueue_scripts', 'goiteens_template_page_itmarathon_enqueue_styles', 20);
function goiteens_template_page_itmarathon_enqueue_styles()
{

    wp_enqueue_style('montserrat-alternates', 'https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400;700&display=swap');

}

if( is_page( 'marathon_newyear' ) )
{
    add_filter('body_class', 'goiteens_template_page_itmarathon_add_body_classes');
    function goiteens_template_page_itmarathon_add_body_classes($classes) {
        $classes[] = 'itm_newyear';
        return $classes;
    }
}

get_header();
?>

<?php get_template_part( 'template-parts/itmarathon/header'  ); ?>

<main>

    <?php
    if( is_page( 'marathon_newyear' ) )
    {
        get_template_part( 'template-parts/itmarathon/expect' );
    }else{

        get_template_part( 'template-parts/itmarathon/profession'  );
        get_template_part( 'template-parts/itmarathon/for', get_post_type()  );
        get_template_part( 'template-parts/itmarathon/result', get_post_type()  );
        get_template_part( 'template-parts/itmarathon/study', get_post_type()  );
        get_template_part( 'template-parts/itmarathon/projects', get_post_type()  );
        get_template_part( 'template-parts/itmarathon/how', get_post_type()  );
        get_template_part( 'template-parts/itmarathon/schedule', get_post_type()  );
        get_template_part( 'template-parts/itmarathon/lesson', get_post_type()  );
        get_template_part( 'template-parts/itmarathon/why', get_post_type()  );
        get_template_part( 'template-parts/itmarathon/help', get_post_type()  );

    }
    ?>

</main>
<?php get_template_part( 'template-parts/main-footer'  ); ?>
<?php
get_footer();
