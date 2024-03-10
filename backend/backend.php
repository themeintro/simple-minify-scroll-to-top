<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
class SMSTT_Backend {
    public function __construct() {

        add_action('admin_enqueue_scripts', array($this,'smstt_enqueue_plugin_styles'));
        add_action('admin_menu', array($this, 'smstt_menu'));
        add_action('wp_head', array($this,'smstt_head_style'));
        add_action('admin_init', array($this,'smstt_submit_data'));
        add_action('wp_footer', array($this,'smstt_wp_footer_script'));

    }

    public function smstt_menu() {
        add_menu_page(
            'Scroll To Top',          // Page title
            'Scroll To Top',          // Menu title
            'manage_options',           // Capability
            'smstt-scrolltotop',          // Menu slug
            array($this, 'smstt_plugin_page') // Callback function to display page content
        );
    }

    public function smstt_enqueue_plugin_styles(){

        global $pagenow;
    
        // Check if it is the admin page and the specific page you want
        if (is_admin() && $pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'smstt-scrolltotop') {
            // Enqueue your scripts or styles here
            wp_enqueue_style('smstt-backend-styles', plugin_dir_url(__FILE__) . 'assets/css/backend-style.css', array(), '1.0');
        }
    
        // Add nonce verification
        wp_nonce_field( 'smstt_nonce_action', 'smstt_nonce_field' );
    }
    public function smstt_plugin_page() {
        ?>
        <div class="smstt_plugin_page-area">
            <div class="wrap smstt-option-box">
                <h1><?php esc_html_e( 'Scroll To Top Settings','smstt');?></h1>
                <form method="post" action="">
                    <?php wp_nonce_field( 'smstt_submit_data', 'smstt_nonce' ); ?>
                    <table class="smstt-form-table">
                        <tr>
                            <th scope="row"><label for="smstt_icon_color"><?php esc_html_e( 'Icon color :','smstt');?></label></th>
                            <td>
                                <input type="color" id="smstt_icon_color" name="smstt_icon_color" value="<?php echo esc_attr(get_option('smstt_icon_color','#fff')); ?>" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="smstt_icon_bg_color"><?php esc_html_e( 'Background color :','smstt');?></label></th>
                            <td>
                                <input type="color" id="smstt_icon_bg_color" name="smstt_icon_bg_color" value="<?php echo esc_attr(get_option('smstt_icon_bg_color')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="smstt_icon_hover_color"><?php esc_html_e( 'Icon hover color :','smstt');?></label></th>
                            <td>
                                <input type="color" id="smstt_icon_hover_color" name="smstt_icon_hover_color" value="<?php echo esc_attr(get_option('smstt_icon_hover_color')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="smstt_icon_bg_hover_color"><?php esc_html_e( 'Icon hover bg color :','smstt');?></label></th>
                            <td>
                                <input type="color" id="smstt_icon_bg_hover_color" name="smstt_icon_bg_hover_color" value="<?php echo esc_attr(get_option('smstt_icon_bg_hover_color')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="smstt_icon_size_input"><?php esc_html_e( 'Icon Size :','smstt');?></label></th>
                            <td>
                                <input type="text" id="smstt_icon_size_input" placeholder="15px" name="smstt_icon_size_input" value="<?php echo esc_attr(get_option('smstt_icon_size_input')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="smstt_icon_border_radius"><?php esc_html_e( 'Border Radius :','smstt');?></label></th>
                            <td>
                                <input type="text" id="smstt_icon_border_radius" placeholder="5px" name="smstt_icon_border_radius" value="<?php echo esc_attr(get_option('smstt_icon_border_radius')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="smstt_icon_bottom"><?php esc_html_e( 'Distance :','smstt');?></label></th>
                            <td>
                                <input type="text" id="smstt_icon_bottom" placeholder="5px" name="smstt_icon_bottom" value="<?php echo esc_attr(get_option('smstt_icon_bottom')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="smstt_icon_heght"><?php esc_html_e( 'Heght :','smstt');?></label></th>
                            <td>
                                <input type="text" id="smstt_icon_heght" placeholder="40px" name="smstt_icon_heght" value="<?php echo esc_attr(get_option('smstt_icon_heght')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="smstt_icon_width"><?php esc_html_e( 'Width :','smstt');?></label></th>
                            <td>
                                <input type="text" id="smstt_icon_width" name="smstt_icon_width" placeholder="40px" value="<?php echo esc_attr(get_option('smstt_icon_width')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="smstt_dropdown_possion_option"><?php esc_html_e( 'Select Possion:', 'smstt' ); ?></label></th>
                            <td>
                                <select id="smstt_dropdown_possion_option" name="smstt_dropdown_possion_option">
                                    <?php
                                    $smstt_dropdown_possion_option = get_option('smstt_dropdown_possion_option');
                                    $smstt_options = array(
                                        'right' => 'Right',
                                        'left' => 'Left',
                                    );

                                    foreach ($smstt_options as $smstt_value => $smstt_label) {
                                        echo '<option value="' . esc_attr($smstt_value) . '" ' . selected($smstt_dropdown_possion_option, $smstt_value, false) . '>' . esc_html($smstt_label) . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e( 'Select Icon :', 'smstt' ); ?></th>
                            <td>
                                <?php
                                $smstt_radio_icon_option = get_option('smstt_radio_icon_option', 'fa-solid fa-chevron-up');
                                $smstt_radio_radio_options = array(
                                    'fa-solid fa-chevron-up' => 'Top',
                                    'fa-solid fa-chevron-left' => 'Left',
                                    'fa-solid fa-chevron-right' => 'Right',
                                    'fa-solid fa-chevron-down' => 'Down',
                                );

                                foreach ($smstt_radio_radio_options as $smstt_radio_icon_option_value => $smstt_radio_icon_options_label) {
                                    echo '<label><input type="radio" name="smstt_radio_icon_option" value="' . esc_attr($smstt_radio_icon_option_value) . '" ' . checked($smstt_radio_icon_option, $smstt_radio_icon_option_value, false) . ' /> ' . esc_html($smstt_radio_icon_options_label) . '</label><br>';
                                }
                                ?>
                            </td>
                        </tr>

                    </table>
                    <?php submit_button(); ?>
                </form>
            </div>
        </div>
        <?php
    }

    // Input Data Save
    public function smstt_submit_data() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['smstt_nonce']) && wp_verify_nonce( $_POST['smstt_nonce'], 'smstt_submit_data' )) {
            // Handle form submission
            $new_icon_size = sanitize_text_field($_POST['smstt_icon_size_input']);
            $new_icon_color = sanitize_text_field($_POST['smstt_icon_color']);
            $new_icon_bg_color = sanitize_text_field($_POST['smstt_icon_bg_color']);
            $smstt_icon_hover_color = sanitize_text_field($_POST['smstt_icon_hover_color']);
            $smstt_icon_bg_hover_color = sanitize_text_field($_POST['smstt_icon_bg_hover_color']);
            $smstt_icon_border_radius = sanitize_text_field($_POST['smstt_icon_border_radius']);
            $smstt_icon_bottom = sanitize_text_field($_POST['smstt_icon_bottom']);
            $smstt_icon_heght = sanitize_text_field($_POST['smstt_icon_heght']);
            $smstt_icon_width = sanitize_text_field($_POST['smstt_icon_width']);
            $smstt_dropdown_possion_option = sanitize_text_field($_POST['smstt_dropdown_possion_option']);
            $smstt_radio_icon_option = sanitize_text_field($_POST['smstt_radio_icon_option']); // Corrected line
    
            update_option('smstt_icon_size_input', $new_icon_size);
            update_option('smstt_icon_color', $new_icon_color);
            update_option('smstt_icon_bg_color', $new_icon_bg_color);
            update_option('smstt_icon_hover_color', $smstt_icon_hover_color);
            update_option('smstt_icon_bg_hover_color', $smstt_icon_bg_hover_color);
            update_option('smstt_icon_border_radius', $smstt_icon_border_radius);
            update_option('smstt_icon_bottom', $smstt_icon_bottom);
            update_option('smstt_icon_heght', $smstt_icon_heght);
            update_option('smstt_icon_width', $smstt_icon_width);
            update_option('smstt_dropdown_possion_option', $smstt_dropdown_possion_option);
            update_option('smstt_radio_icon_option', $smstt_radio_icon_option);
        }
    }
    
    // Style Css Add
    public function smstt_head_style() {
        ?>
        <!-- CSS -->
            <style>
                .topcontrol{
                    font-size: <?php echo esc_attr(get_option('smstt_icon_size_input', '10px')); ?>;
                    background-color: <?php echo esc_attr(get_option('smstt_icon_bg_color', '#333'))?>;
                    color: <?php echo esc_attr(get_option('smstt_icon_color', '#fff'))?>;
                    border-radius: <?php echo esc_attr(get_option('smstt_icon_border_radius', '0px'))?>;
                    height:<?php echo esc_attr(get_option('smstt_icon_heght', '40px'))?>;
                    width:<?php echo esc_attr(get_option('smstt_icon_width', '40px'))?>;
                    bottom: <?php echo esc_attr(get_option('smstt_icon_bottom', '5px'))?>!important;
                    right:<?php echo esc_attr(get_option('smstt_dropdown_possion_option', '5px'))?>;

                }
                .topcontrol:hover{
                    color: <?php echo esc_attr(get_option('smstt_icon_hover_color', '#333'))?>;
                    background-color: <?php echo esc_attr(get_option('smstt_icon_bg_hover_color', '#fff'))?>;
                }
            </style>
        <?php
    }

    // wp footer script

    public function smstt_wp_footer_script(){
        ?>
        <!-- Your JavaScript -->
        <?php
    }
    
}

$SMSTT_Backend = new SMSTT_Backend();
?>
