<?php
//settings for Lost Password
require_once(ABSPATH. 'wp-load.php');
require_once "newreg_config.php"; 
require_once "templates/lost_password.html.php";

/****** Outstanding *******/
function redirect_logged_in_user( $redirect_to = null ) {
//echo "to be done";
}
/*********/ 

	function redirect_for_lostpassword() {
//redirect the user to custom login form
		if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
			if ( is_user_logged_in() ) {
				$this->redirect_logged_in_user();
				exit;
			}
	 
			wp_redirect( home_url( 'wp-tng-lostPassword' ) );
			exit;
		}
	}
//* Initiates password reset.
	function do_password_lost() {
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			$errors = retrieve_password();
			if ( is_wp_error( $errors ) ) {
				// Errors found
				$redirect_url = home_url( 'wp-tng-lostPassword' ); 
				$redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
			} else {
				// Email sent
				$redirect_url = home_url( 'wp-tng-resetpassword' );
				$redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
				if ( ! empty( $_REQUEST['redirect_to'] ) ) {
					$redirect_url = $_REQUEST['redirect_to'];
				}
			}

			wp_safe_redirect( $redirect_url ); 
			exit;
		}
	}
/** rdirect to reset password ****
* needs authenticating
***/
	function redirect_to_password_reset() {
	
		if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
			// Verify key / login combo
			$user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
			if ( ! $user || is_wp_error( $user ) ) {
				if ( $user && $user->get_error_code() === 'expired_key' ) {
					wp_redirect( home_url( 'wp-tng-resetpassword?login=expiredkey' ) );
				} else {
					wp_redirect( home_url( 'wp-tng-resetpassword?login=invalidkey' ) );
				}
				exit;
			}

			$redirect_url = home_url( 'wp-tng-resetpassword' );
			$redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
			$redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );

			wp_redirect( $redirect_url );
			exit;
		}
	}

	function do_password_reset() {
	
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			$rp_key = $_REQUEST['rp_key'];
			$rp_login = $_REQUEST['rp_login'];

			$user = check_password_reset_key( $rp_key, $rp_login );

			if ( ! $user || is_wp_error( $user ) ) {
				if ( $user && $user->get_error_code() === 'expired_key' ) {
					wp_redirect( home_url( 'wp-tng-resetpassword?login=expiredkey' ) );
				} else {
					wp_redirect( home_url( 'wp-tng-resetpassword?login=invalidkey' ) );
				}
				exit;
			}

			if ( isset( $_POST['pass1'] ) ) {
				if ( $_POST['pass1'] != $_POST['pass2'] ) {
					// Passwords don't match
					$redirect_url = home_url( 'wp-tng-resetpassword' );

					$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
					$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
					$redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

					wp_redirect( $redirect_url );
					exit;
				}

				if ( empty( $_POST['pass1'] ) ) {
					// Password is empty
					$redirect_url = home_url( 'wp-tng-resetpassword' );

					$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
					$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
					$redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );

					wp_redirect( $redirect_url );
					exit;

				}

				// Parameter checks OK, reset password
				reset_tng_pass($user);
				reset_password( $user, $_POST['pass1'] );
				wp_redirect( home_url( 'wp-tng-resetpassword?password=changed' ) );
			} else {
				echo "Invalid request.";
			}

			exit;
		}
	}

/**
	 * Returns the message body for the password reset mail.
	 * Called through the retrieve_password_message filter.
**/	
	function replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {
		// Create new message for password reset - email
		$config = optionsConfig();
		$config = $config['forgot_pw_email'];
		$line1 = $config['line1'];
		$line2 = $config['line2']. " ". $user_data->user_email;
		$line3 = $config['line3'];
		$line4 = $config['line4'];
		$line5 = $config['line5'];
		$line6 = $config['line6'];
		$reset_address = site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' );

		$msg = $line1. "\r\n\r\n";
		$msg = $msg. $line2. "\r\n";
		$msg = $msg. $line3. "\r\n\r\n";
		$msg = $msg. $line4. "\r\n\r\n";
		$msg = $msg. $reset_address. "\r\n\r\n";
		$msg = $msg. $line5. "\r\n\r\n";
		$msg = $msg. $line6; 
		

		return $msg;
	}
	
	// Reset TNG password
	function reset_tng_pass($user) {
	$user_name = $user -> user_login;
		if ($_POST['pass1'] != $_POST['pass2']) return;
		$tngPath = getSubroot(). "config.php";
		include ($tngPath);
		$password = $_POST['pass2'];
		$password_type = $tngconfig['password_type'];
		$hashed_pass = $password_type($_POST['pass2']);
		$tngUserTable = tngUserTable(); 
		$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
		if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
		}
		//$sql = "UPDATE tng_users SET password='$hashed_pass' WHERE username='$user_name' ";
		$stmt = $db->prepare("UPDATE {$tngUserTable} SET password= ? WHERE username = ?");
		$stmt->bind_param("ss", $hashed_pass, $user_name);
		$success = $stmt->execute();
		$stmt->close();
		return;
		}	