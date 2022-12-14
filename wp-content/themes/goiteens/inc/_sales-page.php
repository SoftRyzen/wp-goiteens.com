<?php
defined( 'ABSPATH' ) || exit;

function goiteens_register_layout_category( $categories )
{

    $categories[] = array(
        'slug'  => 'goiteens-layout-category',
        'title' => 'GoIteens'
    );

    return $categories;
}

if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) )
{
    add_filter( 'block_categories_all', 'goiteens_register_layout_category' );
} else {
    add_filter( 'block_categories', 'goiteens_register_layout_category' );
}


add_action('acf/init', 'goiteens_sale_page_acf_blocks_init');
function goiteens_sale_page_acf_blocks_init()
{

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'sale-page',
            'title'             => __('GoIteens: Sale Page'),
            'description'       => __('A custom Sale Page block.'),
            'render_template'   => 'blocks/sale-page/page.php',
            'category'          => 'goiteens-layout-category',
            'enqueue_style' => get_template_directory_uri() . '/assets/css/bundle.css',
            'keywords'          => ['goiteens', 'sale', 'sale page'],
        ));
    }
}

/**
 * Update Exchange
 */
add_action( 'init', 'goiteens_exchange_p24api' );
add_action( 'exchange_p24api', 'goiteens_exchange_p24api_update' );
function goiteens_exchange_p24api()
{

    if( ! wp_next_scheduled( 'exchange_p24api' ) )
    {
        wp_schedule_event( time(), 'daily', 'exchange_p24api');
    }

}
function goiteens_exchange_p24api_update()
{

    $url = "https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5";
    $curl = curl_init($url);

    if ( $curl )
    {
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $page = curl_exec($curl);
        curl_close($curl);
        unset($curl);
        $result = json_decode( $page, true );

        if( $result )
        {
            add_option( 'exchange_privatbank', $result );
        }

    }

}



