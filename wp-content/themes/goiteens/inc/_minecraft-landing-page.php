<?php
defined( 'ABSPATH' ) || exit;

add_action('acf/init', 'goiteens_minecraft_landing_page_acf_blocks_init');
function goiteens_minecraft_landing_page_acf_blocks_init()
{

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'minecraft-landing-page',
            'title'             => __('GoIteens: Minecraft Landing Page'),
            'description'       => __('A custom Minecraft Landing Page block.'),
            'render_template'   => 'blocks/minecraft-landing-page/page.php',
            'category'          => 'goiteens-layout-category',
            'enqueue_style' => get_template_directory_uri() . '/assets/css/bundle.css',
            'keywords'          => ['goiteens', 'minecraft', 'minecraft landing page'],
        ));
    }
}



