<?php
defined( 'ABSPATH' ) || exit;

/**
 * Template Python-start Page no Registration Pay
 */
add_action('template_redirect', 'goiteens_course_noregistration_autopay_template_redirect');
function goiteens_course_noregistration_autopay_template_redirect() {

    if( is_page( 'design-start-autopay' ) || is_page('fe-start-autopay') || is_page('python-start-autopay') )
    {

        /**
         * Template Python-start Page no Registration Pay
         * Add Classes
         */
        function goiteens_landing_page_no_registration_class( $classes )
        {

            $classes[] = 'lp_noregistration';

            return $classes;
        }
        add_filter( 'body_class', 'goiteens_landing_page_no_registration_class' );

        /**
         * Template Python-start Page no Registration Pay
         * Localize Script
         */
        add_action('wp_enqueue_scripts', 'goiteens_course_enqueue_scripts');
        function goiteens_course_enqueue_scripts()
        {

            $script_data_array = [
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'page' => get_the_ID(),
                'action' => 'course_child_pay',
                'product_id' => get_field('product_id'),
                'product_name' => get_field('product_name'),
                'product_price' => get_field('product_price'),
                'product_price_currency' => get_field('product_price_currency'),
                'invoice' => $_GET['invoice'],
                'messages' => [
                    'error_invoice' => __( 'Не вказано інвойс для оплати', 'goiteens' )
                ]
            ];
            wp_localize_script( 'jquery', 'ajax_goiteens_course_handle', $script_data_array );

        }

    }

}

/**
 * Template Python-start Page no Registration Pay
 * Ajax
 */
add_action('wp_ajax_course_child_pay', 'goiteens_course_child_pay');
add_action('wp_ajax_nopriv_course_child_pay', 'goiteens_course_child_pay');
function goiteens_course_child_pay()
{

    $data = $_POST['data'];

    if( !array_key_exists('invoice', $data) || empty($data['invoice']) )
    {
        wp_send_json_error([
            'message' => __( 'Invoice not Specified', 'goiteens' )
        ]);
    }

    $token = 'DNBC-3VgDWLIIrpyBab0l9bISr0C-0VO';
    $data = [
        'Lead' => [
            'productID' => $data['product_id'], // айді продукту з зохо
            'productName' => $data['product_name'], // назва продукту
            'fopID' => 1819773000102087784, // айді фопа з зохо
            'returnURL' =>  get_template_directory_uri() . "/assets/crm/pythonstartpay-no-registration/return_url.php", // перевірка статусу оплати
            'productPrice' => $data['product_price'], // ціна продукту
            'productCurrency' => $data['product_price_currency'], // валюта продукту
            'promoKey' => '', // промокод
            'promoDiscount' => 0, // знижка по промокоду (ціна мінус знижка формує ціну! не оце поле!)
            'invID' => $data['invoice'],
            'phone' => '',
            'first_name' => '',
            'email' => '',
            'ip' => $_SERVER['HTTP_CLIENT_IP'],
            'utm_content' => '',
            'utm_medium' => '',
            'utm_source' => '',
            'utm_term' => '',
            'utm_campaign' => '',
        ]
    ];

    $ch = curl_init();
    $curl_options = [];
    $url = "https://w4ppaymnew.goiteens.ua/loader.php";
    $curl_options[CURLOPT_URL] = $url;
    $curl_options[CURLOPT_RETURNTRANSFER] = true;
    $curl_options[CURLOPT_HEADER] = 0;
    $curl_options[CURLOPT_CUSTOMREQUEST] = "POST";
    $curl_options[CURLOPT_POSTFIELDS] = json_encode($data);
    $headersArray = [];
    $headersArray[] = "Authorization" . ":" . "Bearer " . $token;
    $headersArray[] = "Content-Type: application/json";
    $curl_options[CURLOPT_HTTPHEADER] = $headersArray;

    curl_setopt_array($ch, $curl_options);
    $response = json_decode(curl_exec($ch));
    curl_close($ch);

    if( 'ok' == $response->status )
    {
        $response->url = 'https://secure.wayforpay.com/invoice/' . $response->url;
        wp_send_json_success($response);
    }else{
        wp_send_json_error();
    }

}

