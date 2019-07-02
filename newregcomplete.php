<?php
/************************************************************************************************
Validation checks
01 - name & email in both - suggest password reset
02 - name in wp. Let validate() sort it. email to admin
03 - name & email in wp - password reset if reqd. (Details to admin - no tng details)
04 - name in wp & tng - password reset if reqd. (Details to admin - suspect email change).
05 - name in wp & tng - email wp - suggest password reset (Details to admin - tng email different)
06 - email in wp & tng - suggest login with email. password rset if reqd. Note to admin: Prompt User name.
07 - email in wp only - suggest login with email. password reset if reqd. Email admin. email in wp account only.
08 - name in wp and tng - email in tng only - Suggest login with user name. Password reset if reqd. Email admin.
09 - Save registration - Safe to register. Save registration. Go to 'Thank You Page'
**************************************************************************************************/		
//include "newreg_options.php";
require_once (dirname(__FILE__). '/newreg_config.php'); 
require_once "newreg.php";
require_once "newreg_options.php"; 
require_once "templates/registration_complete.html.php";
require_once "templates/registration_form.html.php";

function newreg_complete() {
	$newreg_entries = (validate($_POST));
	$newreg_entries = $newreg_entries['emailExists'];
//	$newreg_complete = newregCheck($_POST['loginname'], $_POST['email']);
	$input = $_POST;
	$newloginname = $_POST['loginname'];
	$newemail = $_POST['newemail'];
	$config = newRegConfig();
	$data['values'] = $_POST;
	$data['errors'] = validate($_POST);
	newregCheck(); 
	exit;
}

//add user to WP
function insertUserWP() {
	global $wpdb;
	$userdata = array(
    'user_login'  =>  $_POST['loginname'],
    'user_pass'   =>  $_POST['password'],
	'user_nicename'   =>  $_POST['loginname'],
	'user_email'   =>  $_POST['email'],
	'display_name'   =>  $_POST['firstname']. " ". $_POST['lastname'],
	'nickname'   =>  $_POST['nickName'],
	'first_name'   =>  $_POST['firstname'],
	'last_name'   =>  $_POST['lastname'],
	'description'   =>  $_POST['bioinfo'],
	'tng_interest'   =>  $_POST['tng_interest'],
	'show_admin_bar_front'   =>  false
	
	);
	wp_insert_user($userdata);
	$newuser = get_user_by('login', $_POST['loginname']);
	$Id = ($newuser->ID);
	add_user_meta($Id, 'tng_interest', $_POST['tng_interest'], false);
	return;
}

//add user to TNG
function insertUserTng() {
	$tngPath = getTngPath(). "config.php";
	include ($tngPath);
	//$password_type = $tngconfig['password_type'];
	$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}

	$firstName = $_POST['firstname'];
	$lastName = $_POST['lastname'];
	$userName = $_POST['loginname'];
	$description = $_POST['firstname']. " ". $_POST['lastname'];
	$password = $_POST['password'];
	$realname = $_POST['firstname']. " ". $_POST['lastname'];
	$email = $_POST['email'];
	$notes = $_POST['bioinfo'];
	$role = 'guest';
	$allow_living = -1;
	$website = 'http://';
	$date = date('c');
	$gedcom = $branch = $address = $city = $state = $zip = $country = $no_email = '';

	$sql = "INSERT INTO `tng_users` (`username`, `description`, `password`, `email`, `realname`, `notes`, `role`, `allow_living`, `website`, `dt_registered`, `gedcom`, `branch`, `phone`, `address`, `city`, `state`, `zip`, `country`, `no_email`) values('$userName', '$description', '$password', '$email', '$realname', '$notes', '$role', '$allow_living', '$website', '$date', '$gedcom', '$branch', '$phone', '$address', '$city', '$state', '$zip', '$country', '$no_email')";
	mysqli_query($db, $sql);
	if ($db->error) {
		echo "<div id='msg'>. Ooops: something went wrong. Please try again " . $db->error;
	}
	
return;
}

//send email - registration request - suggest password reset
function new_reg_pwreset__mail() {
	$config = newRegConfig();
	$to = get_option('admin_email');
	$subject = "New Registration - Suggest Password Reset";
	$message = new_reg_pwreset_email_text();
	wp_mail($to, $subject, $message, $headers);
}


//send email - registration request - Email in TNG only
function new_reg_tng_only_mail() {
	$config = newRegConfig();
	$to = get_option('admin_email');
	$subject = "New Registration - Email in TNG Only";
	$message = new_reg_pwreset_email_text();
	//echo "<pre>{($to, $subject, $message)}</pre>";
	wp_mail($to, $subject, $message, $headers);

}

//send email - registration request
function new_reg_mail() {
	$config = newRegConfig();
	$to = sanitize_email($_POST['email']);
	$bcc = get_option('admin_email');
	$subject = $config['new_reg_email']['title'];
	$message = new_reg_email_text();
	$cc = get_option('admin_email');
	$headers[] = 'Bcc:'. $bcc;
//	echo "<pre>{($to, $subject, $message)}</pre>";
	wp_mail($to, $subject, $message, $headers);
return;
}

//body-text for new regisration email
function new_reg_email_text() {
	$config = newRegConfig();
	$line = $config['new_reg_email'];
	$reg_text1 = $line['line1']. ", ". $_POST['firstname'].", \r\n\r\n". $line['line2']. "\r\n";
	$reg_text2 = "Your User Name is ". $_POST['loginname']. " and your password is ". $_POST['password']. ". \r\n";
	$reg_text3 = $line['line3']. "\r\n\r\n". $line['line4']. "\r\n\r\n". $line['line5'];
	$text = $reg_text1. $reg_text2. $reg_text3;
	return $text;
}

//prepare body-text for new regisration email
function new_reg_pwreset_email_text() {
	//wordpress id check
	$wpUser = (get_user_by(login, $_POST['loginname'] ));
	$nameInWp_id = $wpUser->ID;
	$nameInWp_name = $wpUser->user_login;
	$nameInWp_email = $wpUser->user_email;
	$wpEmail = (get_user_by(email, $_POST['email'] ));
	$emailInWp_id = $wpEmail->ID;
	$emailInWp_name = $wpEmail->user_login;
	$emailInWp_email = $wpEmail->user_email;
	$nameInTng_id = nameTng()['userID'];
	$nameInTng_name = nameTng()['username'];
	$nameInTng_email = nameTng()['email'];
	$emailInTng_id = emailTng()['userID'];
	$emailInTng_name = emailTng()['username'];
	$emailInTng_email = emailTng()['email'];
	
	$config = newRegConfig();
	$line = $config['new_reg_email'];
	$reg_text1 = "New Registration requested by ". $_POST['firstname']. " ". $_POST['lastname'];
	$reg_text2 = "Submitted User Name  = ". $_POST['loginname']. ": Submitted email = ". $_POST['email'];
	$reg_text3 = "Checking for submitted User Name in Wordpress Database:";
	$reg_text4 = "ID = ". $nameInWp_id. ", User Name = ". $nameInWp_name. ", Email = ". $nameInWp_email;   
	$reg_text5 = "Checking for submitted User Email in Wordpress Database:";
	$reg_text6 = "ID = ". $emailInWp_id. ", User Name = ". $emailInWp_name. ", Email = ". $emailInWp_email;   
	$reg_text7 = "Checking for submitted User Name in TNG Database:";
	$reg_text8 = "ID = ". $nameInTng_id. ", User Name = ". $nameInTng_name. ", Email = ". $nameInTng_email;   
	$reg_text9 = "Checking for submitted User Email in TNG Database:";
	$reg_text10 = "ID = ". $emailInTng_id. ", User Name = ". $emailInTng_name. ", Email = ". $emailInTng_email;
	

	$text = "Hi Administrator,\r\n\r\n". $reg_text1. "\r\n". $reg_text2. "\r\n\r\n". $reg_text3. "\r\n". $reg_text4. "\r\n\r\n". $reg_text5. "\r\n". $reg_text6.  "\r\n\r\n". $reg_text7. "\r\n". $reg_text8. "\r\n\r\n". $reg_text9. "\r\n". $reg_text10. "\r\n\r\n". "Regards \r\n\r\n Wordpress";
	return $text;
}

function check_credentials() {
	$config = newRegConfig();
	$newreg_check = "00";
	$loginName = $_POST{'loginname'};
	$email = $_POST{'email'};
	if (username_exists($loginName)) {
		$nameInWp = true;
	} else {
		$nameInWp =false;
	}
	if (email_exists($email)) { 
		$emailInWp = true;
		} else {
		$emailInWp =false;
	}	
	$nameInTng = nameTng()['username'];
	if ($nameInTng) { 
		$nameInTng = true;
		} else {
		$nameInTng =false;
	}
	$emailInTng = emailTng()['email'];
	echo ($emailInTng);
	if ($emailInTng) { 
		$emailInTng = true;
		} else {
		$emailInTng =false;
	}
	$conditions = array($nameInWp, $emailInWp, $nameInTng, $emailInTng);
	return $conditions;

}