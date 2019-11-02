<?php
require_once (__DIR__. '/../newreg_config.php');

function set_plugin_privacy() {
	global $success;
	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";
    $configPrivacy = newRegPrivacy(); 
	$tngVersion = guessTngVersion().".xx";
	$config = optionsConfig();
	$tng_url = ($config['paths']['tng_url']);

	if (!isset($_POST['read_privacy'])) {
		$post = read_privacy();
	}
	if (isset($_POST['Update_privacy'])) {
		$post = $_POST;
		$success = update_privacy();
	}
	
	//tng settings
	$tng_path = getSubroot(). "config.php";
	include ($tng_path);
	 
	if($tngVersion >= 12) {
		$tngcookieapproval = $tngdataprotect = $tngaskconsent = "No";
		if ($tngconfig['cookieapproval'] == 1) { 
		$tngcookieapproval = "Yes";
		$post['showCookie'] = true;	
		}
		
		if ($tngconfig['dataprotect'] == 1) {
		$tngdataprotect = "Yes";
		$post['show_data_protect'] = true;
		}
		if ($tngconfig['askconsent'] == 1) {
		$tngaskconsent = "Yes";
		$post['ask_consent'] = true;
		}
}
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
		</div>

	<?php
	if ($tngVersion < 12) echo "You may use Privacy for TNG Versions 9 - 11";
	if($tngVersion >= 12) {
	?>
		<div style="padding-top: 1em; font-weight: bold">
		TNG Settings
		</div>	
		<!-- consent -->
		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="left" class='col-md-4'>
			Prompt for consent regarding personal info
			</div>
			<div class='col-md-6'>	
			<?php echo $tngaskconsent; ?>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: 0em;">
			<div align="left" class='col-md-4'>
			Show cookie approval message
			</div>
			<div class='col-md-6'>	
			<?php echo $tngcookieapproval; ?>
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
		<div class="row rowadjust" style="padding-top: 0.5em;color: #706D6D">
			<div align="left" class='col-md-12'>
			Please note that your settings in TNG will be reflected below
			</div>
		</div>
	<?php
	}
	?>	
		<!-- End Tng settings ---------->	
		

			<!--New  user consent ----------->
			<div class="row rowadjust" style="padding-top: 2em;">
			<div align="right" class='col-md-4'>
			Enable User Consent regarding personal info: 
			</div>
			<div class='col-md-1'>	
			<input type="checkbox" class="form-check-input" name="askConsent" id="ask_consent"<?php if($post['askConsent'] == true) echo "checked='checked'"; ?>>
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
			<textarea class="form-control" name="consentText" placeholder="text for user consent agreement"><?php echo $post['consentText']; ?></textarea></div>
		</div>
		<div class="row rowadjust" style="padding-top: .3em;">
			<div align="right" class='col-md-4'>
			Prompt for consent agreement
			</div>
			<div  class='col-md-6'>
			<textarea class="form-control" name="consentPrompt" placeholder="Prompt for user consent agreement"><?php echo $post['consentPrompt']; ?></textarea>
			</div>
		</div>

		<!-- Seek Consent from existing User ----------->
		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="right" class='col-md-4'>
			Seek Consent from existing User
			</div>
			<div class='col-md-6'>	
			<input type="checkbox" class="form-check-input" name="current_user_consent" id="current_user_consent" <?php if($post['current_user_consent'] == true) echo "checked='checked'"; ?>>
			(Ask on login, if consent not given already)
			</div>
		</div>

		<div class="row rowadjust" style="padding-top: .3em;">
			<div align="right" class='col-md-4'>
			Prompt for Logged In User Consent
			</div>
			<div  class='col-md-6'>
			<textarea class="form-control" name="current_user_consent_text" placeholder="Prompt for user consent agreement"><?php echo $post['current_user_consent_text']; ?></textarea>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: 0.5em;color: #706D6D">
			<div align="center" class='col-md-10'>
			<i>When a user logs in, check for consent flag. If consent-flag not set, ask for consent. Logout user consent is withheld.</i>
			</div>
		</div>

		<!-- Cookies -->
		<!-- Cookie select -->	
		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="right" class='col-md-4'>
			Show Cookie Message for anonymous visitor 
			</div>
			<div class='col-md-1'>	
			<input type="checkbox" class="form-check-input" name="showCookie"<?php if($post['showCookie'] == true) echo "checked='checked'"; ?>>
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
			<textarea class="form-control" name="cookieText" placeholder="Text for cookie Approval"><?php echo $post['cookieText']; ?></textarea>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: 0.5em;color: #706D6D">
			<div align="center" class='col-md-10'>
			<i>Wordpress stores session cookies for logged in users. So a message can be displayed below Login widget with a short message to anonymous visitors to state that this site uses cookies. The message is not shown to logged in users. TNG message will still be shown on all tng pages.</i>
			</div>
		</div>



		<div class="row rowadjust" style="padding-top: 2em;">
			<div align="right" class='col-md-4'>
			Show link to data protection policy: 
			</div>
			<div class='col-md-1'>	
			
			<input type="checkbox" class="form-check-input" name="show_data_protect" id="show_data_protect" <?php if ($post['show_data_protect'] == true) echo "checked='checked'"; ?>>
			</div>
			<div align="left">
			<i>Option selected in TNG setup</i>
			</div>
		</div>
	
		<! Data Protection Docs -->
		<div class="row rowadjust" style="padding-top: .3em;">
			<div align="right" class='col-md-4'>
			URL for Document Location
			</div>
			<div  class='col-md-6'>
			<input type="text" class="form-control" name="tng_protect_url" placeholder="paste appropriate path" value= '<?php echo $post['tng_protect_url']; ?>'>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: 0.5em;">
			<div align="right" class='col-md-4' style="padding-top: 0.5em;color: #706D6D">
			To use TNG Privacy Doc
			</div>
			<div align="left" class='col-md-6' style="padding-top: 0.5em;">
				<?php echo $tng_url. "/data_protection_policy.php";
				 ?> 
			</div>
		</div>
		<div class="row rowadjust" >
			<div align="right" class='col-md-4' style="color: #706D6D">
			For Wordpress Page
			</div>
			<div align="left" class='col-md-6'>
			<?php echo home_Url(). "/your Wordpress page"; ?> 
			</div>
		</div>
		<div class="row rowadjust">
			<div align="right" class='col-md-4' style="color: #706D6D">
			For any other location 
			</div>
			<div align="left" class='col-md-6'>
				http://example.com/your Data_policy_file 
			</div>
		</div>

	
	<!-------------------------------------->
	</div>	
		<p style="color: green; display: inline-block"><?php echo "<b>". $success. "</b><br />"; ?></p>
		<p>
		<input type="submit" name="Update_privacy" style="width: auto" value="Update Settings">
		</p>
	
</form>
</div><!-- container-->
<?php
}