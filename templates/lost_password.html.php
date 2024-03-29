<?php
//Lost password. 
// generate email with key to reset
$config = newRegConfig()['forgot_pw'];
static $error_key;
function lostPassword() {
	static $error_key;
	$config = newRegConfig()['forgot_pw'];
	$msg_loggedin = "You are already Logged in";
	if (isset($_GET['errors'])) $error_key = $_GET['errors'];
	$error = 'Please enter your email address';
	$home = home_url();
	if ( is_user_logged_in() ) {
	echo "<div id='msg'>". $msg_loggedin. "'<br /><a href='" .$home. "'>Home</a></div>";
	return;
}

?>
<!-- add bootstrap here instead of primary file to avoid conflucts with other plugins -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<div class="container-fluid">
	<div id='container_forgot_pw'>
		<div class="regsubtitle" id='upper' style="text-align: center">
		<?php echo $config['title']; ?>
		</div>
		<div class="regsections">
			<div style="text-align: center">
			<?php 	echo $config['line1']. "<br />". $config['line2']. "<br />".$config['line3']. "<br />".$config['line4']. "<br />" ?>
			</div>
			<form  id="lostform" name="lostform" action="<?php echo wp_lostpassword_url(); ?>"  method="post">
			<div id="lower">
				<div class="form-group">
					<label for="lost_pw" style="margin-left: 50px">Your Email</label>
					<input class="form-control input" type="email" name="user_login" id="lost_pw" placeholder="your email">
				</div>
				
				<div class="form-group">
					<input class="form-control" type="submit" name="submit" id="pw_submit" Value= "Request Password">
				</div>
				<div id="msg"class="row">
					<?php 
					$error  = "";
					//var_dump($_GET);
					if ($error_key) {
						if ($error_key == 'empty_username') {
						$error = "Do we have your email?";
						echo $error;
						}
						// if ($error_key == invalidcombo) {  
						// $error = "Please enter valid email";
						// echo $error;
						//}
						if ($error_key == 'invalid_email') {
						$error = "Sorry. This email is not registered with us";
						echo $error;
						}
						if ($error_key == 'retrieve_password_email_failure') {
							$error = "Something has gone wrong. Please try again or Contact Us";
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