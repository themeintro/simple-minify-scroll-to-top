<?php
/**
 * Plugin Name:       Simple Minify Scroll To Top
 * Plugin URI:        https://wordpress.org/plugins/simple-minify-scroll-to-top/
 * Description:       Introducing Simple Minify Scroll To Top - a lightweight plugin designed to enhance user experience by providing a smooth scrolling functionality to swiftly navigate to the top of your webpage. With its minimalist design and efficient code structure, this plugin ensures fast loading times and seamless performance, making it an ideal choice for optimizing your website's usability.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Themeintro
 * Author URI:        https://themeintro.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       simple-minify-scroll-to-top
 */

if (!defined('ABSPATH')) {
    exit;
}

// PLUGIN_VERSION
define('SMSTT_PLUGIN_VERSION', '1.0.0');

class SMSTTClass {

    public function __construct() {
        $this->smstt_backend();
        $this->smstt_frontend();

        register_activation_hook(__FILE__, array($this, 'smstt_register_activation_hook'));
        register_deactivation_hook(__FILE__, array($this, 'smstt_register_deactivation_hook'));
    }

    public function smstt_backend() {
        require_once plugin_dir_path(__FILE__) . 'backend/backend.php';
    }

    public function smstt_frontend() {
        require_once plugin_dir_path(__FILE__) . 'frontend/frontend.php';
    }

    public function smstt_register_activation_hook() {
        
        $databasesmstt  = new SMSTT_Backend();
        $databasesmstt->smstt_submit_data();

    }

    public function smstt_register_deactivation_hook(){
        // Perform deactivation tasks if any
    }
}

new SMSTTClass();
