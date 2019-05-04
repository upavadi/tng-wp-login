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
require_once "newreg_config.php"; 
require_once "newreg.php";
require_once "newreg_options.php"; 
require_once "templates/registration_complete.html.php";
require_once "templates/registration_form.html.php";

function newreg_complete() {
	$newreg_entries = (validate($_POST));
	$newreg_entries = $newreg_entries['emailExists'];
	
	$newreg_complete = newregCheck($_POST['loginname'], $_POST['email']);
	echo "<br />reg complete = ". $newreg_complete;
	
	$input = $_POST;
	$newloginname = $_POST['loginname'];
	$newemail = $_POST['newemail'];
	$config = newRegConfig();
	$data['values'] = $_POST;
	$data['errors'] = validate($_POST);
	$newregComlete_token = newregCheck($_POST['loginname'], $_POST['email']);
	echo "Options=". newregCheck();
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
	$description = $_POST['NickName'];
	$password = $_POST['password'];
	$realname = $_POST['firstname']. " ". $_POST['lastname'];
	$email = $_POST['email'];
	$notes = $_POST['bioinfo'];
	$role = 'guest';
	$allow_living = -1;
	$website = 'http://';
	$date = date('c');

	$sql = "INSERT INTO `tng_users` (`username`, `description`, `password`, `email`, `realname`, `notes`, `role`, `allow_living`, `website`, `dt_registered`) values('$userName', '$description', '$password', '$email', '$realname', '$notes', '$role', '$allow_living', '$website', '$date')";
	mysqli_query($db, $sql);
	if ($db->query($sql) === TRUE) {
		echo "<div id='msg_grn'>". "<b>Your changes have been updated</b>"."</div>";
	} else {
		echo "<div id='msg'>. Ooops: something went wrong. Please try again " . $db->error;
	}
	

}

//send email - registration request
function new_reg_mail() {
	$config = newRegConfig();
	$message = new_reg_email_text();
	$from = get_option('admin_email');
	$cc = $config['new_reg_email']['CC'];
	$args = array(
		'to:' => $_POST['email'],
		'from:' => get_option('admin_email'),
		'subject' => $config['new_reg_email']['title'],
		'message' => $message,
		'headers' => array( 
		'from: Administrator <'.$from. '>;',
		'CC: Copy to <'. $cc. '>')
);
	$sanitised_args = reg_mail_filter($args);
	$to = $sanitised_args['to'];
	$to = $sanitised_args['subject'];
	$to = $sanitised_args['message'];
	$to = $sanitised_args['headers'];
	echo "<pre>{($to, $subject, $message, $headers)}</pre>";
	//wp_mail($to, $subject, $message, $headers);
	return;
}

//prepare body-text for new regisration email
function new_reg_email_text() {
	$config = newRegConfig();
	$line = $config['new_reg_email'];
	$reg_text1 = $line['line1']. ", ". $_POST['firstname'].", \r\n\r\n". $line['line2']. "\r\n";
	$reg_text2 = "Your User Name is ". $_POST['loginname']. " and your password is ". $_POST['password']. ". \r\n";
	$reg_text3 = $line['line3']. "\r\n\r\n". $line['line4']. "\r\n\r\n". $line['line5'];
	$text = $reg_text1. $reg_text2. $reg_text3;
	return $text;
}

//use filter to clean wp_mail data
add_filter( 'wp_mail', 'reg_mail_filter' );
function reg_mail_filter($args) {
	$reg_wp_mail = array(
		'to' => $args['to'],
		'from' => $args['from'],
		'subject' => $args['subject'],
		'message' => $args['message'],
		'headers' => $args['headers']
	);
	
	return $reg_wp_mail;
}
/****
hints:-
wp_mail( $to, $subject, $message, $headers = '')
}
**/