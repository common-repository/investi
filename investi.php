<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Plugin Name: Investi 
* Plugin URI: https://web.investi.com.au/wordpress-plugin
* Description: Share Price Charts and Widgets. Our comprehensive and timely data quickly summarises your current and historical share price performance,displaying charts and widgets to enhance engagement with your investor audience.
* Version: 1.0.6
* Author: Investi Services Pty Ltd
* Author URI: https://web.investi.com.au
* Requires PHP:      7.2
* Requires at least: 5.2
* License: GPLv2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
**/
foreach (glob(__DIR__ . '/includes/*.php') as $filename) { 
    include $filename;
}



function investi_getApiKey() {
  $apiKey = get_option('investi-apikey');        
  if(empty($apiKey) and get_option('investi-apikey-saved') != "1"){
      $apiKey = "c8d685c4-f8b5-48bb-a046-0874b66cec72";
  }
  return $apiKey;
}

define('INVESTI_BASE_URL', 'https://api.investi.com.au');
define('INVESTI_JS', INVESTI_BASE_URL."/investi.js");

add_action('wp_enqueue_scripts','investi_init');

function investi_init() {  
    if(get_option('investi-do-not-add-css') != "1"){
        
        wp_register_style('investi-css', INVESTI_BASE_URL."/investi-widget.css");
        wp_enqueue_style('investi-css');
    }  
    

    $apiKey = investi_getApiKey();
    wp_enqueue_script('investi-js', INVESTI_BASE_URL."/investi.js?apiKey=$apiKey", '', '', true);//load in footer
}

if (is_admin()) {
    add_action('admin_menu', 'investiMenu');

    function investiAdmin() {
      
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
      include_once __DIR__ . '/views/investi-install.php';
    }



    function investiMenu() {
        $investiIcon = base64_encode(
           '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 230.2 104.1"><defs><style>.cls-1{fill:#00b5d1;}.cls-2{fill:#fff;}</style></defs><title>investi sample logo RGB_Inverse</title><path class="cls-1" d="M116.7,83.3c-.4,1.9-.7,4-1.1,6s-2.5,9.7-7.1,9.7c-2.7,0-7-2.7-7-5.3a1.9,1.9,0,0,1,1.4-1.8h.1v.3a3.2,3.2,0,0,0-.3.9c0,2.5,3.4,4.9,5,4.9,5.7,0,7-10.2,7.2-12h-.1c-.1.2-2.1,2.8-3.2,3.2h-.4c-.6-.3-1.4-1.2-1.4-1.7s.8-4.4,1.5-4.3a1.2,1.2,0,0,1,.9.4c-.2.9-1.1,2.6-1.1,3.8v.4h.1c.6.1,2.6-2.6,3-3a22.5,22.5,0,0,1,1.2-2.1l1.1-2.4h.2a1.7,1.7,0,0,1,1,.7C117.6,81.6,116.8,82.9,116.7,83.3Z"/><path class="cls-1" d="M122.6,80.7l.8.6a2.9,2.9,0,0,1,.6,1.9c.1,2.1-1.7,5.5-3.8,5.7s-2.2-1.6-2.2-2.4a6.1,6.1,0,0,1,.3-1.6c.2-.6,1.4-3.1,1.9-3.1h.2c0-.1-.2-.3.1-.6a3.2,3.2,0,0,1,1.6-.6Zm.1,1.1c-.1-.3-.3-.6-.6-.5a8.4,8.4,0,0,0-1,1.2l-1,1.8a5.6,5.6,0,0,0-.8,2.7,1,1,0,0,0,.4.8c1.6-.6,3.3-3.6,3.2-5A2.2,2.2,0,0,0,122.7,81.8Z"/><path class="cls-1" d="M134.1,85.7l-.4.2a2.8,2.8,0,0,1-1.4,1.7l-.5.2a2.4,2.4,0,0,1-1.8-1.3,4.3,4.3,0,0,1-.2-1.1,17.9,17.9,0,0,1-2.1,2.4,1.8,1.8,0,0,1-2.1-.3,2.6,2.6,0,0,1-.4-1,11.6,11.6,0,0,1,1.2-4.4h.2c-.1-.2,0-.6.1-.6h.2v-.9h.2c.4,0,1.1.4,1.1.7s-1.9,3.6-1.8,5.5c0,.1,0,.4.2.4s4.3-5.4,4.5-6.3.2-.3.4-.3a2,2,0,0,1,.9.6c0,.1-.1.2-.1.4a10.4,10.4,0,0,0-1.2,4.5c0,.1.2.7.4.8s1.6-1.6,1.8-1.8h.4c.2,0,0,0,.1-.1s.2-.8.6-1.1h.2s.1,0,.1.2A8,8,0,0,1,134.1,85.7Z"/><path class="cls-1" d="M139.7,82.4H139c-.1,0-.1,0-.1-.2s.3-1.1.3-1.2-.1-.2-.1-.2h-.2a3.6,3.6,0,0,0-1.9,1.3,8.5,8.5,0,0,0-1.3,2.2c-.2.5-.6,2.3-.8,2.9s-.2.2-.4.2-1-.6-1-.8,1.1-4.3,1.6-6.4l.4-.4c.4,0,1,.5,1,.7a8.3,8.3,0,0,0-.4,1.2,4.7,4.7,0,0,1,2.9-2.1c.4.1,1.6.4,1.6,1.1A2.9,2.9,0,0,1,139.7,82.4Z"/><path class="cls-1" d="M165.6,88.5a10.8,10.8,0,0,1-2.5-.4c-2.6-.9-8.2-7.3-8.2-8.3s-.3,1.1-.5,1.7-.3,1.9-.4,2.8a6.5,6.5,0,0,1,0,1.4l-.4.4c-.5,0-1.1-.9-1.1-1.2a17.7,17.7,0,0,1,1.7-6.6c-.1-.1,0-.5,0-.8a.5.5,0,0,1,.5.1c0-.2-.2-.4-.2-.6s.6-1.7.9-2.5h-.7c-.5.1-1.4.3-1.5.6a1.9,1.9,0,0,1,.2.7c-.1.1,0,.1-.2.1s-1.9-.6-1.9-1.3,2.7-1,2.9-1h1.4a3.5,3.5,0,0,0,.1-1.3h.2c1.6,0,1,1.5,1.1,1.4h.2c.6,0,5.8.3,6.2,2.4a2.4,2.4,0,0,1-.7,1.9,12.4,12.4,0,0,1-5.7,2.9c1,1.6,6,6.7,8.5,6.8a7.2,7.2,0,0,0,2.5-.4c.1,0,.2.2.2.3S166.1,88.5,165.6,88.5Zm-8.9-13.9a33.9,33.9,0,0,0-1.4,3.9c-.1.3-.2.8-.2.8s.4-.2.8,0l.6.3a8.9,8.9,0,0,0,4.9-2.1c.3-.3.8-.8.7-1.2S158.1,74.6,156.7,74.6Z"/><path class="cls-1" d="M175.1,78.5h-.3a.6.6,0,0,1-.6-.4c0-.2.4-.7.4-.9s-.4-.3-.4-.3-1.5.6-1.4,1.9a34,34,0,0,1,1,4.6,1.8,1.8,0,0,1-1.9,1.9c-.8,0-2.1-.7-2.1-1.7a1.3,1.3,0,0,1,.5-.7h.5c.1.1.1.1.1.3s-.3.4-.3.6.5.5.6.5a1.3,1.3,0,0,0,1.2-1.5c.1-.4-.9-4.2-.9-4.6s1.4-2.2,2.4-2.3,2.1.5,2.2,1.5S175.6,78.5,175.1,78.5Z"/><path class="cls-1" d="M180.7,76.2a2.4,2.4,0,0,1,.8.6,3.7,3.7,0,0,1,.7,1.9c0,2.1-1.8,5.5-3.8,5.7s-2.2-1.6-2.3-2.4a8,8,0,0,1,.3-1.6c.2-.6,1.4-3.1,1.9-3.1s.1,0,.2.1a.7.7,0,0,1,.2-.7,2.6,2.6,0,0,1,1.5-.6Zm.2,1.1c-.2-.3-.4-.5-.7-.4a3.5,3.5,0,0,0-.9,1.2,12,12,0,0,0-1.1,1.7,5.6,5.6,0,0,0-.8,2.7c.1.2.1.6.4.8s3.3-3.5,3.3-5A8.4,8.4,0,0,1,180.9,77.3Z"/><path class="cls-1" d="M189.5,80.7c-.7,1.5-2.3,3.2-3.5,3.4a3.2,3.2,0,0,1-1.5-.8,4.2,4.2,0,0,1-1.2-2.4c-.2-2.4,1.4-5.8,2.2-7.5a24.5,24.5,0,0,1,1.6-2.8c.4,0,1.3.4,1.3,1s-1.2,3.7-1.8,4.5-1.1,1.5-1.5,2.3a6.2,6.2,0,0,0-.4,2.5c0,.4.4,2.1,1,2.1s3.4-2.9,3.7-3.5a.3.3,0,0,1,.4.3A4.6,4.6,0,0,1,189.5,80.7ZM186.6,74a18.5,18.5,0,0,0-1.2,2.6,4.8,4.8,0,0,0,.9-1.3l.9-1.3c.1-.3-.2-.3.2-.8s.2-.7,0-1A14.2,14.2,0,0,0,186.6,74Z"/><path class="cls-1" d="M197.9,80.8c-.1.1-.2,0-.3.2s-.7,1.5-1.4,1.7l-.6.2a2.4,2.4,0,0,1-1.7-1.3l-.3-1.1a12.7,12.7,0,0,1-2,2.4,1.9,1.9,0,0,1-2.1-.3,1.6,1.6,0,0,1-.4-1c-.1-1.3.7-3.2,1.1-4.4s.2,0,.2-.1.1-.6.2-.6h.1c0-.3.1-.6.1-.9s0-.1.2-.1,1.1.4,1.1.6-2,3.7-1.8,5.6c0,.1,0,.4.1.4s4.4-5.4,4.5-6.3a.5.5,0,0,1,.4-.3,2,2,0,0,1,.9.6c.1.1-.1.2-.1.4A11.4,11.4,0,0,0,195,81c0,.2.1.8.3.9a17,17,0,0,0,1.9-1.8h.4c.1,0,0-.1,0-.1a2,2,0,0,1,.6-1.1h.2s.1,0,.1.2A8,8,0,0,1,197.9,80.8Z"/><path class="cls-1" d="M206.1,75.4c-.1.2-.8.4-1.1.5a17.4,17.4,0,0,0-3.2,1c-.3.1-.8.2-.9.4s-.9,1.8-.6,2.2a14.9,14.9,0,0,1-.9,3.1H199a2.2,2.2,0,0,1-.6-1.3c-.1-1.2.8-2.6.8-3.1s-.9-.7-1-1.5,1.1-.4,1.9-.8v-.2a3.4,3.4,0,0,0,.3-.8,6.1,6.1,0,0,0,.5-1.1,20.1,20.1,0,0,1,1.8-4.6c.2,0,.9.5.9.8l-2.2,5.6h.7l2.1-.3a9.7,9.7,0,0,1,1.8-.1v.3Z"/><path class="cls-1" d="M209.5,81h-.2c0,.3-1,1.4-1.6,1.4a2.8,2.8,0,0,1-2.5-2.7c0-.1,1.1-4.4,1.7-4.4a1.8,1.8,0,0,1,1.1.8,20.2,20.2,0,0,0-1.4,4.2c0,.3,0,.9.4.9s3.9-3,3.9-3,.4.4.4.5A25,25,0,0,1,209.5,81Zm.9-9.2c-.4.2-1.4.4-1.7.8s-.1.6-.3.6-1.1-1-1.1-1.1,1.4-1,1.7-1,0,.1.2.1,0-.2.2-.2h.7c1.2,0,1.3.1,1.5.4S210.7,71.7,210.4,71.8Z"/><path class="cls-1" d="M214.8,73.9l.8.5a3.1,3.1,0,0,1,.6,2c.1,2-1.7,5.5-3.7,5.6s-2.3-1.5-2.3-2.4a8,8,0,0,1,.3-1.6c.2-.6,1.4-3,1.9-3.1h.2c0-.2-.2-.4.1-.6a2.7,2.7,0,0,1,1.6-.7Zm.1,1.1c-.1-.4-.3-.6-.6-.5a3.5,3.5,0,0,0-.9,1.2l-1.1,1.7a6,6,0,0,0-.8,2.8c.1.2.1.6.4.7s3.3-3.5,3.3-4.9A2.9,2.9,0,0,0,214.9,75Z"/><path class="cls-1" d="M223.9,81a2.6,2.6,0,0,1-1.8-.9,1.9,1.9,0,0,1-.3-1.5,3.7,3.7,0,0,1,.1-1.4,6,6,0,0,1,.2-1.2s0-.2-.1-.2a35,35,0,0,0-3.3,4.9h-.3a1.6,1.6,0,0,1-1.1-.7c0-.1.9-3.8,1.3-5.3s.5-.3.7-.3.6.2.7.4l-.5,2,1.7-1.7.2-.2.4-.4a1.8,1.8,0,0,1,.9-.7c.3,0,1.2.1,1.2.6a21.8,21.8,0,0,0-.8,4.5c0,.2.1,1.1.5,1l.7-.3.5-.3c.2-.2.1-.2.4-.4l1.4-1.7c.1,0,.2.1.2.3S224.8,80.9,223.9,81Z"/><path class="cls-1" d="M147.5,86.8c-.7.5-.7,1.5-1.3,1.6s-.9-.8-.9-1,3.3-14.6,4.3-14.7,1,.6,1,.8-1.1,2.8-1.5,4.1l-2,7.6h.2S149.5,85.4,147.5,86.8Z"/><path class="cls-2" d="M18,29.3a.9.9,0,0,1,1,1V64.5c0,.7-.3,1-1,1H12c-.6,0-.9-.3-.9-1V30.3c0-.6.3-1,.9-1Z"/><path class="cls-2" d="M56.6,44.5v20c0,.7-.4,1-1.1,1H49.6c-.6,0-.9-.3-.9-1V45.9c0-9.6-1.5-10-7.7-10H33.5V64.5c0,.7-.3,1-1,1h-6c-.7,0-.9-.3-.9-1V31.1c0-.9.3-.9.9-1.1a84.7,84.7,0,0,1,14.6-1C53.2,29,56.6,30.8,56.6,44.5Z"/><path class="cls-2" d="M93.3,29.3c.7,0,.9.2.8,1.1L86.7,58.1c-1.8,6.9-2.3,7.7-9.7,7.7s-7.3-.8-9.2-7.7L60.1,30.4c-.1-.9.1-1.1.8-1.1h6.5c.5,0,.6.2.9,1.1l6.8,26c.6,2.3.8,2.6,1.9,2.6s1.7-.3,2.3-2.6l6.6-26c.2-.9.3-1.1.8-1.1Z"/><path class="cls-2" d="M128.3,46.7v2c0,1.2-.4,1.8-2.3,1.8H105.3c.2,6.9,1.8,8.5,8.1,8.5h11.2c.6,0,1,.3,1,.9V64a1,1,0,0,1-.9,1.1,86.1,86.1,0,0,1-11.8.7c-12.7,0-15.6-3.6-15.6-18.4S100.2,29,112.9,29,128.1,32.5,128.3,46.7Zm-23-1.9h15c-.1-7.1-1.5-8.9-7.4-8.9S105.4,37.7,105.3,44.8Z"/><path class="cls-2" d="M183.3,59h-2.8c-3.3,0-4.1-.6-4.1-3.5V35.6h6.5a.9.9,0,0,0,1-1V30.4a.9.9,0,0,0-1-1h-6.5V20.2c0-.7-.4-1.1-1.1-.9l-6,1.5c-.6.2-.9.4-.9,1.1v7.5h-4.3c-4.6-.4-13.6-.4-16.1-.4-8.2,0-14.1,1.6-14.1,8.8v1.3c0,3.8,1.5,7.8,6.6,9.6l8.6,3.3c3,1.1,3.8,2.1,3.8,3.7v.6c0,2.3-1.4,2.9-5.8,2.9H134.4c-.8,0-1,.3-1,1v4.1a.8.8,0,0,0,.9.9c2.2.2,7.1.6,12.8.6,8.6,0,13.5-1.7,13.5-9.1v-.9c0-4-.9-7.4-6.6-9.5l-8.6-3.2c-2.7-1-3.6-2.3-3.6-3.8v-.8c0-2,1.6-2.9,4.3-2.9h22.3V57.9c0,7.8,5.3,7.9,10.4,7.9a32.6,32.6,0,0,0,4.7-.4,1.1,1.1,0,0,0,.9-1.2V59.9C184.4,59.2,184.1,59,183.3,59Z"/><path class="cls-2" d="M197,29.3a.9.9,0,0,1,1,1V64.5c0,.7-.3,1-1,1h-5.9c-.7,0-1-.3-1-1V30.3a.9.9,0,0,1,1-1Z"/><path class="cls-1" d="M15,25A10.1,10.1,0,1,1,25.1,14.9,10.1,10.1,0,0,1,15,25Zm0-14.8a4.7,4.7,0,1,0,4.7,4.7A4.7,4.7,0,0,0,15,10.2Z"/><path class="cls-1" d="M194,25a10.1,10.1,0,1,1,10.1-10.1A10.1,10.1,0,0,1,194,25Zm0-14.8a4.7,4.7,0,1,0,4.7,4.7A4.7,4.7,0,0,0,194,10.2Z"/></svg> '
        );

        add_menu_page('Investi', 'Investi', 'manage_options', 'investi', 'investiAdmin', 'data:image/svg+xml;base64,' . $investiIcon);
       
    }
    
    
}

function investi_admin_init() {

    // if (!function_exists('check_admin_referer')) die("check_admin_referer function does not exist");

    if (isset($_POST['investi-apikey']) && check_admin_referer( 'investi-admin-save' )) {
        
        update_option('investi-apikey', sanitize_text_field($_POST['investi-apikey']));
        update_option('investi-apikey-saved', '1'); 
        $doNotAddCss = '';
        if(isset($_POST['investi-do-not-add-css'])){
            $doNotAddCss = 1;
        }
        update_option('investi-do-not-add-css', $doNotAddCss);        
    }    
}
add_action( 'admin_init', 'investi_admin_init' );

add_filter( 'plugin_action_links', 'investi_admin_settings_plugin_link', 10, 2 );

function investi_admin_settings_plugin_link( $links, $file ) 
{
    if ( $file == plugin_basename(dirname(__FILE__) . '/investi.php') ) 
    {
        /*
         * Insert the link at the beginning
         */
        $in = '<a href="options-general.php?page=investi">' . __('Settings','mtt') . '</a>';
        array_unshift($links, $in);

        
    }
    return $links;
}


add_shortcode( 'investi-announcements-accordion', 'investi_accordion_func' );
add_shortcode( 'investi-share-price', 'investi_shareprice_func' );
add_shortcode( 'investi-share-price-chart', 'investi_shareprice_chart_func' );
add_shortcode( 'investi-announcements-summary-v2', 'investi_announcements_summary_v2_func' );
add_shortcode( 'investi-announcements-tab', 'investi_announcements_tab_func');
add_shortcode( 'investi-share-price-table', 'investi_share_price_table_func');
add_shortcode( 'investi-carousel', 'investi_carousel_func');

add_shortcode( 'investi-share-price-symbol', 'investi_share_price_symbol_func' );
add_shortcode( 'investi-share-price-last', 'investi_share_price_last_func' );
add_shortcode( 'investi-market-cap', 'investi_share_price_market_cap_func' );
add_shortcode( 'investi-shares-on-issue', 'investi_share_price_shares_on_issue_func' );
add_shortcode( 'investi-share-price-movement-percent', 'investi_share_price_movement_percent_func' );
add_shortcode( 'investi-share-price-movement', 'investi_share_price_movement_func' );
add_shortcode( 'investi-share-price-volume', 'investi_share_price_volume_func' );
add_shortcode( 'investi-share-price-prevClose', 'investi_share_price_prevClose_func' );
add_shortcode( 'investi-share-price-low', 'investi_share_price_low_func' );
add_shortcode( 'investi-share-price-low52Week', 'investi_share_price_low52Week_func' );
add_shortcode( 'investi-share-price-high', 'investi_share_price_high_func' );
add_shortcode( 'investi-share-price-high52Week', 'investi_share_price_high52Week_func' );
add_shortcode( 'investi-share-price-ask', 'investi_share_price_ask_func' );
add_shortcode( 'investi-share-price-open', 'investi_share_price_open_func' );
add_shortcode( 'investi-share-price-bid', 'investi_share_price_bid_func' );
add_shortcode( 'investi-share-price-updated', 'investi_share_price_updated_func' );