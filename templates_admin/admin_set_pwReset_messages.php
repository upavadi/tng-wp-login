<?php
//Text for Password Reset prompts and email

function set_plugin_pwreset_messages() {
	
	$config = optionsConfig();
	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";
	$pwReset = $config['reg_pw_reset'];
	$pwLost = $config['forgot_pw'];
	$pwEmail = $config['forgot_pw_email'];
	$pw_success = $email_success = '';
	 
		if (isset($_POST['pw_reset_message'])) {
			$pw_success = update_pw_message();
			Header('Location: '.$_SERVER['REQUEST_URI'] . "&success=" . urlencode(0));
		}

		if (isset($_POST['pw_lost_message'])) {
			$pwlost_success = update_pwlost_message();
			Header('Location: '.$_SERVER['REQUEST_URI'] . "&success=" . urlencode(1));
		}

		if (isset($_POST['lostPW_email_message'])) {
			$email_success = update_lostPW_email();
			Header('Location: '.$_SERVER['REQUEST_URI'] . "&success=" . urlencode(2));
		}

		if($_GET['success'] == '0') {
			$pw_reset_success = "PW Reset Template Changes Saved";
			$pw_lost_success = "";
			$pw_email_success = "";
		}
		if($_GET['success'] == '1') {
			$pw_reset_success = "";
			$pw_lost_success = "PW Lost Template Changes Saved";
			$pw_email_success = "";
		}	
		if($_GET['success'] == '2') {
			$pw_reset_success = "";
			$pw_lost_success = "";
			$pw_email_success = "PW Lost Email Changes Saved";
		}	
?>

<head>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__DIR__). '/css/wp_tng_login.css';?>">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<!-- Suggest Password Reset to New Registration ----------->
<div class="container">
<form class="form-group" action=''  method="post">
	<input type="hidden" class="form-control" width="auto" name="pw_reset_message" id='pw_reset_message' value=true >
	<div class="regsubtitle">
	Text for Password Reset Template
	</div>
	<div style="padding-top: 30px">
	<b>Suggest Password Reset to New Registration</b>
	</div>
	<div class="regsections">	
		<div class="form-group row col-md-12">
		<label for="PWreset_title" class="col-md-1 col-form-label">Title</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="PWreset_title" id="PWreset_title inputs" value="<?php echo $pwReset['title']; ?>">
			</div>
		</div>
		<div class="form-group row col-md-12">
		<label for="PWreset_line1" class="col-md-1 col-form-label">Line 1</label>
			<div class="col-md-11">
			<input type="text" class="form-control" name="PWreset_line1" id="PWreset_line1 inputs" value="<?php echo $pwReset['line1']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
		<label for="PWreset_line2" class="col-md-1 col-form-label">Line 2</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="PWreset_line2" id="PWreset_line2 inputs" value="<?php echo $pwReset['line2']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
		<label for="PWreset_line3" class="col-md-1 col-form-label">Line 3</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="PWreset_line3" id="PWreset_line3 inputs" value="<?php echo $pwReset['line3']; ?>">
			</div>
		</div>
		<div class="form-group row col-md-12">
		<label for="PWreset_line4" class="col-md-1 col-form-label">Line 4</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="PWreset_line4" id="PWreset_line4 inputs" value="<?php echo $pwReset['line4']; ?>">
			</div> 
		</div>
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $pw_reset_success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_PWreset_success" value="Suggest PW Reset Text" style="width: auto">
	</p>
	</div>
</form>
</div>

<!-- Forgot Your Password Text ----------->
<div class="container">
<form class="form-group" action=''  method="post">
	<input type="hidden" class="form-control" width="auto" name="pw_lost_message" id='pw_lost_message' value=true >
	<div class="regsubtitle">
	Text for Forgot Your Password Template
	</div>
	<div style="padding-top: 30px">
	<b>Forgot Your Password Text</b>
	</div>
	<div class="regsections">	
		<div class="form-group row col-md-12">
		<label for="PWreset_title" class="col-md-1 col-form-label">Title</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="PWreset_title" id="PWreset_title inputs" value="<?php echo $pwLost['title']; ?>">
			</div>
		</div>
		<div class="form-group row col-md-12">
		<label for="PWreset_line1" class="col-md-1 col-form-label">Line 1</label>
			<div class="col-md-11">
			<input type="text" class="form-control" name="PWreset_line1" id="PWreset_line1 inputs" value="<?php echo $pwLost['line1']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
		<label for="PWreset_line2" class="col-md-1 col-form-label">Line 2</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="PWreset_line2" id="PWreset_line2 inputs" value="<?php echo $pwLost['line2']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
		<label for="PWreset_line3" class="col-md-1 col-form-label">Line 3</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="PWreset_line3" id="PWreset_line3 inputs" value="<?php echo $pwLost['line3']; ?>">
			</div>
		</div>
		<div class="form-group row col-md-12">
		<label for="PWreset_line4" class="col-md-1 col-form-label">Line 4</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="PWreset_line4" id="PWreset_line4 inputs" value="<?php echo $pwLost['line4']; ?>">
			</div> 
		</div>
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $pw_lost_success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_PWreset_success" value="Forgot Your Password Text" style="width: auto">
	</p>
	</div>
</form>
</div>

<!-- Lost Password email ----->

<div class="container">
<form class="form-group" action=''  method="post">
<input type="hidden" class="form-control" width="auto" name="lostPW_email_message" id='lostPW_email_message' value=true >
	<div class="regsubtitle">
	Text for Forgot Your Password Email
	</div>
	<div style="padding-top: 30px">
		<b>Lost Password email</b>
	</div>
	<div class="regsections">	
		<div class="form-group row col-md-12">
			<label for="pwemail_title" class="col-md-1 col-form-label">Title</label>
				<div class="col-md-11">
				<input type="text" class="form-control" width="auto" name="pwemail_title" id="pwemail_title" value="<?php echo $pwEmail['title']; ?>">
				</div>
		</div>
		<div class="form-group row col-md-12">
			<label for="pwemail_cc" class="col-md-1 col-form-label">CopyTo</label>
			<div class="col-md-11">
			<input type="email" class="form-control" width="auto" name="pwemail_cc" id="pwemail_cc" placeholder="send email copy to" value="<?php echo $pwEmail['CC']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="pwemail_line1" class="col-md-1 col-form-label">Line 1</label>
			<div class="col-md-11">
		  	<input type="text" class="form-control" width="auto" name="pwemail_line1" id="pwemail_line1" value="<?php echo $pwEmail['line1']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="pwemail_line2" class="col-md-1 col-form-label">Line 2</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="pwemail_line2" id="pwemail_line2" value="<?php echo $pwEmail['line2']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="pwemail_line3" class="col-md-1 col-form-label">Line 2</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="pwemail_line3" id="pwemail_line3" value="<?php echo $pwEmail['line3']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="pwemail_line4" class="col-md-1 col-form-label">Line 4</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="pwemail_line4" id="pwemail_line4" value="<?php echo $pwEmail['line4']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="pwemail_line5" class="col-md-1 col-form-label">Line 5</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="pwemail_line5" id="pwemail_line5" value="<?php echo $pwEmail['line5']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="pwemail_line6" class="col-md-1 col-form-label">Line 6</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="pwemail_line6" id="pwemail_line6" value="<?php echo $pwEmail['line6']; ?>">
			</div> 
		</div>	
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $pw_email_success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="email_message" value="Update Lost Password Email" style="width: auto">
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