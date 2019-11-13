<?php
//Registration form Messages template
function set_plugin_reg_messages() {
	global $reg_success, $Tngemail_success, $email_success, $intro_success;
	$config = optionsConfig();
	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";
 
	if (!isset($_POST['reg_message'])) {
		$reg_post = read_reg_complete();
	}

	if (isset($_POST['reg_message'])) {
		$reg_post = $_POST;
		$reg_success = update_reg_complete();
	}

	if (!isset($_POST['email_message'])) {
		$email_post = read_reg_email();
	}

	if (isset($_POST['email_message'])) {
		$email_post = $_POST;
		$email_success = update_reg_email();
	}

	if (!isset($_POST['Tngemail_message'])) {
		$Tngemail_post = read_tng_email();
	}

	if (isset($_POST['Tngemail_message'])) {
		$Tngemail_post = $_POST;
		$Tngemail_success = update_tng_email();
	}

	if (!isset($_POST['reg_intro_message'])) {
		$intro_post = read_reg_intro();
		
	}

	if (isset($_POST['reg_intro_message'])) {
		$intro_post = $_POST;
		$intro_success = update_reg_intro();
	} 
?>

<head>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__DIR__). '/css/wp_tng_login.css';?>">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<!-- Registration Success ----------->
<div class="container">
<form class="form-group" action=''  method="post">
	<input type="hidden" class="form-control" width="auto" name="reg_message" id='reg_message' value=true >
	<div class="regsubtitle">
	Registration Messages
	</div>
	<div style="padding-top: 30px">
	<b>Registration Success</b>
	</div>
	<div class="regsections">	
		<div class="form-group row col-md-12">
		<label for="regcomplete_title" class="col-md-1 col-form-label">Title</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="regcomplete_title" id="regcomplete_title inputs" value="<?php echo $reg_post['regcomplete_title']; ?>">
			</div>
		</div>
		<div class="form-group row col-md-12">
		<label for="regcomplete_line1" class="col-md-1 col-form-label">Line 1</label>
			<div class="col-md-11">
			<input type="text" class="form-control" name="regcomplete_line1" id="regcomplete_line1 inputs" value="<?php echo $reg_post['regcomplete_line1']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
		<label for="regcomplete_line2" class="col-md-1 col-form-label">Line 2</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="regcomplete_line2" id="regcomplete_line2 inputs" value="<?php echo $reg_post['regcomplete_line2']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
		<label for="regcomplete_line3" class="col-md-1 col-form-label">Line 3</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="regcomplete_line3" id="regcomplete_line3 inputs" value="<?php echo $reg_post['regcomplete_line3']; ?>">
			</div>
		</div>
		<div class="form-group row col-md-12">
		<label for="regcomplete_line4" class="col-md-1 col-form-label">Line 4</label>
		<div class="col-md-11">
			<input type="text" class="form-control" name="regcomplete_line4" id="regcomplete_line2 inputs" value="<?php echo $reg_post['regcomplete_line4']; ?>">
			</div> 
		</div>
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $reg_success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_Reg_success" value="Update Registration Success" style="width: auto">
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
				<input type="text" class="form-control" width="auto" name="regemail_title" id="regemail_title" value="<?php echo $email_post['regemail_title']; ?>">
				</div>
		</div>
		<div class="form-group row col-md-12">
			<label for="regemail_line1" class="col-md-1 col-form-label">Line 1</label>
			<div class="col-md-11">
		  	<input type="text" class="form-control" width="auto" name="regemail_line1" id="regemail_line1" value="<?php echo $email_post['regemail_line1']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="regemail_line2" class="col-md-1 col-form-label">Line 2</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="regemail_line2" id="regemail_line2" value="<?php echo $email_post['regemail_line2']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="regemail_line3" class="col-md-1 col-form-label">Line 3</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="regemail_line3" id="regemail_line3" value="<?php echo $email_post['regemail_line3']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="regemail_line2" class="col-md-1 col-form-label">Line 4</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="regemail_line4" id="regemail_line4" value="<?php echo $email_post['regemail_line4']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="regemail_line2" class="col-md-1 col-form-label">Line 5</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="regemail_line5" id="regemail_line5" value="<?php echo $email_post['regemail_line5']; ?>">
			</div> 
		</div>	
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $email_success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_Reg_success" value="Update New Registration Email" style="width: auto">
	</p>
	
</form>
</div>

<!-- email In TNG Database Only ----->
<div class="container">
<form class="form-group" action=''  method="post">
<input type="hidden" class="form-control" width="auto" name="Tngemail_message" id='Tngemail_message' value=true >
	<div style="padding-top: 30px">
		<b>Email In TNG Database Only</b>
	</div>
	<div class="regsections">	
		<div class="form-group row col-md-12">
			<label for="Tngemail_title" class="col-md-1 col-form-label">Title</label>
				<div class="col-md-11">
				<input type="text" class="form-control" width="auto" name="Tngemail_title" id="Tngemail_title" value="<?php echo $Tngemail_post['Tngemail_title']; ?>">
				</div>
		</div>
		<div class="form-group row col-md-12">
			<label for="Tngemail_line1" class="col-md-1 col-form-label">Line 1</label>
			<div class="col-md-11">
		  	<input type="text" class="form-control" width="auto" name="Tngemail_line1" id="Tngemail_line1" value="<?php echo $Tngemail_post['Tngemail_line1']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="Tngemail_line2" class="col-md-1 col-form-label">Line 2</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="Tngemail_line2" id="Tngemail_line2" value="<?php echo $Tngemail_post['Tngemail_line2']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="Tngemail_line3" class="col-md-1 col-form-label">Line 3</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="Tngemail_line3" id="Tngemail_line3" value="<?php echo $Tngemail_post['Tngemail_line3']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="Tngemail_line2" class="col-md-1 col-form-label">Line 4</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="Tngemail_line4" id="Tngemail_line4" value="<?php echo $Tngemail_post['Tngemail_line4']; ?>">
			</div> 
		</div>
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $Tngemail_success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_Tng_success" value="Update Email In TNG Only" style="width: auto">
	</p>
	</div>
</form>
</div>

<!-- Intro Text for New Registration Page ----->
<div class="container">
<form class="form-group" action=''  method="post">
<input type="hidden" class="form-control" width="auto" name="reg_intro_message" id='reg_intro_message' value=true >
	<div style="padding-top: 30px">
		<b>Intro Text for New Registration Page</b>
	</div>
	<div class="regsections">	
		<div class="form-group row col-md-12">
			<div class='form-check-label' style="width: 120px; verticla-align: middle">
				Enable Intro Text
			</div>
		<div  class='col-md-8'>	
				<input type="checkbox" class="form-check-input" style=" position: relative; verticla-align: bottom" name="enabled" id="enabled" <?php if($intro_post['enabled'] ) echo "checked='checked'"; ?>>
			</div>

		</div>

		<div class="form-group row col-md-12">
			<label for="intro_title" class="col-md-1 col-form-label">Title</label>
				<div class="col-md-11">
				<input type="text" class="form-control" width="auto" name="intro_title" id="intro_title" value="<?php echo $intro_post['intro_title']; ?>">
				</div>
		</div>
		<div class="form-group row col-md-12">
			<label for="intro_line1" class="col-md-1 col-form-label">Line 1</label>
			<div class="col-md-11">
		  	<input type="text" class="form-control" width="auto" name="intro_line1" id="intro_line1" value="<?php echo $intro_post['intro_line1']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="intro_line2" class="col-md-1 col-form-label">Line 2</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="intro_line2" id="intro_line2" value="<?php echo $intro_post['intro_line2']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="intro_line3" class="col-md-1 col-form-label">Line 3</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="intro_line3" id="intro_line3" value="<?php echo $intro_post['intro_line3']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="intro_line4" class="col-md-1 col-form-label">Line 4</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="intro_line4" id="intro_line4" value="<?php echo $intro_post['intro_line4']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
			<label for="intro_line5" class="col-md-1 col-form-label">Line 5</label>
			<div class="col-md-11">
			<input type="text" class="form-control" width="auto" name="intro_line5" id="intro_line5" value="<?php echo $intro_post['intro_line5']; ?>">
			</div> 
		</div>	
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $intro_success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_Reg_success" value="Update New Registration Intro Text" style="width: auto">
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