<?php
//TNG Paths are derived from TNG config.php.

require_once (__DIR__. '/../newreg_config.php');

function set_plugin_login_messages() {
	$config = optionsConfig();
	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";

	if (!isset($_POST['login_message'])) {
		$login_post = read_login_message();
	}
	if (isset($_POST['login_message'])) {
		$login_post = $_POST;
		$login_success = update_login_message();
	}

?>

<head>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__DIR__). '/css/wp_tng_login.css';?>">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<!-- Suggest Password Reset to New Registration ----------->
<div class="container">
<form class="form-group" action=''  method="post">
	<input type="hidden" class="form-control" width="auto" name="login_message" id='pw_reset_message' value=true >
	<div class="regsubtitle">
	Text for Login Widget
	</div>
	<div style="padding-top: 30px">
	<b>Manage LogIn Text</b>
	</div>
	<div class="regsections">	
		<div class="form-group row col-md-12">
		<label for="greetin" class="col-md-2 col-form-label">Greeting</label>
			<div class="col-md-10">
			<input type="text" class="form-control" width="auto" name="greeting" id="greeting inputs" value="<?php echo $login_post['greeting']; ?>">
			</div>
		</div>
		<div class="form-group row col-md-12">
		<label for="version_id" class="col-md-2 col-form-label">Sub Greeting</label>
			<div class="col-md-10">
			<input type="text" class="form-control" name="version_id" id="version_id inputs" value="<?php echo $login_post['version_id']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
		<label for="user_page" class="col-md-2 col-form-label">User Page ID</label>
		<div class="col-md-10">
			<input type="text" class="form-control" name="user_page" id="user_page inputs" value="<?php echo $login_post['user_page']; ?>">
			</div> 
		</div>
		<div class="form-group row col-md-12">
		<label for="user_page_name" class="col-md-2 col-form-label">User Page Name</label>
		<div class="col-md-10">
			<input type="text" class="form-control" name="user_page_name" id="user_page_name inputs" value="<?php echo $login_post['user_page_name']; ?>">
			</div>
		</div>
		<div class="form-group row col-md-12">
		<label for="reg_page" class="col-md-2 col-form-label">Reg'n Page ID</label>
		<div class="col-md-10">
			<input type="text" class="form-control" name="reg_page" id="reg_page inputs" value="<?php echo $login_post['reg_page']; ?>">
			</div> 
		</div>
        <div class="form-group row col-md-12">
		<label for="reg_page_name" class="col-md-2 col-form-label">Registration Page</label>
		<div class="col-md-10">
			<input type="text" class="form-control" name="reg_page_name" id="reg_page_name inputs" value="<?php echo $login_post['reg_page_name']; ?>">
			</div> 
		</div>
        <div class="form-group row col-md-12">
		<label for="lost_password" class="col-md-2 col-form-label">Lost Password</label>
		<div class="col-md-10">
			<input type="text" class="form-control" name="lost_password" id="lost_password inputs" value="<?php echo $login_post['lost_password']; ?>">
			</div> 
		</div>
        <div class="form-group row col-md-12">
		<label for="RememberMe" class="col-md-2 col-form-label">Remember Me</label>
		<div class="col-md-10">
			<input type="text" class="form-control" name="RememberMe" id="RememberMe inputs" value="<?php echo $login_post['RememberMe']; ?>">
			</div> 
		</div>
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $login_success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_login_success" value="Save LogIn Text" style="width: auto">
	</p>
	</div>
</form>
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
