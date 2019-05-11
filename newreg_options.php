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
	$nameInTng = nameTng($loginName);
	$emailInTng = emailTng($email);
	$conditions = array($nameInWp, $emailInWp, $nameInTng, $emailInTng);
	$conditions = array(false, false, false, false);
	if ($_POST) {
	switch ($conditions) {
		case array(true, true, true, true):
			$newreg_check = "00";
			$reg_message = $config['reg_pw-reset'];
			echo "name & email in both"; //suggest password reset
			break;
		case array(true, false, false, false): 
			$newreg_check = "02";
			echo $newreg_check, "name in wp"; // Ignore. Let validate() sort it
			break;
		case array(true, true, false, false): 
			$newreg_check = "03";
			echo $newreg_check, "name & email in wp"; // password reset if reqd. (Details to admin - no tng details)
			break;
		case array(true, false, true, false):
			$newreg_check = "04";
			//echo "name in wp & tng";  // password reset if reqd. (Details to admin - suspect email change).
			break;
		case array(true, true, true, false):
			$newreg_check = "05";
			echo "name in wp & tng - email wp"; //suggest password reset (Details to admin - tng email different)
			break;
		case array(false, true, false, true): 
			$newreg_check = "06";
			echo "email in wp & tng"; //suggest login with email. password reset if reqd. Note to admin: Prompt User name. 
			break;
		case array(false, true, false, false): 
			$newreg_check = "07";
			echo "email in wp only"; //suggest login with email. password reset if reqd. Email admin. wp account only.
			break;
		case array(true, false, true, true): 
			$newreg_check = "08";
			echo "name in wp and tng - email in tng only"; // Suggest login with user name. Password reset if reqd. Email admin.
			break;		
		case array(false, false, false, false): 
			$newreg_check = "09";
			$reg_message = $config['reg_complete'];
			echo registration_complete($reg_message);
			echo new_reg_mail();
			
			break;
		}

	}
	/** Set up functions here to respond to selections above */
	//return $newreg_check;
}