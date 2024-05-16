<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class SMSTT_Backend {
    public function __construct() {

        $this->smstt_enqueue_plugin_styles();
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
            wp_enqueue_style('smstt-backend-styles', plugin_dir_url(__FILE__) . 'assets/css/backend-style.css', array(), '1.0');
    }
    public function smstt_plugin_page() {

      
        ?>
        <div class="smstt_plugin_page-area">
            <div class="smstt-option-box">
                <h1><?php esc_html_e( 'Scroll To Top Settings','simple-minify-scroll-to-top');?></h1>
    
                <form method="post" action="">
                    <?php wp_nonce_field( 'smstt_submit_data_nonce', 'smstt_submit_data_nonce_field' ); ?>
                    <table class="smstt-form-table">
                        <tr>
                            <th scope="row"><label class="label-text" for="smstt_icon_color"><?php esc_html_e( 'Icon color ','simple-minify-scroll-to-top');?></label></th>
                            <td class="data-table-items">
                                <input type="color" id="smstt_icon_color" name="smstt_icon_color" value="<?php echo esc_attr(get_option('smstt_icon_color','#fff')); ?>" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label class="label-text" for="smstt_icon_bg_color"><?php esc_html_e( 'Background color ','simple-minify-scroll-to-top');?></label></th>
                            <td class="data-table-items">
                                <input type="color" id="smstt_icon_bg_color" name="smstt_icon_bg_color" value="<?php echo esc_attr(get_option('smstt_icon_bg_color')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label class="label-text" for="smstt_icon_hover_color"><?php esc_html_e( 'Icon hover color ','simple-minify-scroll-to-top');?></label></th>
                            <td class="data-table-items">
                                <input type="color" id="smstt_icon_hover_color" name="smstt_icon_hover_color" value="<?php echo esc_attr(get_option('smstt_icon_hover_color')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label class="label-text" for="smstt_icon_bg_hover_color"><?php esc_html_e( 'Icon hover bg color ','simple-minify-scroll-to-top');?></label></th>
                            <td class="data-table-items">
                                <input type="color" id="smstt_icon_bg_hover_color" name="smstt_icon_bg_hover_color" value="<?php echo esc_attr(get_option('smstt_icon_bg_hover_color')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label class="label-text" for="smstt_icon_size_input"><?php esc_html_e( 'Icon Size ','simple-minify-scroll-to-top');?></label></th>
                            <td class="data-table-items">
                                <input type="text" id="smstt_icon_size_input" placeholder="15px" name="smstt_icon_size_input" value="<?php echo esc_attr(get_option('smstt_icon_size_input')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label class="label-text" for="smstt_icon_border_radius"><?php esc_html_e( 'Border Radius ','simple-minify-scroll-to-top');?></label></th>
                            <td class="data-table-items">
                                <input type="text" id="smstt_icon_border_radius" placeholder="5px" name="smstt_icon_border_radius" value="<?php echo esc_attr(get_option('smstt_icon_border_radius')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label class="label-text" for="smstt_icon_bottom"><?php esc_html_e( 'Distance ','simple-minify-scroll-to-top');?></label></th>
                            <td class="data-table-items">
                                <input type="text" id="smstt_icon_bottom" placeholder="5px" name="smstt_icon_bottom" value="<?php echo esc_attr(get_option('smstt_icon_bottom')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label class="label-text" for="smstt_icon_heght"><?php esc_html_e( 'Heght ','simple-minify-scroll-to-top');?></label></th>
                            <td class="data-table-items">
                                <input type="text" id="smstt_icon_heght" placeholder="40px" name="smstt_icon_heght" value="<?php echo esc_attr(get_option('smstt_icon_heght')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label class="label-text" for="smstt_icon_width"><?php esc_html_e( 'Width ','simple-minify-scroll-to-top');?></label></th>
                            <td class="data-table-items">
                                <input type="text" id="smstt_icon_width" name="smstt_icon_width" placeholder="40px" value="<?php echo esc_attr(get_option('smstt_icon_width')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label class="label-text" for="smstt_dropdown_possion_option"><?php esc_html_e( 'Select Possion', 'simple-minify-scroll-to-top' ); ?></label></th>
                            <td class="data-table-items">
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
                            <th class="label-text" scope="row"><?php esc_html_e( 'Select Icon ', 'simple-minify-scroll-to-top' ); ?></th>
                            <td class="data-table-items">
                                <?php
                                $smstt_radio_icon_option = get_option('smstt_radio_icon_option', 'fa-solid fa-arrow-up');
                                $smstt_radio_radio_options = array(
                                    'fa-solid fa-arrow-up' => 'Top',
                                    'fa-solid fa-arrow-left' => 'Left',
                                    'fa-solid fa-arrow-right' => 'Right',
                                    'fa-solid fa-arrow-down' => 'Down',
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['smstt_submit_data_nonce_field']) && wp_verify_nonce( $_POST['smstt_submit_data_nonce_field'], 'smstt_submit_data_nonce' )) {
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
				cursor: pointer;
				padding: 6px 12px;
				position: fixed;
				-webkit-transition: all 0.2s ease 0s;
				transition: all 0.2s ease 0s;
				z-index: 999;
				display: flex;
				align-items: center;
				justify-content: center;

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
        <script>
            jQuery(document).ready(function($){
            var scrolltotop={
                //startline: Integer. Number of pixels from top of doc scrollbar is scrolled before showing control
                //scrollto: Keyword (Integer, or "Scroll_to_Element_ID"). How far to scroll document up when control is clicked on (0=top).
                setting: {startline:100, scrollto: 0, scrollduration:1000, fadeduration:[500, 100]},
                controlHTML: ' <i class="<?php echo esc_attr(get_option('smstt_radio_icon_option', 'fa-solid fa-arrow-up'))?> smsttscrolltop"></i>', //HTML for control, which is auto wrapped in DIV w/ ID="topcontrol"
                controlattrs: {offsetx:5, offsety:5}, //offset of control relative to right/ bottom of window corner
                anchorkeyword: '#top', //Enter href value of HTML anchors on the page that should also act as "Scroll Up" links

                state: {isvisible:false, shouldvisible:false},

                scrollup:function(){
                    if (!this.cssfixedsupport) //if control is positioned using JavaScript
                        this.$control.css({opacity:0}) //hide control immediately after clicking it
                    var dest=isNaN(this.setting.scrollto)? this.setting.scrollto : parseInt(this.setting.scrollto)
                    if (typeof dest=="string" && jQuery('#'+dest).length==1) //check element set by string exists
                        dest=jQuery('#'+dest).offset().top
                    else
                        dest=0
                    this.$body.animate({scrollTop: dest}, this.setting.scrollduration);
                },

                keepfixed:function(){
                    var $window=jQuery(window)
                    var controlx=$window.scrollLeft() + $window.width() - this.$control.width() - this.controlattrs.offsetx
                    var controly=$window.scrollTop() + $window.height() - this.$control.height() - this.controlattrs.offsety
                    this.$control.css({left:controlx+'px', top:controly+'px'})
                },

                togglecontrol:function(){
                    var scrolltop=jQuery(window).scrollTop()
                    if (!this.cssfixedsupport)
                        this.keepfixed()
                    this.state.shouldvisible=(scrolltop>=this.setting.startline)? true : false
                    if (this.state.shouldvisible && !this.state.isvisible){
                        this.$control.stop().animate({opacity:1}, this.setting.fadeduration[0])
                        this.state.isvisible=true
                    }
                    else if (this.state.shouldvisible==false && this.state.isvisible){
                        this.$control.stop().animate({opacity:0}, this.setting.fadeduration[1])
                        this.state.isvisible=false
                    }
                },
                
                init:function(){
                    jQuery(document).ready(function($){
                        var mainobj=scrolltotop
                        var iebrws=document.all
                        mainobj.cssfixedsupport=!iebrws || iebrws && document.compatMode=="CSS1Compat" && window.XMLHttpRequest //not IE or IE7+ browsers in standards mode
                        mainobj.$body=(window.opera)? (document.compatMode=="CSS1Compat"? $('html') : $('body')) : $('html,body')
                        mainobj.$control=$('<div id="topcontrol" class="topcontrol">'+mainobj.controlHTML+'</div>')
                            .css({position:mainobj.cssfixedsupport? 'fixed' : 'absolute', bottom:mainobj.controlattrs.offsety, right:mainobj.controlattrs.offsetx, opacity:0, cursor:'pointer'})
                            .attr({title:''})
                            .click(function(){mainobj.scrollup(); return false})
                            .appendTo('body')
                        if (document.all && !window.XMLHttpRequest && mainobj.$control.text()!='') //loose check for IE6 and below, plus whether control contains any text
                            mainobj.$control.css({width:mainobj.$control.width()}) //IE6- seems to require an explicit width on a DIV containing text
                        mainobj.togglecontrol()
                        $('a[href="' + mainobj.anchorkeyword +'"]').click(function(){
                            mainobj.scrollup()
                            return false
                        })
                        $(window).bind('scroll resize', function(e){
                            mainobj.togglecontrol()
                        })
                    })
                }
            }

            scrolltotop.init();
            });
        </script>
        <?php
    }
    
}

$SMSTT_Backend = new SMSTT_Backend();
?>