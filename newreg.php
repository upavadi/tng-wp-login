<?php
/*************************
* tng_path and tng_url
* can be obtained 
* from config.php in tng folder
* $rootpath for tng_path and
* $tngdomain for tng_url
*************************/
require_once "newreg_config.php"; 
require_once "templates/registration_form.html.php";
//include "newregcomplete.php";
/** This function drives shortcode [user_registration] ***/
$newreg_check = "00";

function new_reg() {
	$keys = keyValues();
	$input = $_POST;
	$newloginname = $_POST['loginname'];
	$newemail = $_POST['email'];
	$config = newRegConfig();
	$configPrivacy = newRegPrivacy();
	$data['values'] = $_POST;
	$data['errors'] = validate($_POST); 
	echo registration_form($data, $config['reg_form'], $config['reg_form_intro'], $configPrivacy['reg_form_consent'], $keys);

}
//checks are done in WP database
function validate($form) {
	$errors = array();
	$consent = (newRegPrivacy()); 
	$nameInTng = nameTng()['username'];
	if (($_POST)) {
	if (!isset($form['firstname']) || empty($form['firstname'])) {
		$errors['firstname'] = 'Cannot be empty';
	}
	if (!isset($form['lastname']) || empty($form['lastname'])) {
		$errors['lastname'] = 'Cannot be empty';
	}
	if (!isset($form['loginname']) || empty($form['loginname'])) {
		$errors['loginname'] = 'Cannot be empty';
	}
	if (!is_email($form['email'])) {
		$errors['email'] = 'email not valid';
	}
		if (!isset($form['email']) || empty($form['email'])) {
		$errors['email'] = 'Cannot be empty';
	}
	if (!isset($form['password']) || empty($form['password'])) {
		$errors['password'] = 'Cannot be empty';
	}
	if (strlen($_POST['password']) >= 1 && strlen($_POST['password']) < 8 ) {
		
		$errors['password'] = 'Password must be atleast 8 characters';
	}
	if (username_exists($_POST['loginname']) || isset($nameInTng))
	{
		$errors['loginname'] = 'User Name in use';
		$errors['userExists'] = true;
	}
	
	if (email_exists($_POST['email']))
	{
		$errors['email'] = 'Email is in use';
		$errors['emailExists'] = true;
		// Return to email input
	}
	
	if (!isset($_POST['consentGiven'])) 
	{	
		$errors['consentGiven'] = $consent['reg_form_consent']['prompt'];
	}

	}
	return $errors;

}
