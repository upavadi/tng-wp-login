<?php
require_once(__DIR__. '/../lost_pw_settings.php');
	function resetPassword() {
	$msg_success = 'Your password has been changed. You may Login Now';
		if ( is_user_logged_in() ) {
			return ( 'You are already Logged in');
		}else {
			if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
				$attributes['login'] = $_REQUEST['login'];
				$attributes['key'] = $_REQUEST['key'];	
				
			}
		}
		
		$error = $_REQUEST['error'];
		if ($_REQUEST['password'] == 'changed') {
			echo "<div id='msg_grn'>". $msg_success. "'<br /><a href='" .$home. "'>Home</a></div>"; 
			return;
		}
		if ($_REQUEST['checkemail'] == 'confirm') {
			return ('Please check your email. <br /> Click on the link to reset your password');
		}
?>
<!-- add bootstrap here instead of primary file to avoid conflucts with other plugins -->	
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<div class="container-fluid">1234
	<div id='container_forgot_pw'>
		<div class="regsubtitle" id='upper' style="text-align: center">
		Reset Your Password
		</div>
		<div class="regsections">
		<form id="resetpasswordform" name="resetpasswordform" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">
		<input type="text" id="user_login" name="rp_login" value="<?php echo esc_attr( $attributes['login'] ); ?>" autocomplete="off" hidden />
		<input type="text" name="rp_key" value="<?php echo esc_attr( $attributes['key'] ); ?>" hidden/>
		<div id="lower">
			<div class="form-group">
				<label for="pass1" style="margin-left: 10px">New password</label>
				<input type="password" class="form-control" name="pass1" id="pass1" class="input" value="" autocomplete="off">
			</div>
			<div class="form-group">
				<label for="pass2" style="margin-left: 10px">Repeat New password</label>
				<input type="password" class="form-control" name="pass2" id="pass2" class="input" value="" autocomplete="off">
			</div>
			<div class="form-group">
				<input class="form-control" type="submit" name="submit" id="pw_submit" Value= "Reset Password">
			</div>
			<div class="row">
			<p class="description" id="msg_grn">Hint: The password should be at least eight characters long"
			<div id="msg"class="row">
			<?php 
			//$error  = "";
			
			if ($error) {
				if ($error == 'password_reset_empty') {
				$error = 'Please enter and varify new password';
				echo $error;
				}
				if ($error = 'password_reset_mismatch') {
				$error = "Passwords do not match";
				echo $error;
				}
			}
			?>
			</p>
			</div>
		</form>
		</div><!--regsections-->
	</div>
</div><!--container-fluid-->

<?php
	}