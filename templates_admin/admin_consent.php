<?php
require_once (__DIR__. '/../newreg_config.php');

function set_plugin_privacy() {
    $config = optionsConfig();
	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";
    $configPrivacy = newRegPrivacy(); 
	$tngVersion = guessTngVersion();
	$consentEnabled = $configPrivacy['reg_form_consent']['enabled'];
	$consentText = $configPrivacy['reg_form_consent']['line1'];
	$consentPrompt = $configPrivacy['reg_form_consent']['prompt'];
	$cookieApproval = $configPrivacy['cookieApproval'];
	$cookieText = $configPrivacy['cookieText'];
	
    $consenttrue = "";
    $consentfalse = "selected";
    if ($consent == true) {
        $consenttrue = "selected";
        $consentfalse = "";
    } 

	var_dump($configPrivacy, $_POST);
	if ($_POST) {	
		$key1 = $_POST['key1'];
		$key2 = $_POST['key2'];
		$enabled = $_POST['enabled'] === 'on';
	}

	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
	}

	if (isset($_POST['Update_Keys'])) {
		$success = "";

		// update_keys();
		$success = update_keys($key1, $key2, $enabled);
		// echo "<meta http-equiv='refresh' content=$success>";
		//return;
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
    <?php echo "TNG Version = ". $tngVersion; ?>	
		<!-- consent -->
		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="right" class='col-md-4'>
			Enable User Consent regarding personal info: 
			</div>
			<div class='col-md-6'>	
			<input type="checkbox" class="form-check-input" name="consentEnabled" id="consentEnabled" checke>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: .3em;">
			<div style="text-align:right;" class='col-md-4'>
			User consent agreement
			</div>
			<div  class='col-md-6'>
			<textarea class="form-control" name=consentText" placeholder="text for user consent agreement"><?php echo $consentText; ?></textarea></div>
		</div>
		<div class="row rowadjust" style="padding-top: .3em;">
			<div align="right" class='col-md-4'>
			Prompt for consent agreement
			</div>
			<div  class='col-md-6'>
			<textarea class="form-control" name=cookieText" placeholder="Prompt for user consent agreement"><?php echo $consentPrompt; ?></textarea>
			</div>
		</div>
	<!-- Cookie select -->	
		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="right" class='col-md-4'>
			Enable User Cookie Approval 
			</div>
			<div class='col-md-6'>	
			<input type="checkbox" class="form-check-input" name="cookieEnabled" id="cookieEnabled" <?php if($cookieApproval) echo "checked='checked'"; ?>>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: .3em;">
			<div align="right" class='col-md-4'>
			Text for Cookie Approval
			</div>
			<div  class='col-md-6'>
			<textarea class="form-control" name=cookie_Text" placeholder="Text for cookie Approval"><?php echo $cookieText; ?></textarea>
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="right" class='col-md-4'>
			Seek Consent from existing User
			</div>
			<div class='col-md-6'>	
			<input type="checkbox" class="form-check-input" name="cookieEnabled" id="cookieEnabled" <?php if($cookieApproval) echo "checked='checked'"; ?>>
			(Ask on login, if consent not given already)
			</div>
		</div>
		<div class="row rowadjust" style="padding-top: .3em;">
			<div align="right" class='col-md-4'>
			Prompt for Logged In User Consent
			</div>
			<div  class='col-md-6'>
			<textarea class="form-control" name=cookieText" placeholder="Prompt for user consent agreement"><?php echo $consentPrompt; ?></textarea>
			</div>
		</div>

		<div class="row rowadjust" style="padding-top: 1em;">
			<div align="right" class='col-md-4'>
			Use TNG Privacy Document
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