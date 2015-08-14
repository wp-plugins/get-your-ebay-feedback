<?php

class WM_get_ebay_fb_Widget extends WP_Widget {

	
	function __construct() {
		parent::__construct(
			'wm_get_ebay_fb_widget_slider', // Base ID
			__('Get Your Ebay Feedback', 'text_domain'), // Name
			array( 'description' => __( 'Widget for Carousel Testimonial Slider', 'text_domain' ), ) // Args
		);
	}
	
	

	
	public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

$wm_get_ebay_fb_shortcode_option_transaction = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_transaction'] );
$wm_get_ebay_fb_shortcode_option_show_quote = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_show_quote'] );
$wm_get_ebay_fb_shortcode_option_show_author = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_show_author'] );
$wm_get_ebay_fb_shortcode_option_show_divider = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_show_divider'] );
$wm_get_ebay_fb_shortcode_option_show_text = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_show_text'] );
$wm_get_ebay_fb_shortcode_option_show_item = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_show_item'] );
$wm_get_ebay_fb_shortcode_option_show_date = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_show_date'] );
$wm_get_ebay_fb_shortcode_option_border_color = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_border_color'] );
$wm_get_ebay_fb_shortcode_option_border_px = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_border_px'] );
$wm_get_ebay_fb_shortcode_option_bg_color = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_bg_color'] );
$wm_get_ebay_fb_shortcode_option_quote_color = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_quote_color'] );
$wm_get_ebay_fb_shortcode_option_user = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_user'] );
$wm_get_ebay_fb_shortcode_option_text = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_text'] );
$wm_get_ebay_fb_shortcode_option_product = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_product'] );
$wm_get_ebay_fb_shortcode_option_date = apply_filters( 'widget_content', $instance['wm_get_ebay_fb_shortcode_option_date'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

               global $wpdb;
    $feedbacks = $wpdb->get_results("select * from ".$wpdb->prefix . "wm_get_ebay_fb_table"); 
               ?>

<div class="wm_get_ebay_fb_widget" style="background: <?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_bg_color']); ?>; border: <?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_border_px']); ?>px solid; border-color: <?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_border_color']); ?>">
    <?php foreach($feedbacks as $feedback) if($tmp++ < 5) { ?>
    <div>
        <?php if(checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_quote'],false)) { ?>
        <i class="fa fa-quote-right" style="color: <?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_quote_color']); ?>"></i>
        <?php } ?>
        <?php if(checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_author'],false)) { ?>
        <div class="commenting_user" style="color: <?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_user']); ?>"><i class="fa fa-user"></i><?php echo $feedback->CommentingUser; ?></div>
        <?php } ?>
        <?php if(checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_divider'],false)) { ?>
        <div><span class="wm_get_ebay_fb_separator"><i class="fa fa-ellipsis-h" style="color: <?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_quote_color']); ?>"></i></span></div>
        <?php } ?>
        <?php if(checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_text'],false)) { ?>
        <div class="commenting_text" style="color: <?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_text']); ?>"><?php echo base64_decode($feedback->CommentText); ?></div>
        <?php } ?>
        <?php if(checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_item'],false)) { ?>
        <div class="item_title" style="color: <?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_product']); ?>"><?php echo $feedback->ItemTitle; ?></div>
        <?php } ?>
       <?php if(checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_date'],false)) { ?>
        <div class="comment_time" style="color: <?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_date']); ?>"><i><?php echo date('d-m-Y H:i:s',strtotime($feedback->CommentTime)); ?></i></div>
        <?php } ?>
    </div>
    <?php } ?>
     
</div>

<?php 

if (esc_attr($instance['wm_get_ebay_fb_shortcode_option_transaction']=='slide')) { $fade =  "false"; $adaptiveHeight = "true"; } else { $fade = "true"; $adaptiveHeight = "false"; } 
?>
<script type="text/javascript">
    jQuery('.wm_get_ebay_fb_widget').slick({
         adaptiveHeight: <?php echo $adaptiveHeight; ?>,
         fade: <?php echo $fade; ?>,
            cssEase: 'linear',
            prevArrow: '<button type="button" data-role="none" class="fa fa-caret-square-o-left" style="display: block;color:<?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_quote_color']); ?>"></button>',
            nextArrow: '<button type="button" data-role="none" class="fa fa-caret-square-o-right" style="display: block;color:<?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_quote_color']); ?>"></button>'
        });
                </script>
<?php
                
		echo $args['after_widget'];
	}
	
	

	
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( ' Happy Customers ', 'text_domain' );
		}
		
		$instance = wp_parse_args( (array) $instance, array( 
		
                    'wm_get_ebay_fb_shortcode_option_transaction' => 'slide',
                    'wm_get_ebay_fb_shortcode_option_show_author' => 'on',
                    'wm_get_ebay_fb_shortcode_option_show_divider' => 'on',
                    'wm_get_ebay_fb_shortcode_option_show_quote' => 'on',
                    'wm_get_ebay_fb_shortcode_option_show_text' => 'on',
                    'wm_get_ebay_fb_shortcode_option_show_item' => 'on',
                    'wm_get_ebay_fb_shortcode_option_show_date' => 'on',
                    'wm_get_ebay_fb_shortcode_option_border_color' => '#ffffff',
                    'wm_get_ebay_fb_shortcode_option_border_px' => 0,
                    'wm_get_ebay_fb_shortcode_option_bg_color' => '#ffffff',
                    'wm_get_ebay_fb_shortcode_option_quote_color' => '#000000',
                    'wm_get_ebay_fb_shortcode_option_user' => '#000000',
                    'wm_get_ebay_fb_shortcode_option_text' => '#000000',
                    'wm_get_ebay_fb_shortcode_option_product' => '#000000',
                    'wm_get_ebay_fb_shortcode_option_date' => '#000000',
                    
                    
                    ) );
		
		?>

<div>       
    <div >   
        <br />
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</div>
    
    <div style="padding-top: 20px;">
        <strong class="description">TRANSACTION EFFECT: </strong><br /><br/>
     <input type="radio" id="<?php echo $this->get_field_id( 'wm_get_ebay_fb_shortcode_option_transaction'); ?>" name="<?php echo $this->get_field_name( 'wm_get_ebay_fb_shortcode_option_transaction'); ?>" value ="slide" <?php if(esc_attr($instance['wm_get_ebay_fb_shortcode_option_transaction']=='slide')) echo "checked";?> />
<label class="wm_get_ebay_fb_label" for="wm_get_ebay_fb_shortcode_option_transaction_slide">Slide</label>
<span class="description"> ( with adaptative height )</span>
<br />

<input type="radio" id="<?php echo $this->get_field_id( 'wm_get_ebay_fb_shortcode_option_transaction'); ?>" name="<?php echo $this->get_field_name( 'wm_get_ebay_fb_shortcode_option_transaction'); ?>" value ="fade" <?php if(esc_attr($instance['wm_get_ebay_fb_shortcode_option_transaction']=='fade')) echo "checked";?> />
<label class="wm_get_ebay_fb_label" for="wm_get_ebay_fb_shortcode_option_transaction_slide">Fade</label>
<span class="description"> ( without adaptative height )</span>
<br />

</div>
    <hr />
    <div style="padding-top: 20px;">
    <strong class="description">SHOW: </strong><br /><br />
    <input type="checkbox" id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_show_quote'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_show_quote'); ?>" <?php checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_quote']); ?> /> Quote Symbol<br />
<input type="checkbox" id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_show_author'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_show_author'); ?>" <?php checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_author']); ?> /> Author<br />
<input type="checkbox" id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_show_divider'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_show_divider'); ?>" <?php checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_divider']); ?> /> Divider <br />
<input type="checkbox" id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_show_text'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_show_text'); ?>" <?php checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_text']); ?> /> Comment Text<br />
<input type="checkbox" id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_show_item'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_show_item'); ?>" <?php checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_item']); ?> /> Item <span class="description">( if it's not private )</span><br />
<input type="checkbox" id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_show_date'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_show_date'); ?>" <?php checked('on',$instance['wm_get_ebay_fb_shortcode_option_show_date']); ?> /> Comment Date<br />
</div>
    <hr />
    <div style="padding-top: 20px;">
    <strong class="description">BORDER: </strong><br /><br />
    <input id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_border_px'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_border_px'); ?>" value="<?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_border_px']); ?>" type="number" style="width:45px;"> px  
<input id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_border_color'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_border_color'); ?>" value="<?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_border_color']); ?>" type="color"> Color<br />

</div><hr />
    
    <div style="padding-top: 20px;">
    <strong class="description">COLORS:</strong><br /><br />

<input id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_bg_color'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_bg_color'); ?>" value="<?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_bg_color']); ?>" type="color"> Background Color<br />
<input id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_quote_color'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_quote_color'); ?>" value="<?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_quote_color']); ?>" type="color"> Quote, divider and arrows<br />
<input id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_user'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_user'); ?>" value="<?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_user']); ?>" type="color"> User <br />
<input id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_text'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_text'); ?>" value="<?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_text']); ?>" type="color"> Comment Text<br />
<input id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_product'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_product'); ?>" value="<?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_product']); ?>" type="color"> Product<br />
<input id="<?php echo $this->get_field_id('wm_get_ebay_fb_shortcode_option_date'); ?>" name="<?php echo $this->get_field_name('wm_get_ebay_fb_shortcode_option_date'); ?>" value="<?php echo esc_attr($instance['wm_get_ebay_fb_shortcode_option_date']); ?>" type="color"> DateTime<br /><hr />
</div>
    
 	</div><br />
     

      
		<?php 
	}

	
	public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

$instance['wm_get_ebay_fb_shortcode_option_transaction'] = ( ! empty( $new_instance['wm_get_ebay_fb_shortcode_option_transaction'] ) ) ? strip_tags( $new_instance['wm_get_ebay_fb_shortcode_option_transaction'] ) : '';

$instance['wm_get_ebay_fb_shortcode_option_show_quote'] = strip_tags($new_instance['wm_get_ebay_fb_shortcode_option_show_quote']);
$instance['wm_get_ebay_fb_shortcode_option_show_author'] = strip_tags($new_instance['wm_get_ebay_fb_shortcode_option_show_author']);
$instance['wm_get_ebay_fb_shortcode_option_show_divider'] = strip_tags($new_instance['wm_get_ebay_fb_shortcode_option_show_divider']);
$instance['wm_get_ebay_fb_shortcode_option_show_text'] = strip_tags($new_instance['wm_get_ebay_fb_shortcode_option_show_text']);
$instance['wm_get_ebay_fb_shortcode_option_show_item'] = strip_tags($new_instance['wm_get_ebay_fb_shortcode_option_show_item']);
$instance['wm_get_ebay_fb_shortcode_option_show_date'] = strip_tags($new_instance['wm_get_ebay_fb_shortcode_option_show_date']);

$instance['wm_get_ebay_fb_shortcode_option_border_px'] = ( ! empty( $new_instance['wm_get_ebay_fb_shortcode_option_border_px'] ) ) ? strip_tags( $new_instance['wm_get_ebay_fb_shortcode_option_border_px'] ) : '';

$instance['wm_get_ebay_fb_shortcode_option_border_color'] = ( ! empty( $new_instance['wm_get_ebay_fb_shortcode_option_border_color'] ) ) ? strip_tags( $new_instance['wm_get_ebay_fb_shortcode_option_border_color'] ) : '';

$instance['wm_get_ebay_fb_shortcode_option_bg_color'] = ( ! empty( $new_instance['wm_get_ebay_fb_shortcode_option_bg_color'] ) ) ? strip_tags( $new_instance['wm_get_ebay_fb_shortcode_option_bg_color'] ) : '';

$instance['wm_get_ebay_fb_shortcode_option_quote_color'] = ( ! empty( $new_instance['wm_get_ebay_fb_shortcode_option_quote_color'] ) ) ? strip_tags( $new_instance['wm_get_ebay_fb_shortcode_option_quote_color'] ) : '';

$instance['wm_get_ebay_fb_shortcode_option_user'] = ( ! empty( $new_instance['wm_get_ebay_fb_shortcode_option_user'] ) ) ? strip_tags( $new_instance['wm_get_ebay_fb_shortcode_option_user'] ) : '';

$instance['wm_get_ebay_fb_shortcode_option_text'] = ( ! empty( $new_instance['wm_get_ebay_fb_shortcode_option_text'] ) ) ? strip_tags( $new_instance['wm_get_ebay_fb_shortcode_option_text'] ) : '';

$instance['wm_get_ebay_fb_shortcode_option_product'] = ( ! empty( $new_instance['wm_get_ebay_fb_shortcode_option_product'] ) ) ? strip_tags( $new_instance['wm_get_ebay_fb_shortcode_option_product'] ) : '';

$instance['wm_get_ebay_fb_shortcode_option_date'] = ( ! empty( $new_instance['wm_get_ebay_fb_shortcode_option_date'] ) ) ? strip_tags( $new_instance['wm_get_ebay_fb_shortcode_option_date'] ) : '';


return $instance;
	}

} 

function register_WM_get_ebay_fb_Widget() {
    register_widget( 'WM_get_ebay_fb_Widget' );
}
add_action( 'widgets_init', 'register_WM_get_ebay_fb_Widget' );



?>