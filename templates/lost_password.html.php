<?php
//Lost password. 
// generate email with key to reset

function lostPassword() {
	$msg_loggedin = "You are already Logged in";
	$error_key = $_GET['errors'];
	$error = 'Please enter your email address';
	$home = home_url();
	if ( is_user_logged_in() ) {
	echo "<div id='msg'>". $msg_loggedin. "'<br /><a href='" .$home. "'>Home</a></div>";
	return;
	}

	?>
	
<div class="container-fluid">
	<div id='container_forgot_pw'>
		<div class="regsubtitle col-lg-8 col-md-8 col-sm-12 col-xs-12" id='upper' style="text-align: center">
		Forgot Your Password?
		</div>
		<div class="regsections col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<div style="text-align: center">
			If you forgot your password, no worries. <br />Enter your email address and <br />we will send you a link you can use to reset your password.
			</div>
			<form  id="lostform" name="lostform" action="<?php echo wp_lostpassword_url(); ?>"  method="post">
			<div id="lower">
				<div class="form-group">
					<label for="lost_pw" style="margin-left: 10px">Email</label>
					<input class="form-control" type="text" name="user_login" id="lost_pw" placeholder="your email">
					</div>
				</div>
				<div class="form-group">
					<input class="form-control" type="submit" name="submit" id="pw_submit" Value= "Request Password">
				</div>
				<div id="msg"class="row">
					<?php 
					$error  = "";
					//var_dump($error_key);
					if ($error_key) {
						if ($error_key == 'empty_username') {
						$error = "Do we have your email?";
						echo $error;
						}
						if ($error_key == invalidcombo) {
						$error = "Please enter valid email";
						echo $error;
						}
						if ($error_key == invalid_email) {
						$error = "Sorry. This email is not registered with us";
						echo $error;
						}
					}
					$error = 'Success';
					?>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<?php
Return;
}