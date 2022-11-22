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

/**
 * Contact Form 7 After Mail Sent
 */
add_action('wpcf7_mail_sent', function ($contact_form)
{

    $form_id = $contact_form->id();

    $submission = WPCF7_Submission::get_instance();
    $posted_data = $submission->get_posted_data();

    /**
     * Form Subscribe
     */
    if( array_key_exists('action', $posted_data) && $posted_data['action'] == 'blog_subscribe' )
    {

        require get_template_directory() . '/assets/crm/Esputnik.php';
        $esputnik = new Esputnik($posted_data);

    }

    /**
     * Form Order
     */
    if( array_key_exists('action', $posted_data) && $posted_data['action'] == 'blog_order' )
    {

        $token = 'DNBC-3VgDWLIIrpyBab0l9bISr0C-0VO';
        $postfields = [
            'Lead' => [
                'productID' => 1819773000329070325,         // айді продукту з зохо
                'productName' => "GoITeens_UA_AutoDesign",  // назва продукту
                'fopID' => 1819773000102087784,             // айді фопа з зохо
                'returnURL' => "",        // перевірка статусу оплати
                'productPrice' => '',
                'productCurrency' => "",
                'promoKey' => "",
                'promoDiscount' => 0,
                'first_name' => $posted_data['your-name'],
                'email' => $posted_data['your-email'],
                'phone' => '',
                'ip' => $_SERVER['HTTP_CLIENT_IP'],
                'utm_content' => '',
                'utm_medium' => '',
                'utm_source' => '',
                'utm_term' => '',
                'utm_campaign' => ''
            ]
        ];

        $ch = curl_init();
        $curl_options = [];
        $url = "https://w4ppaymnew.goiteens.ua/loader.php";
        $curl_options[CURLOPT_URL] = $url;
        $curl_options[CURLOPT_RETURNTRANSFER] = true;
        $curl_options[CURLOPT_HEADER] = 0;
        $curl_options[CURLOPT_CUSTOMREQUEST] = "POST";
        $curl_options[CURLOPT_POSTFIELDS] = json_encode($postfields);
        $headersArray = [];
        $headersArray[] = "Authorization" . ":" . "Bearer " . $token;
        $headersArray[] = "Content-Type: application/json";
        $curl_options[CURLOPT_HTTPHEADER] = $headersArray;

        curl_setopt_array($ch, $curl_options);
        $response = curl_exec($ch);
        //echo $response;
        curl_close($ch);

    }

});


