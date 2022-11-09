<?php

/**
 * Blog: Enqueue Scripts
 */
add_action('wp_enqueue_scripts', 'goiteens_blog_enqueue_styles', 20);
function goiteens_blog_enqueue_styles()
{

    if(is_page_template('templates/tmpl-blog-page.php') || is_category() )
    {

        wp_enqueue_style('blog', get_stylesheet_directory_uri() . '/assets/blog/css/style.css');
        wp_enqueue_style('blog-custom', get_stylesheet_directory_uri() . '/assets/blog/css/custom.css?v=6');

        wp_enqueue_script('blog', get_stylesheet_directory_uri() . '/assets/blog/js/blog.js?v=5', array('jquery'), false, true);

        $script_data_array = [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
        ];
        wp_localize_script( 'blog', 'ajax_blog_handle', $script_data_array );

    }

}

/**
 * Blog: Load More
 * @return void
 */
function goiteens_blog_load_more()
{

    $default_posts_per_page = 3;
    $offset = ( $_POST['paged'] - 1 ) * $default_posts_per_page + 1;

    $ajaxposts = new WP_Query([
        'posts_per_page' => $default_posts_per_page,
        'offset' => $offset,
        'paged' => $_POST['paged'],
    ]);

    $response = '';
    $max_pages = $ajaxposts->max_num_pages;

    if($ajaxposts->have_posts())
    {

        ob_start();
        while($ajaxposts->have_posts()) : $ajaxposts->the_post();
            $response .= get_template_part('template-parts/content', 'post');
        endwhile;
        $output = ob_get_contents();
        ob_end_clean();

    } else {

        $response = '';

    }

    $result = [
        'max' => $max_pages,
        'items' => $output,
    ];

    echo json_encode($result);
    wp_die();
}
add_action('wp_ajax_blog_load_more', 'goiteens_blog_load_more');
add_action('wp_ajax_nopriv_blog_load_more', 'goiteens_blog_load_more');


