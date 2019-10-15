<?php
require_once ABSPATH. 'wp-load.php';
require_once 'newreg.php';
require_once 'newreg_config.php';
require_once 'newregcomplete.php';
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

function newregCheck() { 
	$conditions = check_credentials();
	//var_dump($conditions); 
	//$conditions = array(true, true, true, true);
	if ($_POST) 
	{
	switch ($conditions) {
		case array(true, true, true, true):
			$newreg_check = "00";
			//	echo "name & email in both"; //suggest password reset
			process_pw_reset();
			break;
		case array(true, false, false, false): 
			$newreg_check = "02";
			//process_pw_reset();
			//echo $newreg_check, "name in wp"; // Ignore. Let validate() sort it
			break;
		case array(true, true, false, false): 
			$newreg_check = "03";
			process_pw_reset(); //"name & email in wp"; // password reset if reqd. (Details to admin - no tng details)
			break;
		case array(true, false, true, false):
			$newreg_check = "04";
		//	process_pw_reset();
			//echo "name in wp & tng";  // password reset if reqd. (Details to admin - suspect email change).
			break;

		case array(true, true, true, false):
			$newreg_check = "05";
			process_pw_reset();
			//echo "name in wp & tng - email wp"; //suggest password reset (Details to admin - tng email different)
			break;
		case array(false, true, false, true): 
			$newreg_check = "06";
			process_pw_reset();
		//	echo "email in wp & tng"; //suggest login with email. password reset if reqd. Note to admin: Prompt User name. 
			break;
		case array(false, true, false, false): 
			$newreg_check = "07";
			process_pw_reset();
			//echo "email in wp only"; //suggest login with email. password reset if reqd. Email admin. wp account only.
			break;
		case array(true, false, true, true): 
			$newreg_check = "08";
			process_email_in_tng_only();
			//echo "name in wp and tng - email in tng only"; // Suggest Admin deals with this. Password cannot be reset.
			break;	
		case array(false, false, false, true): 
			process_email_in_tng_only();
			//echo "email in tng only"; // Suggest Admin deals with this. Password cannot be reset.
			break;	
		case array(false, false, true, true): 
			process_email_in_tng_only();
			//echo "name and email in tng only"; // Suggest Admin deals with this. Password cannot be reset.
			break;				
		case array(false, false, false, false): 
			$newreg_check = "09";
			process_new_reg(); 
			//New User. Enter details in wp and tng
			break;
			default:
			return;

	}
}

return;
}


function process_new_reg() {
	$config = newRegConfig();
	$success = insertUserTng(); 
	if($success == true) {
	insertUserWP();	
	$reg_message = $config['reg_complete'];
	echo registration_complete($reg_message);

	echo new_reg_mail();
	}

return;
}

function process_pw_reset() {
	$config = newRegConfig();
	$reg_message = $config['reg_pw_reset'];
	echo registration_complete($reg_message);
	echo new_reg_pwreset__mail();
return;
}

function process_email_in_tng_only() {
	$config = newRegConfig();
	$reg_message = $config['reg_email_tng_only'];
	echo registration_complete($reg_message);
	echo new_reg_tng_only_mail();
return;
}