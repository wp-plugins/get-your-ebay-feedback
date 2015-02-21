<?php


add_action( 'admin_footer', 'firts_get_feedback');

function firts_get_feedback(){
    ?>
<script type="text/javascript">
jQuery(document).on("click","#first_get_feedback", function() {
	
        var data = {
		action: 'firts_get_feedback_ajax',
	};
	

	jQuery.post(ajaxurl, data, function(response) {
            location.reload();
    });
        
        
      
	return false;	
	});
</script>
<?php
}

add_action( 'wp_ajax_firts_get_feedback_ajax', 'firts_get_feedback_ajax_callback' );

function firts_get_feedback_ajax_callback() {
	    global $wpdb;
        include(plugin_dir_path(__FILE__).'eBaySession.php');
        include(plugin_dir_path(__FILE__).'keys.php');
        
        $user = get_option('wm_get_ebay_fb_user');        
        $verb = 'GetFeedback';      
        $siteID = $user['country'];

        
$requestXmlBody ='<?xml version="1.0" encoding="utf-8"?>
<GetFeedbackRequest xmlns="urn:ebay:apis:eBLBaseComponents">
<RequesterCredentials>
<eBayAuthToken>'.$user['token'].'</eBayAuthToken>
</RequesterCredentials>
<UserID>'.$user['UserID'].'</UserID>
<FeedbackType>FeedbackReceived</FeedbackType>
<DetailLevel>ReturnAll</DetailLevel>
<Version>903</Version>
</GetFeedbackRequest>​';


$session = new eBaySession($user['token'], $user['devid'], $user['appid'], $user['certid'], $serverUrl, $compatabilityLevel, $user['country'], $verb);

$responseXml = $session->sendHttpRequest($requestXmlBody);
    if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
        die('Error sending request');
    
    
$responseDoc = new DomDocument();
$responseDoc->loadXML($responseXml);
    
$errors = $responseDoc->getElementsByTagName('Errors');

if($errors->length > 0)
    {
        echo '<P><B>eBay returned the following error(s):</B>';
        //display each error
        //Get error code, ShortMesaage and LongMessage
        $code = $errors->item(0)->getElementsByTagName('ErrorCode');
        $shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
        $longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
        //Display code and shortmessage
        echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
        //if there is a long message (ie ErrorLevel=1), display it
        if(count($longMsg) > 0)
            echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));

    }
    else //no errors
    {
      
        $feedbacks = $responseDoc->getElementsByTagName('FeedbackDetailArray');
        
        foreach($feedbacks as $node){
            foreach($node->childNodes as $child) {
                $CommentingUser = $child->getElementsByTagName('CommentingUser');
                $FeedbackID = $child->getElementsByTagName('FeedbackID');
                $CommentingUserScore = $child->getElementsByTagName('CommentingUserScore');
                $CommentText = $child->getElementsByTagName('CommentText');
                $CommentTime = $child->getElementsByTagName('CommentTime');
                $ItemID = $child->getElementsByTagName('ItemID');
                $TransactionID = $child->getElementsByTagName('TransactionID');
                $OrderLineItemID = $child->getElementsByTagName('OrderLineItemID');
                $ItemTitle = $child->getElementsByTagName('ItemTitle');
                $ItemPrice = $child->getElementsByTagName('ItemPrice');
                
                
                $wpdb->query("INSERT INTO ".$wpdb->prefix . "wm_get_ebay_fb_table VALUES (NULL, '".$CommentingUser->item(0)->nodeValue."', '".$CommentingUserScore->item(0)->nodeValue."','".base64_encode($CommentText->item(0)->nodeValue)."','".$CommentTime->item(0)->nodeValue."','','".$ItemID->item(0)->nodeValue."',".$FeedbackID->item(0)->nodeValue.",'".$TransactionID->item(0)->nodeValue."','".$OrderLineItemID->item(0)->nodeValue."','".$ItemTitle->item(0)->nodeValue."','".$ItemPrice->item(0)->nodeValue."') 
ON DUPLICATE KEY
UPDATE CommentText = '".$CommentText->item(0)->nodeValue."', CommentTime = '".$CommentTime->item(0)->nodeValue."', CommentType='';");
                
$wpdb->query("DELETE FROM ".$wpdb->prefix . "wm_get_ebay_fb_table
WHERE id NOT IN (
  SELECT id
  FROM (
    SELECT id
    FROM ".$wpdb->prefix . "wm_get_ebay_fb_table
    ORDER BY CommentTime DESC
    LIMIT 5
  ) foo
)");
                
                
                 
                
            }
        }
        
        $userid = $responseDoc->getElementsByTagName('Ack');
        
      
        
    }

   

	die();
}


add_action('admin_footer','changing_color');

function changing_color(){ ?>
<script type="text/javascript">
jQuery('#wm_get_ebay_fb_shortcode_option_bg_color').on('input', function() { 
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode').css('background',jQuery('#wm_get_ebay_fb_shortcode_option_bg_color').val());
});   
jQuery('#wm_get_ebay_fb_shortcode_option_quote_color').on('input', function() { 
    jQuery('.wp-admin .fa-quote-right').css('color',jQuery('#wm_get_ebay_fb_shortcode_option_quote_color').val());
    jQuery('.wp-admin .fa-ellipsis-h').css('color',jQuery('#wm_get_ebay_fb_shortcode_option_quote_color').val());
    jQuery('.wp-admin button').css('color',jQuery('#wm_get_ebay_fb_shortcode_option_quote_color').val());
}); 
jQuery('#wm_get_ebay_fb_shortcode_option_user').on('input', function() { 
    jQuery('.wp-admin .commenting_user').css('color',jQuery('#wm_get_ebay_fb_shortcode_option_user').val());
});
jQuery('#wm_get_ebay_fb_shortcode_option_text').on('input', function() { 
    jQuery('.wp-admin .commenting_text').css('color',jQuery('#wm_get_ebay_fb_shortcode_option_text').val());
});
jQuery('#wm_get_ebay_fb_shortcode_option_product').on('input', function() { 
    jQuery('.wp-admin .item_title').css('color',jQuery('#wm_get_ebay_fb_shortcode_option_product').val());
});
jQuery('#wm_get_ebay_fb_shortcode_option_date').on('input', function() { 
    jQuery('.wp-admin .comment_time').css('color',jQuery('#wm_get_ebay_fb_shortcode_option_date').val());
});
jQuery('#wm_get_ebay_fb_shortcode_option_border_px').on('input', function() { 
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode').css('border',jQuery('#wm_get_ebay_fb_shortcode_option_border_px').val()+'px solid').css('border-color',jQuery('#wm_get_ebay_fb_shortcode_option_border_color').val());
});
jQuery('#wm_get_ebay_fb_shortcode_option_border_color').on('input', function() { 
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode').css('border-color',jQuery('#wm_get_ebay_fb_shortcode_option_border_color').val());
});
jQuery('#wm_get_ebay_fb_shortcode_option_show_quote').on('change', function() { 
    if (jQuery(this).attr("checked")) {
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .fa-quote-right').show();
    }else{
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .fa-quote-right').hide();    
    }
});
jQuery('#wm_get_ebay_fb_shortcode_option_show_author').on('change', function() { 
    if (jQuery(this).attr("checked")) {
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .commenting_user').show();
    }else{
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .commenting_user').hide();    
    }
});
jQuery('#wm_get_ebay_fb_shortcode_option_show_divider').on('change', function() { 
    if (jQuery(this).attr("checked")) {
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .wm_get_ebay_fb_separator').show();
    }else{
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .wm_get_ebay_fb_separator').hide();    
    }
});
jQuery('#wm_get_ebay_fb_shortcode_option_show_text').on('change', function() { 
    if (jQuery(this).attr("checked")) {
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .commenting_text').show();
    }else{
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .commenting_text').hide();    
    }
});
jQuery('#wm_get_ebay_fb_shortcode_option_show_item').on('change', function() { 
    if (jQuery(this).attr("checked")) {
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .item_title').show();
    }else{
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .item_title').hide();    
    }
});
jQuery('#wm_get_ebay_fb_shortcode_option_show_date').on('change', function() { 
    if (jQuery(this).attr("checked")) {
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .comment_time').show();
    }else{
    jQuery('.wp-admin .wm_get_ebay_fb_shortcode .comment_time').hide();    
    }
});

</script>


<?php } 






add_action( 'admin_footer', 'unlink_user_function');

function unlink_user_function(){
    ?>
<script type="text/javascript">
jQuery(document).on("click","#unlink_user", function() {
	var check_confirm = confirm("Are you sure ?");
        if(check_confirm == true){
        var data = {
		action: 'unlink_user_function_ajax',
	};
	

	jQuery.post(ajaxurl, data, function(response) {
            console.log(response);
      location.href= '<?php echo admin_url('options-general.php?page=wm_get_your_ebay_feedback_plugin_options&tab=wm_get_your_ebay_feedback_general_settings'); ?>'     
    });
        
        
        }
	return false;	
	});
</script>
<?php
}

add_action( 'wp_ajax_unlink_user_function_ajax', 'unlink_user_function_ajax_callback' );

function unlink_user_function_ajax_callback() {
	global $wpdb; 
        
       delete_option('wm_get_ebay_fb_user');
       
       $wpdb->query("DELETE FROM ".$wpdb->prefix . "wm_get_ebay_fb_table");
      

	die();
}



add_action( 'admin_footer', 'update_feedback');

function update_feedback(){
    ?>
<script type="text/javascript">
jQuery(document).on("click","#id_update_feedback", function() {
	
        
        var data = {
		action: 'update_feedback_ajax'
	};
	

	jQuery.post(ajaxurl, data, function(response) {
        location.href= '<?php echo admin_url('options-general.php?page=wm_get_your_ebay_feedback_plugin_options&tab=wm_get_your_ebay_feedback_general_settings'); ?>'

    });
        
        
        
	return false;	
	});
</script>
<?php
}

add_action( 'wp_ajax_update_feedback_ajax', 'update_feedback_ajax_callback' );

function update_feedback_ajax_callback() {

    global $wpdb;
    include(plugin_dir_path(__FILE__).'eBaySession.php');
    include(plugin_dir_path(__FILE__).'keys.php');

    $user = get_option('wm_get_ebay_fb_user');
    $verb = 'GetFeedback';
    $siteID = $user['country'];


    $requestXmlBody ='<?xml version="1.0" encoding="utf-8"?>
<GetFeedbackRequest xmlns="urn:ebay:apis:eBLBaseComponents">
<RequesterCredentials>
<eBayAuthToken>'.$user['token'].'</eBayAuthToken>
</RequesterCredentials>
<UserID>'.$user['UserID'].'</UserID>
<FeedbackType>FeedbackReceived</FeedbackType>
<DetailLevel>ReturnAll</DetailLevel>
<Version>903</Version>
</GetFeedbackRequest>​';


    $session = new eBaySession($user['token'], $user['devid'], $user['appid'], $user['certid'], $serverUrl, $compatabilityLevel, $user['country'], $verb);

    $responseXml = $session->sendHttpRequest($requestXmlBody);
    if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
        die('Error sending request');


    $responseDoc = new DomDocument();
    $responseDoc->loadXML($responseXml);

    $errors = $responseDoc->getElementsByTagName('Errors');

    if($errors->length > 0)
    {
        echo '<P><B>eBay returned the following error(s):</B>';
        //display each error
        //Get error code, ShortMesaage and LongMessage
        $code = $errors->item(0)->getElementsByTagName('ErrorCode');
        $shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
        $longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
        //Display code and shortmessage
        echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
        //if there is a long message (ie ErrorLevel=1), display it
        if(count($longMsg) > 0)
            echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));

    }
    else //no errors
    {

        $feedbacks = $responseDoc->getElementsByTagName('FeedbackDetailArray');
        $wpdb->query("DELETE FROM ".$wpdb->prefix . "wm_get_ebay_fb_table");
        foreach($feedbacks as $node){
            foreach($node->childNodes as $child) {
                $CommentingUser = $child->getElementsByTagName('CommentingUser');
                $FeedbackID = $child->getElementsByTagName('FeedbackID');
                $CommentingUserScore = $child->getElementsByTagName('CommentingUserScore');
                $CommentText = $child->getElementsByTagName('CommentText');
                $CommentTime = $child->getElementsByTagName('CommentTime');
                $ItemID = $child->getElementsByTagName('ItemID');
                $TransactionID = $child->getElementsByTagName('TransactionID');
                $OrderLineItemID = $child->getElementsByTagName('OrderLineItemID');
                $ItemTitle = $child->getElementsByTagName('ItemTitle');
                $ItemPrice = $child->getElementsByTagName('ItemPrice');



                $wpdb->query("INSERT INTO ".$wpdb->prefix . "wm_get_ebay_fb_table VALUES (NULL, '".$CommentingUser->item(0)->nodeValue."', '".$CommentingUserScore->item(0)->nodeValue."','".base64_encode($CommentText->item(0)->nodeValue)."','".$CommentTime->item(0)->nodeValue."','','".$ItemID->item(0)->nodeValue."',".$FeedbackID->item(0)->nodeValue.",'".$TransactionID->item(0)->nodeValue."','".$OrderLineItemID->item(0)->nodeValue."','".$ItemTitle->item(0)->nodeValue."','".$ItemPrice->item(0)->nodeValue."')
ON DUPLICATE KEY
UPDATE CommentText = '".$CommentText->item(0)->nodeValue."', CommentTime = '".$CommentTime->item(0)->nodeValue."', CommentType='';");

                $wpdb->query("DELETE FROM ".$wpdb->prefix . "wm_get_ebay_fb_table
WHERE id NOT IN (
  SELECT id
  FROM (
    SELECT id
    FROM ".$wpdb->prefix . "wm_get_ebay_fb_table
    ORDER BY CommentTime DESC
    LIMIT 5
  ) foo
)");




            }
        }

        $userid = $responseDoc->getElementsByTagName('Ack');



    }


    // update user



    $verb = 'GetUser';

    $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
<GetUserRequest xmlns="urn:ebay:apis:eBLBaseComponents">
<RequesterCredentials>
<eBayAuthToken>'.$user['token'].'</eBayAuthToken>
</RequesterCredentials>
</GetUserRequest>​';

    $session = new eBaySession($user['token'], $user['devid'], $user['appid'], $user['certid'], $serverUrl, $compatabilityLevel, $user['country'], $verb);

    $responseXml = $session->sendHttpRequest($requestXmlBody);
    if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
        die('<P>Error sending request');


    $responseDoc = new DomDocument();
    $responseDoc->loadXML($responseXml);

    $errors = $responseDoc->getElementsByTagName('Errors');


    if($errors->length > 0)
    {
        echo '<P><B>eBay returned the following error(s):</B>';
        //display each error
        //Get error code, ShortMesaage and LongMessage
        $code = $errors->item(0)->getElementsByTagName('ErrorCode');
        $shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
        $longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
        //Display code and shortmessage
        echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
        //if there is a long message (ie ErrorLevel=1), display it
        if(count($longMsg) > 0)
            echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));

    }
    else //no errors
    {
        //get the node containing the time and display its contents
        $userid = $responseDoc->getElementsByTagName('UserID');
        $email = $responseDoc->getElementsByTagName('Email');
        $feedback = $responseDoc->getElementsByTagName('FeedbackScore');
        $feedbacknegative = $responseDoc->getElementsByTagName('UniqueNegativeFeedbackCount');
        $feedbackpositive = $responseDoc->getElementsByTagName('UniquePositiveFeedbackCount');
        $feedbackpercent = $responseDoc->getElementsByTagName('PositiveFeedbackPercent');
        $feedbackprivate = $responseDoc->getElementsByTagName('FeedbackPrivate');
        $feedbackrating = $responseDoc->getElementsByTagName('FeedbackRatingStar');
        $idverified = $responseDoc->getElementsByTagName('IDVerified');
        $sellerguaranted = $responseDoc->getElementsByTagName('SellerGuaranteeLevel');
        $storeowner = $responseDoc->getElementsByTagName('StoreOwner');
        $transactionpercetn = $responseDoc->getElementsByTagName('TransactionPercent');
        $motorsdealer = $responseDoc->getElementsByTagName('MotorsDealer');
        $uniqueneutralfeedbackcount = $responseDoc->getElementsByTagName('UniqueNeutralFeedbackCount');
        $enterpriseseller = $responseDoc->getElementsByTagName('EnterpriseSeller');



        $user['UserID'] = $userid->item(0)->nodeValue;
        $user['Email'] = $email->item(0)->nodeValue;
        $user['FeedbackScore'] = $feedback->item(0)->nodeValue;
        $user['UniqueNegativeFeedbackCount'] = $feedbacknegative->item(0)->nodeValue;
        $user['UniquePositiveFeedbackCount'] = $feedbackpositive->item(0)->nodeValue;
        $user['PositiveFeedbackPercent'] = $feedbackpercent->item(0)->nodeValue;
        $user['FeedbackPrivate'] = $feedbackprivate->item(0)->nodeValue;
        $user['FeedbackRatingStar'] = $feedbackrating->item(0)->nodeValue;
        $user['IDVerified'] = $idverified->item(0)->nodeValue;
        $user['SellerGuaranteeLevel'] = $sellerguaranted->item(0)->nodeValue;
        $user['StoreOwner'] = $storeowner->item(0)->nodeValue;
        $user['TransactionPercent'] = $transactionpercetn->item(0)->nodeValue;
        $user['MotorsDealer'] = $motorsdealer->item(0)->nodeValue;
        $user['UniqueNeutralFeedbackCount'] = $uniqueneutralfeedbackcount->item(0)->nodeValue;
        $user['EnterpriseSeller'] = $enterpriseseller->item(0)->nodeValue;



        update_option('wm_get_ebay_fb_user',$user);

        ?>

    <?php

    }



    die();
}



?>