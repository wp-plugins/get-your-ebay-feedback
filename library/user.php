<div style="padding: 20px;">
<h2>USE GET YOUR EBAY FEEDBACK IS VERY SIMPLE</h2>
<h3>Registration</h3>
<p>
Go to:<br />
<a href="https://go.developer.ebay.com/" target="_blank">Ebay Developer</a> and click on <a href="https://developer.ebay.com/join/" target="_blank">Sign in/Join</a>
</p>

<p>
	Fill the form in all its parts to create a user developer.<br />
	Check your email and confirm your registrationa<br />
	Now your account is activated.<br />
	</p>
<h3>Generate yours Application Keys</h3>
<p>
	Click on <strong>Get your application keys</strong><br />
	Click on <strong>Generate Production Keys</strong> and select <strong>Key Set 1</strong><br />
<h3>Generate Access Token</h3>
	<ul>
	<li>Click on <strong>Get a User Token</strong></li>
	<li>In <strong>Select the environment</strong> choose <strong>Production</strong></li>
	<li>In <strong>Select a key set or enter one manually</strong> choose <strong>Key Set 1</strong></li>
	<li>Click on <strong>Continue to generate token</strong></li>
	<li>At this point, you must login on Ebay with your Ebay's credentials</li>
	</ul>
<h3>FInal Step</h3>
<p>
	Please, copy and past all credentials in the form below, select your Country and click on <strong>Link Ebay User / Application</strong>
</p>


</p>


<p style="font-size:14px;">Thank you for using <strong>Get you ebay feedbacks - Powered by <a href="http://www.wemiura.com" target="_blank">WeMiura</a></strong></p>





    <form method="post" action="options.php" novalidate>
<?php settings_fields('wm_get_ebay_fb_user_option'); ?>



<div style="padding: 20px;
border: 1px solid #DDDDDD;"
>
Insert your <u>Client ID</u> and your <u>Client Secret</u>
<p>

<label class="wm_get_ebay_fb_label" for="wm_get_ebay_fb_devid">
<strong>DEVID:</strong></label>
<input type="text" id="wm_get_ebay_fb_user" value="<?php echo get_option('wm_get_ebay_fb_user')['devid']; ?>" name="wm_get_ebay_fb_user[devid]" />
<span class="description">Your DEVID:</span></p>
<p>     
<label class="wm_get_ebay_fb_label" for="wm_get_ebay_fb_appid"><strong>AppID: </strong></label>
<input type="text" id="wm_get_ebay_fb_user" value="<?php echo get_option('wm_get_ebay_fb_user')['appid']; ?>" name="wm_get_ebay_fb_user[appid]" />
<span class="description">Your AppID  </span>
</p>
<p>     
<label class="wm_get_ebay_fb_label" for="wm_get_ebay_fb_certid"><strong>CertID: </strong></label>
<input type="text" id="wm_get_ebay_fb_user" value="<?php echo get_option('wm_get_ebay_fb_user')['certid']; ?>" name="wm_get_ebay_fb_user[certid]" />
<span class="description">Your CertID  </span>
</p>
<p>     
<label class="wm_get_ebay_fb_label" for="wm_get_ebay_fb_token"><strong>Token: </strong></label>
<input type="text" id="wm_get_ebay_fb_token" value="<?php echo get_option('wm_get_ebay_fb_user')['token']; ?>" name="wm_get_ebay_fb_user[token]" />
<span class="description">Your Token  </span>
</p>
<p>     
<label class="wm_get_ebay_fb_label" for="wm_get_ebay_fb_token_exp"><strong style="color:red;">Token Expiration Date: </strong></label>
<input type="text" id="wm_get_ebay_fb_token_exp" value="<?php echo get_option('wm_get_ebay_fb_user')['token_exp']; ?>" name="wm_get_ebay_fb_user[token_exp]" />
<span class="description">Your Token  </span>
</p>
<p>     
<label class="wm_get_ebay_fb_label" for="wm_get_ebay_fb_country"><strong>Country: </strong></label>
<select name="wm_get_ebay_fb_user[country]" id="wm_get_ebay_fb_country">
	<option value="0">United States</option>
	<option value="100">eBay Motors</option>
	<option value="101">Italy</option>
	<option value="123">Belgium (Dutch)</option>
	<option value="146">Netherlands</option>
	<option value="15">Australia</option>
	<option value="16">Austria</option>
	<option value="186">Spain</option>
	<option value="193">Switzerland</option>
	<option value="196">Taiwan</option>
	<option value="2">Canada</option>
	<option value="201">Hong Kong</option>
	<option value="203">India</option>
	<option value="205">Ireland</option>
	<option value="207">Malaysia</option>
	<option value="210">Canada (French)</option>
	<option value="211">Philippines</option>
	<option value="212">Poland</option>
	<option value="216">Singapore</option>
	<option value="218">Sweden</option>
	<option value="223">China</option>
	<option value="23">Belgium (French)</option>
	<option value="3">UK</option>
	<option value="71">France</option>
	<option value="77">Germany</option>

</select>
<span class="description">Your Country  </span>
</p>

                     </div>
                                <p>
                                    <input type="submit" class="button-primary" id="button_create_ebay_user" name="button_client_option" value="Link Ebay User / Application" />

                                </p>
                          
        </form>
</div>