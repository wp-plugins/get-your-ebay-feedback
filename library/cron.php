<?php

register_activation_hook(__FILE__, 'wm_get_ebay_fb_cron');
add_action( 'wm_get_ebay_fb_cron_execute', 'wm_get_ebay_fb_cron_execute_scheduled' );


function wm_get_ebay_fb_cron() {
     wp_schedule_event( current_time( 'timestamp' ), 'daily', 'wm_get_ebay_fb_cron_execute' );
}


// Scheduled Action Hook
function wm_get_ebay_fb_cron_execute_scheduled(  ) {
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


}
// Schedule Cron Job Event





?>