<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
class SMSTT_Frontend {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'smstt_frontend_enqueue_plugin_styles'));
    }

    public function smstt_frontend_enqueue_plugin_styles() {
        wp_enqueue_script('jquery');
        wp_enqueue_style('smstt-frontend-styles', plugin_dir_url(__FILE__) . 'assets/css/frontend-style.css', [], SMSTT_PLUGIN_VERSION);
        wp_enqueue_style('smstt-frontend-font-icofont', plugin_dir_url(__FILE__) . 'fontawesome/css/all.css', [], SMSTT_PLUGIN_VERSION);
    }
}

new SMSTT_Frontend();


?>