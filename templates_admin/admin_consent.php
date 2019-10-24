<?php
require_once (__DIR__. '/../newreg_config.php');

function set_plugin_privacy() {
	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";
    $configPrivacy = newRegPrivacy(); 
	$tngVersion = guessTngVersion().".xx";

	if (!isset($_POST['Update_privacy'])) {
		$privacy = read_privacy();
	}
	if (isset($_POST['Update_privacy'])) {
		$login_post = $_POST;
		//$login_success = update_login_message();
	}
	var_dump(read_privacy());
	//tng settings
	$tng_path = getSubroot(). "config.php";
	include ($tng_path);
	$tngcookieapproval = $tngdataprotect = $tngaskconsent = "No";
	if ($tngconfig['cookieapproval'] == 1) { 
	$cookieapproval = "Yes";
	$show_cookie_approval = "on";	
	}
	if ($tngconfig['dataprotect'] == 1) {
	$tngdataprotect = "Yes";
	$show_data_protect = "on";
	}
	if ($tngconfig['askconsent'] == 1) {
	$tngaskconsent = "Yes";
	$ask_consent = "on";
	}


	
	var_dump($login_post);
	


?>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__DIR__). '/css/wp_tng_login.css';?>">

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<div class="wrap container"  style='width: auto'>
<form class="form-group" action=''  method="post">
	<div class="regsubtitle">
	<?php echo $configPrivacy['title']; ?>
	</div>
	<div class="rowadjust regsections">
		<div style="font-weight: bold">
		<?php echo "TNG Version is ". $tngVersion. ". "; ?>
		You may still use Privacy for TNG Versions 9 - 11
		</div>
		<div style="padding-top: 1em; font-weight: bold">
			TNG Settings
		</div>	
		<!-- consent -->
		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="left" class='col-md-4'>
			Show cookie approval message
			</div>
			<div class='col-md-6'>	
			<?php echo $tngcookieapproval; ?>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: 0em;">
			<div align="left" class='col-md-4'>
			Prompt for consent regarding personal info
			</div>
			<div class='col-md-6'>	
			<?php echo $tngaskconsent; ?>
			</div>
		</div>
		
		<div class="row rowadjust" style="padding-top: 0em;">
			<div align="left" class='col-md-4'>
			Show link to data protection policy:
			</div>
			<div class='col-md-6'>	
			<?php echo $tngdataprotect; ?>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: 0.5em;color: blue">
			<div align="left" class='col-md-12'>
			Please note that your settings in TNG will be reflected below
			</div>
		
		</div>
	<!-- End Tng settings ---------->	
	<!-- Cookie select -->	
		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="right" class='col-md-4'>
			Show Cookie Message for Anonymous visitor 
			</div>
			<div class='col-md-1'>	
			<input type="checkbox" class="form-check-input" name="show_cookie_approval" id="cookieApproval" <?php if($show_cookie_approval) echo "checked='checked'"; ?>>
			</div>
			<div align="left">
			<i>Option selected in TNG setup</i>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: .3em;">
			<div align="right" class='col-md-4'>
			Cookie Message
			</div>
			<div  class='col-md-6'>
			<textarea class="form-control" name=cookieText" placeholder="Text for cookie Approval"><?php echo $privacy['cookieText']; ?></textarea>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: 0.5em;color: blue">
			<div align="left" class='col-md-12'>
			<i>Wordpress stores session cookies for logged in users. So a message can be displayed below Login widget with a short message to anonymous visitors to state that this site uses cookies. The message is not shown to logged in users. TNG message will still be shown on all tng pages.</i>
			</div>
		</div>	

		


	<!--New  user consent ----------->
		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="right" class='col-md-4'>
			Enable User Consent regarding personal info: 
			</div>
			<div class='col-md-1'>	
			<input type="checkbox" class="form-check-input" name="ask_consent" id="reg_form_privacy_enabled"<?php if($ask_consent) echo "checked='checked'"; ?>>
			</div>
			<div align="left">
			<i>Option selected in TNG setup</i>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: .3em;">
			<div style="text-align:right;" class='col-md-4'>
			User consent agreement Text
			</div>
			<div  class='col-md-6'>
			<textarea class="form-control" name=consentText" placeholder="text for user consent agreement"><?php echo $privacy['reg_form_privacy_line1']; ?></textarea></div>
		</div>
		<div class="row rowadjust" style="padding-top: .3em;">
			<div align="right" class='col-md-4'>
			Prompt for consent agreement
			</div>
			<div  class='col-md-6'>
			<textarea class="form-control" name=consentPrompt" placeholder="Prompt for user consent agreement"><?php echo $privacy['reg_form_privacy_prompt']; ?></textarea>
			</div>
		</div>

	<!--New  user consent ----------->
		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="right" class='col-md-4'>
			Seek Consent from existing User
			</div>
			<div class='col-md-6'>	
			<input type="checkbox" class="form-check-input" name="current_user_consent" id="current_user_consent" <?php if($privacy['current_user_consent']) echo "checked='checked'"; ?>>
			(Ask on login, if consent not given already)
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: .3em;">
			<div align="right" class='col-md-4'>
			Prompt for Logged In User Consent
			</div>
			<div  class='col-md-6'>
			<textarea class="form-control" name=current_user_consent_text" placeholder="Prompt for user consent agreement"><?php echo $privacy['current_user_consent_text']; ?></textarea>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: 0.5em;color: blue">
			<div align="left" class='col-md-12'>
			<i>When a user logs in, check for consent flag. If consent-flag not set, ask for consent. Logout user consent is withheld.</i>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="right" class='col-md-4'>
			Show link to data protection policy: 
			</div>
			<div class='col-md-1'>	
			<input type="checkbox" class="form-check-input" name="show_data_protect" id="show_data_protect" <?php if($show_data_protect) echo "checked='checked'"; ?>>
			</div>
			<div align="left">
			<i>Option selected in TNG setup</i>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: .3em;">
			<div align="right" class='col-md-4'>
			URL for Document Location
			</div>
			<div  class='col-md-6'>
			<input type="text" class="form-control" name="tng_photo_folder" value= '<?php echo $_POST['tng_photo_folder']; ?>'>
			</div>
		</div>

		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="right" class='col-md-4'>
			Use Wordpress Page as Privacy Document
			</div>
			<div class='col-md-6'>	
			<input type="checkbox" class="form-check-input" name="cookieEnabled" id="cookieEnabled" <?php if($cookieApproval) echo "checked='checked'"; ?>>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: .3em;">
			<div align="right" class='col-md-4'>
			URL for Document Location
			</div>
			<div  class='col-md-6'>
			<input type="text" class="form-control" name="tng_photo_folder" value= '<?php echo $_POST['tng_photo_folder']; ?>'>
			</div>
		</div>
			
		</div>
	</div>	
		<p style="color: green; display: inline-block"><?php echo "<b>". $success. "</b><br />"; ?></p>
		<p>
		<input type="submit" name="Update_privacy" style="width: auto" value="Update Settings">
		</p>

</form>
</div><!-- container
<?php
}