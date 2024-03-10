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
    }
    public function smstt_plugin_page() {

      
        ?>
        <div class="smstt_plugin_page-area">
            <div class="wrap smstt-option-box">
                <h1><?php esc_html_e( 'Scroll To Top Settings','smstt');?></h1>
    
                <form method="post" action="">
                    <?php wp_nonce_field( 'smstt_submit_data', 'smstt_nonce' ); ?>
                    <table class="smstt-form-table">
                        <!-- Your form fields -->
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
        <!-- JavaScript -->
        <script>
            jQuery(document).ready(function($){
            var scrolltotop={
                //startline: Integer. Number of pixels from top of doc scrollbar is scrolled before showing control
                //scrollto: Keyword (Integer, or "Scroll_to_Element_ID"). How far to scroll document up when control is clicked on (0=top).
                setting: {startline:100, scrollto: 0, scrollduration:1000, fadeduration:[500, 100]},
                controlHTML: ' <i class="<?php echo esc_attr(get_option('smstt_radio_icon_option', 'fa-solid fa-chevron-up'))?> smsttscrolltop"></i>', //HTML for control, which is auto wrapped in DIV w/ ID="topcontrol"
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