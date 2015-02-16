<?php
// Add Shortcode

function wm_get_ebay_fb_shortcode($atts) {
    ob_start();
    global $wpdb;
    $feedbacks = $wpdb->get_results("select * from ".$wpdb->prefix . "wm_get_ebay_fb_table");
    
    
 ?>
<div class="wm_get_ebay_fb_shortcode" style="background: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['bg_color']; ?>; border: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['border_px']; ?>px solid; border-color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['border_color']; ?>">
    <?php foreach($feedbacks as $feedback)  if($tmp++ < 5) { ?>
    <div>
        <?php if(array_key_exists('show_quote', get_option('wm_get_ebay_fb_shortcode_option'))) { ?>
        <i class="fa fa-quote-right" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['quote_color']; ?>"></i>
        <?php } ?>
        <?php if(array_key_exists('show_author', get_option('wm_get_ebay_fb_shortcode_option'))) { ?>
        <div class="commenting_user" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['user']; ?>"><i class="fa fa-user"></i><?php echo $feedback->CommentingUser; ?></div>
        <?php } ?>
        <?php if(array_key_exists('show_divider', get_option('wm_get_ebay_fb_shortcode_option'))) { ?>
        <div><span class="wm_get_ebay_fb_separator"><i class="fa fa-ellipsis-h" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['quote_color']; ?>"></i></span></div>
        <?php } ?>
        <?php if(array_key_exists('show_text', get_option('wm_get_ebay_fb_shortcode_option'))) { ?>
        <div class="commenting_text" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['text']; ?>"><?php echo base64_decode($feedback->CommentText); ?></div>
        <?php } ?>
        <?php if(array_key_exists('show_item', get_option('wm_get_ebay_fb_shortcode_option'))) { ?>
        <div class="item_title" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['product']; ?>"><?php echo $feedback->ItemTitle; ?></div>
        <?php } ?>
        <?php if(array_key_exists('show_date', get_option('wm_get_ebay_fb_shortcode_option'))) { ?>
        <div class="comment_time" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['date']; ?>"><i><?php echo date('d-m-Y H:i:s',strtotime($feedback->CommentTime)); ?></i></div>
        <?php } ?>
    </div>
    <?php } ?>
     
</div>
<?php /* 
<div class="wm_get_ebay_fb_footer">
        <span class="wm_get_ebay_fb_logo_ebay"><img src="<?php echo plugin_dir_url(__FILE__).'img/logo_ebay.png'; ?>" /></span>
    </div> 
 */ ?>
<?php
$output_string=ob_get_contents();;
ob_end_clean();

return $output_string;
}



add_shortcode( 'wm_getebayfb', 'wm_get_ebay_fb_shortcode' );




?>