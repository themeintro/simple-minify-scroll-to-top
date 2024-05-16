<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class SMSTT_Frontend {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'smstt_frontend_enqueue_plugin_styles'));
    }

    public function smstt_frontend_enqueue_plugin_styles() {
        wp_enqueue_style('smstt-frontend-font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',SMSTT_PLUGIN_VERSION, 'all');
        wp_enqueue_script('jquery');
    }
}

new SMSTT_Frontend();


?>