<?php
require_once (__DIR__. '/../newreg_config.php');

function set_plugin_keys() {
    $keys = keyValues();
    $key1 = $keys['key1'];
	$key2 = $keys['key2'];
	$enabled = $keys['enabled'];

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
	ReCaptcha Keys:-
	</div>
	<div style="color: red">
	I have implemented Recaptcha Version 2. You will need to get Public and Private keys from http://www.google.com/recaptcha/admin#whyrecaptcha
	</div>
	<div class="rowadjust regsections">	
		<div class="row">
			<div class='col-md-2' style="width: 155px">
				Public Key: 
			</div>
			<div  class='col-md-3'>	
				<input type="text" class="form-control" name="key1" value= '<?php echo $key1; ?>'>
			</div>
			<div  class='col-md-6'>
			Enter Public Key  here to activate ReCaptcha.
			</div>
		</div>
		<div class="row rowadjust">
			<div class='col-md-2' style="width: 155px">
			Private Key:
			</div>
			<div  class='col-md-3'>	
				<input type="text" class="form-control" name="key2" value= '<?php echo $key2; ?>'>
			</div>
			<div  class='col-md-6'>
			You may enter your Private key here if you think it is safe to do so.
			</div>
		</div>
		<div class="row rowadjust">
			<div class='col-md-2 form-check-label' style="width: 155px">
			Enable reCaptacha
			</div>
			<div  class='col-md-3'>	
			<input type="checkbox" class="form-check-input" name="enabled" id="enabled" <?php if($enabled) echo "checked='checked'"; ?>>
			</div>
		</div>
			
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="Update_Keys" value="Update Keys">
	</p>
	
	</form>
</div>
<?php
}