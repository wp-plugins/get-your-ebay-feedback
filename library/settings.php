<?php

include(plugin_dir_path(__FILE__).'eBaySession.php');
include(plugin_dir_path(__FILE__).'keys.php');
global $wpdb; 

$user = get_option('wm_get_ebay_fb_user');

//echo '<pre>'; print_r($user); echo '</pre>';
//echo 'SiteID: '.$user['country'].'<br />';

$siteID = $user['country'];

if(!array_key_exists('UserID',$user)){

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
?>
<?php
define('DAY',60*60*24, true);
define('MONTH',DAY*30, true);
define('YEAR',DAY*365, true); 

$diff = abs(strtotime($user['token_exp']) - time());
?>

<div class="ebay_user">
    <h2><i class="fa fa-user"></i> <span class="username"><?php echo $user['UserID']; ?></span></h2>
    <h3><span class="email"> <?php echo $user['Email']; ?></span></h3>
    <div class="fb_ebay_user">
        <div class="total_fb_percent">
            <div class="total_fb"><i class="fa fa-star"></i> Total FeedBack - <b><?php echo $user['FeedbackScore']; ?> ( <?php echo $user['PositiveFeedbackPercent']; ?>% )</b></div>
            
        </div>    
        
        <div class="user_score">
        <div class="single_fb_ebay_user"><span class="icona_score"><i class="fa fa-plus-circle" style="color:#36B712;"></i></span><span class="single_fb_ebay_user_score"><?php echo $user['UniquePositiveFeedbackCount']; ?></span></div>
        
        <div class="single_fb_ebay_user"><span class="icona_score"><i class="fa fa-dot-circle-o" style="color: #666666;"></i></span><span class="single_fb_ebay_user_score"><?php echo $user['UniqueNeutralFeedbackCount']; ?></span></div>
        
        <div class="single_fb_ebay_user" style="border-right: none;"><span class="icona_score"><i class="fa fa-minus-circle" style="color: #FF0000;"></i></span><span class="single_fb_ebay_user_score"><?php echo $user['UniqueNegativeFeedbackCount']; ?></span></div>
    
         <span class="description">Unique Feedbacks in last 12 months</span>
        </div>
    
    
   
    
    <div class="div_token_exp">
    Your Token expires <?php echo $user['token_exp']; ?>, remaining  <?php echo (int)($diff/(60*60*24)); ?> days
</div>

    
</div>  
</div>
<?php
if(count($wpdb->get_results("select * from ".$wpdb->prefix . "wm_get_ebay_fb_table")) == 0){
    ?>
    <a href="#" id="first_get_feedback" class="button-primary"><i class="fa fa-bolt"></i> Start Getting FeedBack ( First Time )</a>
<?php
}else{ ?>
<a href="#" id="unlink_user" class="button-primary" style='background: #CB0404;border-color: #900'><i class="fa fa-times"></i> Unlink user and reset my feedbacks</a>
<a href="#" class="button-primary" id="id_update_feedback"><i class="fa fa-refresh"></i> Update  User's Data and Feedback</a>



<?php 
}?>
<div id="wm_get_ebay_fb_div_loading" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Loading.. </div>