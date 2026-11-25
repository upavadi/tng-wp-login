<?php
require_once "newreg_config.php"; 
require_once "templates/registration_form.html.php";
$newreg_check = "00";

function new_reg() {
	$keys = keyValues();
	$input = $_POST;
	if(isset($_POST['loginname']))
	$newloginname = $_POST['loginname'];
	if(isset($_POST['email']))
	$newemail = $_POST['email'];
	$config = newRegConfig();
	$configPrivacy = newRegPrivacy();
	$data['values'] = $_POST;
	$data['errors'] = validate($_POST); 
	echo registration_form($data, $config['reg_form'], $config['reg_form_intro'], $configPrivacy['reg_form_consent'], $keys);

}

/**
 * Verify the reCAPTCHA answer with Google. Showing the widget alone does not
 * stop bots, which can post the form directly without solving it.
 * Google accepts each answer only once, and validate() runs several times per
 * request, so the result is cached for the rest of the request.
 * Returns true when reCAPTCHA is disabled or no secret key is configured.
 */
function tng_wp_login_captcha_passed() {
	static $passed = null;
	if ( null !== $passed ) {
		return $passed;
	}
	$keys = keyValues();
	if ( empty( $keys['enabled'] ) || empty( $keys['key2'] ) ) {
		return $passed = true;
	}
	$captcha = isset( $_POST['g-recaptcha-response'] ) ? sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ) : '';
	if ( '' === $captcha ) {
		return $passed = false;
	}
	$verify = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
		'timeout' => 10,
		'body'    => array(
			'secret'   => $keys['key2'],
			'response' => $captcha,
			'remoteip' => isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '',
		),
	) );
	$result = is_wp_error( $verify ) ? null : json_decode( wp_remote_retrieve_body( $verify ), true );
	return $passed = ! empty( $result['success'] );
}

function validate($form) {
	$errors = array();
	$consent = (newRegPrivacy());
	$consentPrompt = $consent['reg_form_consent']['prompt'];
	$consentEnabled = $consent['reg_form_consent']['enabled']; 
	$nameInTng = nameTng();//['username'];
	if(isset($nameInTng)) $nameInTng = $nameInTng['username'];
	if (($_POST)) {
	// Verify the reCAPTCHA answer server-side (see tng_wp_login_captcha_passed()).
	if ( ! tng_wp_login_captcha_passed() ) {
		$errors['captcha'] = 'Please confirm you are not a robot.';
	}
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
	if ($consentEnabled) {
		if (!isset($_POST['consentGiven'])) 
		{	
			$errors['consentGiven'] = $consent['reg_form_consent']['prompt'];
		}
	}

	}
	return $errors;

}