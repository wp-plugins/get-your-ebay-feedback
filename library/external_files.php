<?php

add_action('wp_enqueue_scripts', 'wm_get_ebay_fb_scripts_styles', 999);

function wm_get_ebay_fb_scripts_styles(){

wp_enqueue_script( 'slick', plugin_dir_url(__FILE__) . '../js/slick.min.js', array( 'jquery' ), '', false );


wp_enqueue_style( 'slick_style', plugin_dir_url(__FILE__) . '../css/slick.css');
wp_enqueue_style( 'wm_get_ebay_fb_style', plugin_dir_url(__FILE__) . '../css/wm_get_ebay_fb.css');
wp_enqueue_style( 'fontawesome-min', plugin_dir_url(__FILE__) . '../css/font-awesome.min.css');

}


function wm_get_ebay_fb_scripts_styles_admin($hook) {
    global $hook_style;
    if ( $hook_style != $hook ) {
        return;
    }

    wp_enqueue_style( 'wm_get_ebay_fb_scripts_styles_admin', plugin_dir_url( __FILE__ ) . '../css/wm_get_ebay_fb_admin.css' );
    wp_enqueue_style( 'fontawesome-min', plugin_dir_url(__FILE__) . '../css/font-awesome.min.css');
}

add_action( 'admin_enqueue_scripts', 'wm_get_ebay_fb_scripts_styles_admin' );


?>