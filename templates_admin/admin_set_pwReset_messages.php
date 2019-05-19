<?php
//Text for Password Reset prompts and email
 if($_GET['success'] == '0') $reg = "Reg Template Changes Saved";
 if($success==1) $reg_success = "Email Template Changes Saved";

function set_plugin_pwreset_messages() {
	
	$config = optionsConfig();
	//$config_headers = ($config['reg_form']['sections']);
	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";
	$pwReset = $config['reg_pw_reset'];
	$pwEmail = $config['new_reg_email'];
	$reg_success = $email_success = '';
	 
		if (isset($_POST['reg_message'])) {
			$reg_success = update_reg_complete();
			Header('Location: '.$_SERVER['REQUEST_URI'] . "&success=" . urlencode(0));
		}

		if (isset($_POST['email_message'])) {
			$email_success = update_reg_email();
			Header('Location: '.$_SERVER['REQUEST_URI'] . "&success=" . urlencode(1));
		}

		if($_GET['success'] == '0') {
			$reg_success = "Reg Template Changes Saved";
			$email_success = "";
		}
		if($_GET['success'] == '1') {
			$reg_success = "";
			$email_success = "Email Template Changes Saved";
		}	
		
?>

<head>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__DIR__). '/css/wp_tng_login.css';?>">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<!-- Registration Success ----------->
<div class="container">
<form class="form-group" action=''  method="post">
	<input type="hidden" class="form-control" width="auto" name="pw_reset_message" id='reg_message' value=true >
	<div class="regsubtitle">
	Text for Password Reset Templates
	</div>
	<div style="padding-top: 30px">
	<b>Suggest Password Reset to New Registration</b>
	</div>
	<div class="regsections">	
		<div class="form-group row col-md-12">
		<label for="regcomplete_title" class="col-md-1 col-form-label">Title</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="regcomplete_title" id="regcomplete_title inputs" value="<?php echo $pwReset['title']; ?>">
			</div>
		</div>
		<div class="form-group row col-md-12">
		<label for="regcomplete_line1" class="col-md-1 col-form-label">Line 1</label>
			<div class="col-md-11">
			<input type="text" class="form-control" name="regcomplete_line1" id="regcomplete_line1 inputs" value="<?php echo $pwReset['line1']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
		<label for="regcomplete_line2" class="col-md-1 col-form-label">Line 2</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="regcomplete_line2" id="regcomplete_line2 inputs" value="<?php echo $pwReset['line2']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
		<label for="regcomplete_line3" class="col-md-1 col-form-label">Line 3</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="regcomplete_line3" id="regcomplete_line3 inputs" value="<?php echo $pwReset['line3']; ?>">
			</div>
		</div>
		<div class="form-group row col-md-12">
		<label for="regcomplete_line4" class="col-md-1 col-form-label">Line 4</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="regcomplete_line4" id="regcomplete_line2 inputs" value="<?php echo $pwReset['line4']; ?>">
			</div> 
		</div>
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $reg_success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_Reg_success" value="Update - Suggest PW Reset" style="width: auto">
	</p>
	</div>
</form>
</div>

<!-- New Registration email ----->

<div class="container">
<form class="form-group" action=''  method="post">
<input type="hidden" class="form-control" width="auto" name="email_message" id='email_message' value=true >
	<div style="padding-top: 30px">
		<b>New Registration email</b>
	</div>
	<div class="regsections">	
		<div class="form-group row col-md-12">
			<label for="regemail_title" class="col-md-1 col-form-label">Title</label>
				<div class="col-md-11">
				<input type="text" class="form-control" width="auto" name="regemail_title" id="regemail_title" value="<?php echo $regEmail['title']; ?>">
				</div>
		</div>
		<div class="form-group row col-md-12">
			<label for="regemail_cc" class="col-md-1 col-form-label">CopyTo</label>
			<div class="col-md-11">
			<input type="email" class="form-control" width="auto" name="regemail_cc" id="regemail_cc" placeholder="send email copy to" value="<?php echo $regEmail['CC']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="regemail_line1" class="col-md-1 col-form-label">Line 1</label>
			<div class="col-md-11">
		  	<input type="text" class="form-control" width="auto" name="regemail_line1" id="regemail_line1" value="<?php echo $regEmail['line1']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="regemail_line2" class="col-md-1 col-form-label">Line 2</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="regemail_line2" id="regemail_line2" value="<?php echo $regEmail['line2']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="regemail_line3" class="col-md-1 col-form-label">Line 2</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="regemail_line3" id="regemail_line3" value="<?php echo $regEmail['line3']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="regemail_line2" class="col-md-1 col-form-label">Line 4</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="regemail_line4" id="regemail_line4" value="<?php echo $regEmail['line4']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="regemail_line2" class="col-md-1 col-form-label">Line 5</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="regemail_line5" id="regemail_line5" value="<?php echo $regEmail['line5']; ?>">
			</div> 
		</div>	
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $email_success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_Reg_success" value="Update New Registration Email" style="width: auto">
	</p>
	</div>
	
	
</form>
</div>
	<style>
#wpfooter {
display: none;
}
</style>
<?php
}
?>