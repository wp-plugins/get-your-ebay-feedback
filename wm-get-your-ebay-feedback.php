<?php
/*
Plugin Name: Get Your Ebay FeedBack
Plugin URI: http://www.wemiura.com/wm-get-your-feedback/
Description: Plugin thath allows to get and retrieve your Ebay Feedbacks and show them in your wordpress page, post and widgets.
Version: 1.0
Author: WeMiura
Author URI: http://www.wemiura.com
*/



class Settings_wm_get_your_ebay_feedback_Plugin {

	private $wm_get_your_ebay_feedback_general_settings_key = 'wm_get_your_ebay_feedback_general_settings';
	private $wm_get_your_ebay_feedback_advanced_settings_key = 'wm_get_your_ebay_feedback_advanced_settings';
	private $plugin_options_key = 'wm_get_your_ebay_feedback_plugin_options';
	private $plugin_settings_tabs = array();

	function __construct() {
		add_action( 'init', array( &$this, 'load_settings' ) );
		add_action( 'admin_init', array( &$this, 'register_wm_get_your_ebay_feedback_general_settings' ) );
		add_action( 'admin_init', array( &$this, 'register_wm_get_your_ebay_feedback_advanced_settings' ) );
                add_action( 'admin_menu', array( &$this, 'add_admin_menus' ) );
	}
	
        
        
	function load_settings() {
$this->general_settings = (array) get_option( $this->wm_get_your_ebay_feedback_general_settings_key );
$this->advanced_settings = (array) get_option( $this->wm_get_your_ebay_feedback_advanced_settings_key );
             
		
                $this->general_settings = array_merge( 
                        array('general_option' => 'General value'), 
                $this->general_settings );
                
                $this->advanced_settings = array_merge( 
                        array('advanced_option' => 'Advanced value'), 
                $this->advanced_settings );
		
         }
	
         
	function register_wm_get_your_ebay_feedback_general_settings() {

$this->plugin_settings_tabs[$this->wm_get_your_ebay_feedback_general_settings_key] = 'User';
		
register_setting( $this->wm_get_your_ebay_feedback_general_settings_key, $this->wm_get_your_ebay_feedback_general_settings_key );

add_settings_section( 'section_general', 'General Plugin Settings', array( &$this, 'section_general_desc' ), $this->wm_get_your_ebay_feedback_general_settings_key );

add_settings_field( 'general_option', 'A General Option', array( &$this, 'field_general_option' ), $this->wm_get_your_ebay_feedback_general_settings_key, 'section_general' );
	}
	function section_general_desc() { echo 'Shortcode Settings'; }
	function field_general_option() {
		?>
<input type="text" name="<?php echo $this->wm_get_your_ebay_feedback_general_settings_key; ?>[general_option]" value="<?php echo esc_attr( $this->wm_get_your_ebay_feedback_general_settings_key['general_option'] ); ?>" /><?php
	}
	
   
        
        function register_wm_get_your_ebay_feedback_advanced_settings() {

$this->plugin_settings_tabs[$this->wm_get_your_ebay_feedback_advanced_settings_key] = 'Shortcode Settings';
		
register_setting( $this->wm_get_your_ebay_feedback_advanced_settings_key, $this->wm_get_your_ebay_feedback_advanced_settings_key );

add_settings_section( 'section_advanced', 'Advanced Plugin Settings', array( &$this, 'section_advanced_desc' ), $this->wm_get_your_ebay_feedback_advanced_settings_key );

add_settings_field( 'advanced_option', 'A Advanced Option', array( &$this, 'field_advanced_option' ), $this->wm_get_your_ebay_feedback_advanced_settings_key, 'section_advanced' );
	}
        
	function section_advanced_desc() { echo 'Advanced Settings'; }
	function field_advanced_option() {
		?>
<input type="text" name="<?php echo $this->wm_get_your_ebay_feedback_advanced_settings_key; ?>[advanced_option]" value="<?php echo esc_attr( $this->wm_get_your_ebay_feedback_advanced_settings_key['advanced_option'] ); ?>" /><?php
	}
        
        
       
       
	function add_admin_menus() {
            global $hook_style;
$hook_style = add_options_page( 'Get Your Ebay Feedback', 'Get Your Ebay Feedback', 'manage_options', $this->plugin_options_key, array( &$this, 'wm_get_your_ebay_feedback_options_page' ) );
add_action( 'admin_footer-'. $hook_style, 'wm_get_ebay_fb_loading_ajax' );
	}
	
        
	 
	function wm_get_your_ebay_feedback_options_page() {
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->wm_get_your_ebay_feedback_general_settings_key;
                
                ?>
	<div class="wrap">	
            <h2>Get Your Ebay Feedback</h2>
         

<?php $this->plugin_options_tabs(); ?>
<?php 
	if($tab == 'wm_get_your_ebay_feedback_general_settings') {
            if(get_option('wm_get_ebay_fb_user') && get_option('wm_get_ebay_fb_user')!=''){
            include('library/settings.php');
            }else{
            include('library/user.php');    
            }
        }else if($tab == 'wm_get_your_ebay_feedback_advanced_settings'){
            include('library/general_settings.php');   
        }
    ?>
	</div>
<?php
	}
	
	function plugin_options_tabs() {
		$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->wm_get_your_ebay_feedback_general_settings_key;
                

		screen_icon();
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_options_key . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';	
		}
		echo '</h2>';
		}
	};

  


        function wm_get_ebay_fb_loading_ajax(){ 
           
            
            ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        

 jQuery(document).ajaxStart(function(){
       jQuery("#wm_get_ebay_fb_div_loading").css("display","block");
    });   
 jQuery(document).ajaxComplete(function(){
  jQuery("#wm_get_ebay_fb_div_loading").css("display","none");
});
    });
</script>


        <?php }        
        
        
// Initialize the plugin
add_action( 'plugins_loaded', create_function( '', '$Settings_wm_get_your_ebay_feedback_Plugin = new Settings_wm_get_your_ebay_feedback_Plugin;' ) );




  
function wm_get_your_ebay_feedback_plugin_settings_link($links) { 
		  $settings_link = '<a href="options-general.php?page=wm_get_your_ebay_feedback_plugin_options">' . __( 'Settings' ) . '</a>'; 
		  
		  array_push($links, $settings_link); 
		  
		  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'wm_get_your_ebay_feedback_plugin_settings_link');



function wm_get_ebay_fb_options_register()
{
    register_setting('wm_get_ebay_fb_user_option', 'wm_get_ebay_fb_user');
    register_setting('wm_get_ebay_fb_general_option', 'wm_get_ebay_fb_shortcode_option');   
}

add_action ('admin_init', 'wm_get_ebay_fb_options_register');


function wm_get_ebay_fb_default_option(){
    
    add_option('wm_get_ebay_fb_shortcode_option',array(
        'transaction' => 'slide',
        'border_px' => 0,
        'border_color' => '#ffffff',
        'bg_color' => '#ffffff',
        'show_quote' => true,
        'show_author' => true,
        'show_divider' => true,
        'show_text' => true,
        'show_item' => true,
        'show_date' => true
    ));
    
    
}


register_activation_hook( __FILE__, 'wm_get_ebay_fb_default_option');



function wm_get_ebay_fb_table() {
   global $wpdb;
  
   $table_name = $wpdb->prefix . "wm_get_ebay_fb_table";
      if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
	{
   $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  CommentingUser varchar(225) DEFAULT '' NOT NULL,
  CommentingUserScore varchar(225) DEFAULT '' NOT NULL,
  CommentText varchar(225) DEFAULT '' NOT NULL,
  CommentTime varchar(225) DEFAULT '' NOT NULL,
  CommentType varchar(225) DEFAULT '' NOT NULL,
  ItemID varchar(225) DEFAULT '' NOT NULL,
  FeedbackID varchar(225) NOT NULL,
  TransactionID varchar(225) DEFAULT '' NOT NULL,
  OrderLineItemID varchar(225) DEFAULT '' NOT NULL,
  ItemTitle varchar(225) DEFAULT '' NOT NULL,
  ItemPrice varchar(225) DEFAULT '' NOT NULL,
  PRIMARY KEY (id),  
  UNIQUE FeedbackID (FeedbackID) );";
        }

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
 
}

register_activation_hook( __FILE__, 'wm_get_ebay_fb_table' );


add_action('wp_footer','call_to_slick');

function call_to_slick(){
    
if (get_option('wm_get_ebay_fb_shortcode_option')['transaction']=='slide') { $fade =  "false"; $adaptiveHeight = "true"; } else { $fade = "true"; $adaptiveHeight = "false"; }  
    ?>
<script type="text/javascript">
 jQuery(document).ready(function(){
	jQuery('.wm_get_ebay_fb_shortcode').slick({
            adaptiveHeight: <?php echo $adaptiveHeight; ?>,
            fade: <?php echo $fade; ?>,
            cssEase: 'linear',
            prevArrow: '<button type="button" data-role="none" class="fa fa-caret-square-o-left" style="display: block;color:<?php echo get_option('wm_get_ebay_fb_shortcode_option')['quote_color']; ?>"></button>',
            nextArrow: '<button type="button" data-role="none" class="fa fa-caret-square-o-right" style="display: block;color:<?php echo get_option('wm_get_ebay_fb_shortcode_option')['quote_color']; ?>"></button>'
        });
        
        
        
        
    });

</script>
<?php
}


function wm_get_ebay_fb_replace4byte($string) {
    return preg_replace('%(?:
          \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
        | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
        | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
    )%xs', '', $string);    
}




require_once 'library/ajax.php';
require_once 'library/external_files.php';
require_once 'library/shortcode.php';
require_once 'library/widget.php';
require_once 'library/cron.php';

?>