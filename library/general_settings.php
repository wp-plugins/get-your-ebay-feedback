<form method="post" action="options.php" novalidate>
<?php settings_fields('wm_get_ebay_fb_general_option'); ?>



<div style="margin-top: 20px;padding: 20px;border: 1px solid #DDDDDD;">
    <h2>SHORTCODE SETTINGS</h2>
    Shortcode to use:   <strong style="color:#900;">[wm_getebayfb]</strong>
    <hr />
<p>
    
<strong class="description">TRANSACTION EFFECT:</strong><br /><br />
<input type="radio" id="wm_get_ebay_fb_shortcode_option_transaction_slide" name="wm_get_ebay_fb_shortcode_option[transaction]" value ="slide" <?php if (get_option('wm_get_ebay_fb_shortcode_option')['transaction']=='slide') echo "checked";?>/>
<label class="wm_get_ebay_fb_label" for="wm_get_ebay_fb_shortcode_option_transaction_slide">Slide</label>
<span class="description"> ( with adaptative height )</span>
<br />

<input type="radio" id="wm_get_ebay_fb_shortcode_option_transaction_fade" name="wm_get_ebay_fb_shortcode_option[transaction]" value ="fade" <?php if (get_option('wm_get_ebay_fb_shortcode_option')['transaction']=='fade') echo "checked";?>/> 
<label class="wm_get_ebay_fb_label" for="wm_get_ebay_fb_shortcode_option_transaction_fade">Fade</label>
<span class="description"> ( without adaptative height )</span>
<br /><br />
<span class="description">Choose wich effect you wanna use in your shortcode view</span></p>
<hr />
<table style="width:100%;"><tbody><tr>
            <td style="width:40%;">
<p>

<strong class="description">SHOW:</strong><br />
<input type="checkbox" id="wm_get_ebay_fb_shortcode_option_show_quote" name="wm_get_ebay_fb_shortcode_option[show_quote]" value="true" <?php if(array_key_exists('show_quote', get_option('wm_get_ebay_fb_shortcode_option'))) { echo 'checked'; } ?>/> Quote Symbol<br />   
<input type="checkbox" id="wm_get_ebay_fb_shortcode_option_show_author" name="wm_get_ebay_fb_shortcode_option[show_author]" value="true" <?php if(array_key_exists('show_author', get_option('wm_get_ebay_fb_shortcode_option'))) { echo 'checked'; } ?>/> Comment Author<br />
<input type="checkbox" id="wm_get_ebay_fb_shortcode_option_show_divider" name="wm_get_ebay_fb_shortcode_option[show_divider]" value="true" <?php if(array_key_exists('show_divider', get_option('wm_get_ebay_fb_shortcode_option'))) { echo 'checked'; } ?>/> Divider Symbol<br />
<input type="checkbox" id="wm_get_ebay_fb_shortcode_option_show_text" name="wm_get_ebay_fb_shortcode_option[show_text]" value="true" <?php if(array_key_exists('show_text', get_option('wm_get_ebay_fb_shortcode_option'))) { echo 'checked'; } ?>/> Comment Text<br />
<input type="checkbox" id="wm_get_ebay_fb_shortcode_option_show_item" name="wm_get_ebay_fb_shortcode_option[show_item]" value="true" <?php if(array_key_exists('show_item', get_option('wm_get_ebay_fb_shortcode_option'))) { echo 'checked'; } ?>/> Item <span class="description">( if it's not private )</span><br />
<input type="checkbox" id="wm_get_ebay_fb_shortcode_option_show_date" name="wm_get_ebay_fb_shortcode_option[show_date]" value="true" <?php if(array_key_exists('show_date', get_option('wm_get_ebay_fb_shortcode_option'))) { echo 'checked'; } ?>/> Comment Date<br />
<br />

<strong class="description">BORDER:</strong><br />   
<input id="wm_get_ebay_fb_shortcode_option_border_px" name="wm_get_ebay_fb_shortcode_option[border_px]" value="<?php echo get_option('wm_get_ebay_fb_shortcode_option')['border_px']; ?>" type="number" style="width:45px;"> px  
<input id="wm_get_ebay_fb_shortcode_option_border_color" name="wm_get_ebay_fb_shortcode_option[border_color]" value="<?php echo get_option('wm_get_ebay_fb_shortcode_option')['border_color']; ?>" type="color"> Color<br /><br />
<strong class="description">COLORS:</strong><br />

<input id="wm_get_ebay_fb_shortcode_option_bg_color" name="wm_get_ebay_fb_shortcode_option[bg_color]" value="<?php echo get_option('wm_get_ebay_fb_shortcode_option')['bg_color']; ?>" type="color"> Background Color<br />
<input id="wm_get_ebay_fb_shortcode_option_quote_color" name="wm_get_ebay_fb_shortcode_option[quote_color]" value="<?php echo get_option('wm_get_ebay_fb_shortcode_option')['quote_color']; ?>" type="color"> Quote, divider and arrows<br />
<input id="wm_get_ebay_fb_shortcode_option_user" name="wm_get_ebay_fb_shortcode_option[user]" value="<?php echo get_option('wm_get_ebay_fb_shortcode_option')['user']; ?>" type="color"> User<br /> 
<input id="wm_get_ebay_fb_shortcode_option_text" name="wm_get_ebay_fb_shortcode_option[text]" value="<?php echo get_option('wm_get_ebay_fb_shortcode_option')['text']; ?>" type="color"> Comment Text<br />
<input id="wm_get_ebay_fb_shortcode_option_product" name="wm_get_ebay_fb_shortcode_option[product]" value="<?php echo get_option('wm_get_ebay_fb_shortcode_option')['product']; ?>" type="color"> Product<br />
<input id="wm_get_ebay_fb_shortcode_option_date" name="wm_get_ebay_fb_shortcode_option[date]" value="<?php echo get_option('wm_get_ebay_fb_shortcode_option')['date']; ?>" type="color"> DateTime<br />    


</p>
            </td>
            
            <td>
<div class="wm_get_ebay_fb_shortcode" style="background: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['bg_color']; ?>; border: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['border_px']; ?>px solid; border-color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['border_color']; ?>">
<div>
        
        <i class="fa fa-quote-right" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['quote_color']; ?>;<?php if(array_key_exists('show_quote', get_option('wm_get_ebay_fb_shortcode_option'))) { ?> display: block;<?php }else{?> display:none;<?php } ?>"></i>
        
        
        <div class="commenting_user" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['user']; ?>;<?php if(array_key_exists('show_author', get_option('wm_get_ebay_fb_shortcode_option'))) { ?> display: block;<?php }else{?> display:none;<?php } ?>"><i class="fa fa-user"></i>username</div>
        
        <div><span class="wm_get_ebay_fb_separator"><i class="fa fa-ellipsis-h" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['quote_color']; ?>;<?php if(array_key_exists('show_divider', get_option('wm_get_ebay_fb_shortcode_option'))) { ?> display: block;<?php }else{?> display:none;<?php } ?>"></i></span></div>
       
        <div class="commenting_text" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['text']; ?>;<?php if(array_key_exists('show_text', get_option('wm_get_ebay_fb_shortcode_option'))) { ?> display: block;<?php }else{?> display:none;<?php } ?>">Great Seller, everything fine. </div>
       
        <div class="item_title" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['product']; ?>;<?php if(array_key_exists('show_item', get_option('wm_get_ebay_fb_shortcode_option'))) { ?> display: block;<?php }else{?> display:none;<?php } ?>">Apple Iphone 6 Plus 64 GB</div>
        
        <div class="comment_time" style="color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['date']; ?>;<?php if(array_key_exists('show_date', get_option('wm_get_ebay_fb_shortcode_option'))) { ?> display: block;<?php }else{?> display:none;<?php } ?>"><i><?php echo date('d-m-Y H:i:s',time()); ?></i></div>
       
    </div>
    <button type="button" data-role="none" class="fa fa-caret-square-o-left" style="display: block; color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['quote_color']; ?>;"></button>
    <button type="button" data-role="none" class="fa fa-caret-square-o-right" style="display: block; color: <?php echo get_option('wm_get_ebay_fb_shortcode_option')['quote_color']; ?>;"></button>
</div>

</td></tr></tbody></table>


</div>  
   
    
                                <p>
                                By clicking this button , your setting will be saved !</p><p>
<input type="submit" class="button-primary" id="button_general_setting" name="button_general_setting" value="Save" />
                                </p>
                          
        </form>
        
        
     
        
 
  