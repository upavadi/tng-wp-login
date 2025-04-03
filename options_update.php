<?php
//updates config.json file
require_once "tng_wp_options.php";
// update tng real path, tng url and photos folder
function update_paths() {
	$path_json = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new["paths"]['tng_path'] = $_POST["tng_path"];
	$config_new['paths']['tng_url'] = $_POST['tng_url'];
	$config_new['paths']['tng_photo_folder'] = $_POST['tng_photo_folder'];
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	file_put_contents($path_json, $json);
	$success = "Changes Saved";
	return $success;
}

// update ReCaptcha V2 Keys
function update_keys($key1, $key2, $enabled) {
	$path_json = (__DIR__. '/keyValue.json');
	$keys_new['key1'] = $key1;
	$keys_new['key2'] = $key2;
	$keys_new['enabled'] = $enabled;
	$json = (json_encode($keys_new, JSON_PRETTY_PRINT));
	file_put_contents($path_json, $json);
	$success = "Changes Saved";
	return $success;
}

//update Text used for Profile form
function read_profile() {
	$config = optionsConfig();
	$header1 = $config['show_profile']['sections'][0];
	$header1a = $config['show_profile']['sections'][0]['fields'][0];
	$header1b = $config['show_profile']['sections'][0]['fields'][1];
	$header1c = $config['show_profile']['sections'][0]['fields'][2];
	$header1d = $config['show_profile']['sections'][0]['fields'][3];
	$post['header1'] = $header1['label'];
	$post['label1a'] = $header1a['label'];
	$post['description1a'] = $header1a['description'];
	$post['placeholder1a'] = $header1a['placeholder'];
	$post['label1b'] = $header1b['label'];
	$post['description1b'] = $header1b['description'];
	$post['placeholder1b'] = $header1b['placeholder'];
	$post['label1c'] = $header1c['label'];
	$post['description1c'] = $header1c['description'];
	$post['placeholder1c'] = $header1c['placeholder'];
	$post['label1d'] = $header1d['label'];
	$post['description1d'] = $header1d['description'];
	$post['placeholder1d'] = $header1d['placeholder'];

	$header2 = $config['show_profile']['sections'][1];
	$header2a = $config['show_profile']['sections'][1]['fields'][0];
	$header2b = $config['show_profile']['sections'][1]['fields'][1];
	$header2c = $config['show_profile']['sections'][1]['fields'][2];
	$header2d = $config['show_profile']['sections'][1]['fields'][3];
	$post['header2'] = $header2['label'];
	$post['label2a'] = $header2a['label'];
	$post['description2a'] = $header2a['description'];
	$post['placeholder2a'] = $header2a['placeholder'];
	$post['label2b'] = $header2b['label'];
	$post['description2b'] = $header2b['description'];
	$post['placeholder2b'] = $header2b['placeholder'];
	$post['label2c'] = $header2c['label'];
	$post['description2c'] = $header2c['description'];
	$post['placeholder2c'] = $header2c['placeholder'];
	$post['label2d'] = $header2d['label'];
	$post['description2d'] = $header2d['description'];
	$post['placeholder2d'] = $header2d['placeholder'];

	$header3 = $config['show_profile']['sections'][2];
	$header3a = $config['show_profile']['sections'][2]['fields'][0];
	$header3b = $config['show_profile']['sections'][2]['fields'][1];
	$post['header3'] = $header3['label'];
	$post['label3a'] = $header3a['label'];
	$post['description3a'] = $header3a['description'];
	$post['placeholder3a'] = $header3a['placeholder'];
	$post['enabled3a'] = $header3a['enabled'];
	$post['label3b'] = $header3b['label'];
	$post['description3b'] = $header3b['description'];
	$post['placeholder3b'] = $header3b['placeholder'];
	$post['enabled3b'] = $header3b['enabled'];
	return $post;
}
function update_profile() {
	$config = optionsConfig();
	$config_new = $config;
	$section1 = $config_new['show_profile']['sections'][0];
	$config_new['show_profile']['sections'][0];
	($config_new['show_profile']['sections'][0]);

	/****headers 1 ****/
	$config_new['show_profile']['sections'][0]['label'] = $_POST['header1'];
	
	$config_new['show_profile']['sections'][0]['fields'][0]['label'] = $_POST['label1a'];
	$config_new['show_profile']['sections'][0]['fields'][0]['description'] = $_POST['description1a'];
	$config_new['show_profile']['sections'][0]['fields'][0]['placeholder'] = $_POST['placeholder1a'];
	
	$config_new['show_profile']['sections'][0]['fields'][1]['label'] = $_POST['label1b'];
	$config_new['show_profile']['sections'][0]['fields'][1]['description'] = $_POST['description1b'];
	$config_new['show_profile']['sections'][0]['fields'][1]['placeholder'] = $_POST['placeholder1b'];
	
	$config_new['show_profile']['sections'][0]['fields'][2]['label'] = $_POST['label1c'];
	$config_new['show_profile']['sections'][0]['fields'][2]['description'] = $_POST['description1c'];
	$config_new['show_profile']['sections'][0]['fields'][2]['placeholder'] = $_POST['placeholder1c'];
	
	$config_new['show_profile']['sections'][0]['fields'][3]['label'] = $_POST['label1d'];
	$config_new['show_profile']['sections'][0]['fields'][3]['description'] = $_POST['description1d'];
	$config_new['show_profile']['sections'][0]['fields'][3]['placeholder'] = $_POST['placeholder1d'];
	
	/****headers 2 ****/
	$config_new['show_profile']['sections'][1]['label'] = $_POST['header2'];
	
	$config_new['show_profile']['sections'][1]['fields'][0]['label'] = $_POST['label2a'];
	$config_new['show_profile']['sections'][1]['fields'][0]['description'] = $_POST['description2a'];
	$config_new['show_profile']['sections'][1]['fields'][0]['placeholder'] = $_POST['placeholder2a'];
	
	$config_new['show_profile']['sections'][1]['fields'][1]['label'] = $_POST['label2b'];
	$config_new['show_profile']['sections'][1]['fields'][1]['description'] = $_POST['description2b'];
	$config_new['show_profile']['sections'][1]['fields'][1]['placeholder'] = $_POST['placeholder2b'];
	$config_new['show_profile']['sections'][1]['fields'][2]['label'] = $_POST['label2c'];
	$config_new['show_profile']['sections'][1]['fields'][2]['description'] = $_POST['description2c'];
	$config_new['show_profile']['sections'][1]['fields'][2]['placeholder'] = $_POST['placeholder2c'];
	$config_new['show_profile']['sections'][1]['fields'][3]['label'] = $_POST['label2d'];
	$config_new['show_profile']['sections'][1]['fields'][3]['description'] = $_POST['description2d'];
	$config_new['show_profile']['sections'][1]['fields'][3]['placeholder'] = $_POST['placeholder2d'];
	
	/****headers 3 ****/
	$config_new['show_profile']['sections'][2]['label'] = $_POST['header3'];
	
	$config_new['show_profile']['sections'][2]['fields'][0]['label'] = $_POST['label3a'];
	$config_new['show_profile']['sections'][2]['fields'][0]['description'] = $_POST['description3a'];
	$config_new['show_profile']['sections'][2]['fields'][0]['placeholder'] = $_POST['placeholder3a'];
	if (isset($_POST['enabled3a'])) {
	$config_new['show_profile']['sections'][2]['fields'][0]['enabled'] = true;
	} else {
	$config_new['show_profile']['sections'][2]['fields'][0]['enabled'] = false;
	}
	
	$config_new['show_profile']['sections'][2]['fields'][1]['label'] = $_POST['label3b'];
	$config_new['show_profile']['sections'][2]['fields'][1]['description'] = $_POST['description3b'];
	$config_new['show_profile']['sections'][2]['fields'][1]['placeholder'] = $_POST['placeholder3b'];
	if (isset($_POST['enabled3b'])) {
	$config_new['show_profile']['sections'][2]['fields'][1]['enabled'] = true;
	} else {
	$config_new['show_profile']['sections'][2]['fields'][1]['enabled'] = false;
	}
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$success = 'Changes Saved';
	return $success;
}

function read_reg_form() {
	$config = optionsConfig();
	//var_dump($config['reg_form']['sections'][0]);
	
	$header1 = $config['reg_form']['sections'][0];
	$header1a = $config['reg_form']['sections'][0]['fields'][0];
	$header1b = $config['reg_form']['sections'][0]['fields'][1];
	$header1c = $config['reg_form']['sections'][0]['fields'][2];
	//$header1d = $config['reg_form']['sections'][0]['fields'][3];
	$post['header1'] = $header1['label'];
	$post['label1a'] = $header1a['label'];
	$post['description1a'] = $header1a['description'];
	$post['placeholder1a'] = $header1a['placeholder'];
	$post['label1b'] = $header1b['label'];
	$post['description1b'] = $header1b['description'];
	$post['placeholder1b'] = $header1b['placeholder'];
	$post['label1c'] = $header1c['label'];
	$post['description1c'] = $header1c['description'];
	$post['placeholder1c'] = $header1c['placeholder'];

	$header2 = $config['reg_form']['sections'][1];
	$header2a = $config['reg_form']['sections'][1]['fields'][0];
	$header2b = $config['reg_form']['sections'][1]['fields'][1];
	$header2c = $config['reg_form']['sections'][1]['fields'][2];
	//$header2d = $config['reg_form']['sections'][1]['fields'][3];
	$post['header2'] = $header2['label'];
	$post['label2a'] = $header2a['label'];
	$post['description2a'] = $header2a['description'];
	$post['placeholder2a'] = $header2a['placeholder'];
	$post['label2b'] = $header2b['label'];
	$post['description2b'] = $header2b['description'];
	$post['placeholder2b'] = $header2b['placeholder'];
	$post['label2c'] = $header2c['label'];
	$post['description2c'] = $header2c['description'];
	$post['placeholder2c'] = $header2c['placeholder'];
	//$post['label2d'] = $header2d['label'];
	//$post['description2d'] = $header2d['description'];
//	$post['placeholder2d'] = $header2d['placeholder'];

	$header3 = $config['reg_form']['sections'][2];
	$header3a = $config['reg_form']['sections'][2]['fields'][0];
	$header3b = $config['reg_form']['sections'][2]['fields'][1];
	$post['header3'] = $header3['label'];
	$post['label3a'] = $header3a['label'];
	$post['description3a'] = $header3a['description'];
	$post['placeholder3a'] = $header3a['placeholder'];
	$post['enabled3a'] = $header3a['enabled'];
	$post['label3b'] = $header3b['label'];
	$post['description3b'] = $header3b['description'];
	$post['placeholder3b'] = $header3b['placeholder'];
	$post['enabled3b'] = $header3b['enabled'];
	return $post;
}
//update Text used for Registration form
function update_registration() {
	$url = "config.json";
	$config = optionsConfig();
	$config_new = $config;
	$section1 = $config_new['reg_form']['sections'][0];
	$config_new['reg_form']['sections'][0];
	($config_new['reg_form']['sections'][0]);
	
	/****headers 1 ****/
	$config_new['reg_form']['sections'][0]['label'] = $_POST['header1'];
	$config_new['reg_form']['sections'][0]['fields'][0]['label'] = $_POST['label1a'];
	$config_new['reg_form']['sections'][0]['fields'][0]['description'] = $_POST['description1a'];
	$config_new['reg_form']['sections'][0]['fields'][0]['placeholder'] = $_POST['placeholder1a'];
	$config_new['reg_form']['sections'][0]['fields'][1]['label'] = $_POST['label1b'];
	$config_new['reg_form']['sections'][0]['fields'][1]['description'] = $_POST['description1b'];
	$config_new['reg_form']['sections'][0]['fields'][1]['placeholder'] = $_POST['placeholder1b'];
	$config_new['reg_form']['sections'][0]['fields'][2]['label'] = $_POST['label1c'];
	$config_new['reg_form']['sections'][0]['fields'][2]['description'] = $_POST['description1c'];
	$config_new['reg_form']['sections'][0]['fields'][2]['placeholder'] = $_POST['placeholder1c'];
	/****headers 2 ****/
	$config_new['reg_form']['sections'][1]['label'] = $_POST['header2'];
	$config_new['reg_form']['sections'][1]['fields'][0]['label'] = $_POST['label2a'];
	$config_new['reg_form']['sections'][1]['fields'][0]['description'] = $_POST['description2a'];
	$config_new['reg_form']['sections'][1]['fields'][0]['placeholder'] = $_POST['placeholder2a'];
	
	$config_new['reg_form']['sections'][1]['fields'][1]['label'] = $_POST['label2b'];
	$config_new['reg_form']['sections'][1]['fields'][1]['description'] = $_POST['description2b'];
	$config_new['reg_form']['sections'][1]['fields'][1]['placeholder'] = $_POST['placeholder2b'];
	
	$config_new['reg_form']['sections'][1]['fields'][2]['label'] = $_POST['label2c'];
	$config_new['reg_form']['sections'][1]['fields'][2]['description'] = $_POST['description2c'];
	$config_new['reg_form']['sections'][1]['fields'][2]['placeholder'] = $_POST['placeholder2c'];
	/**
	$config_new['reg_form']['sections'][1]['fields'][3]['label'] = $_POST['label2d'];
	$config_new['reg_form']['sections'][1]['fields'][3]['description'] = $_POST['description2d'];
	$config_new['reg_form']['sections'][1]['fields'][3]['placeholder'] = $_POST['placeholder2d'];
	**/
	/****headers 3 ****/
	$config_new['reg_form']['sections'][2]['label'] = $_POST['header3'];
	
	$config_new['reg_form']['sections'][2]['fields'][0]['label'] = $_POST['label3a'];
	$config_new['reg_form']['sections'][2]['fields'][0]['description'] = $_POST['description3a'];
	$config_new['reg_form']['sections'][2]['fields'][0]['placeholder'] = $_POST['placeholder3a'];
	if (isset($_POST['enabled3a'])) {
	$config_new['reg_form']['sections'][2]['fields'][0]['enabled'] = true;
	} else {
	$config_new['reg_form']['sections'][2]['fields'][0]['enabled'] = false;
	}
	
	$config_new['reg_form']['sections'][2]['fields'][1]['label'] = $_POST['label3b'];
	$config_new['reg_form']['sections'][2]['fields'][1]['description'] = $_POST['description3b'];
	$config_new['reg_form']['sections'][2]['fields'][1]['placeholder'] = $_POST['placeholder3b'];
	if (isset($_POST['enabled3b'])) {
	$config_new['reg_form']['sections'][2]['fields'][1]['enabled'] = true;
	} else {
	$config_new['reg_form']['sections'][2]['fields'][1]['enabled'] = false;
	}
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$suceess = "Changes Saved";
	return $suceess;
}

//read login text
function read_login_message() {
	$config = optionsConfig();
	$login_post['loggedout_greeting'] = $config['login_text']['loggedout_greeting'];
	$login_post['greeting'] = $config['login_text']['greeting'];
	$login_post['version_id'] = $config['login_text']['version_id'];
	$login_post['user_page'] = $config['login_text']['user_page'];
	$login_post['user_page_name'] = $config['login_text']['user_page_name'];
	$login_post['reg_page'] = $config['login_text']['reg_page'];
	$login_post['reg_page_name'] = $config['login_text']['reg_page_name'];
	$login_post['lost_password'] = $config['login_text']['lost_password'];
	$login_post['RememberMe'] = $config['login_text']['RememberMe'];
	$login_post['cookie_notification'] = $config['login_text']['cookie_notification'];
	return $login_post;
}

//Update login text
function update_login_message() {
	$path = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new['login_text']['loggedout_greeting'] = $_POST['loggedout_greeting'];
	$config_new['login_text']['greeting'] = $_POST['greeting'];
	$config_new['login_text']['version_id'] = $_POST['version_id'];
	$config_new['login_text']['user_page'] = $_POST['user_page'];
	$config_new['login_text']['user_page_name'] = $_POST['user_page_name'];
	$config_new['login_text']['reg_page'] = $_POST['reg_page'];
	$config_new['login_text']['reg_page_name'] = $_POST['reg_page_name'];
	$config_new['login_text']['lost_password'] = $_POST['lost_password'];
	$config_new['login_text']['RememberMe'] = $_POST['RememberMe'];
	$config_new['login_text']['cookie_notification'] = $_POST['cookie_notification'];
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$success = "Changes to LogIn Text Saved";
	return $success;
}

//read privacy
function read_privacy() {
	$configPrivacy = newRegPrivacy(); 
	$privacy['title'] = $configPrivacy['title'];
	$privacy['consentText'] = $configPrivacy['reg_form_consent']['line1'];
	$privacy['consentPrompt'] = $configPrivacy['reg_form_consent']['prompt'];
	$privacy['tng_protect_url'] = $configPrivacy['reg_form_consent']['privacyDoc'];
	$privacy['askConsent'] = $configPrivacy['reg_form_consent']['enabled'];
	$privacy['current_user_consent'] = $configPrivacy['current_user_consent'];
	$privacy['current_user_consent_text'] = $configPrivacy['current_user_consent_text'];
	$privacy['showCookie'] = $configPrivacy['show_cookie_text'];
	$privacy['cookieText'] = $configPrivacy['cookieText'];
	$privacy['show_data_protect'] = $configPrivacy['reg_form_consent']['show_privacy_doc_link'];
	//var_dump($configPrivacy);
	return $privacy;
}

//update privacy
function update_privacy() {
	$path = (__DIR__. '/config_privacy.json');
	$configPrivacy = newRegPrivacy(); 
	$config_new = $configPrivacy; 
	if ($_POST['showCookie'] == 'on') {
		$config_new['show_cookie_text'] = true;
	} else {
		$config_new['show_cookie_text'] = false;	
	}
	$config_new['cookieText'] = $_POST['cookieText'];

	if ($_POST['askConsent'] == 'on') {
		$config_new['reg_form_consent']['enabled'] = true;
	} else {
		$config_new['reg_form_consent']['enabled'] = false;	
	}
	$config_new['reg_form_consent']['line1'] = $_POST['consentText'];
	$config_new['reg_form_consent']['prompt'] = $_POST['consentPrompt'];

	if ($_POST['current_user_consent'] == 'on') {
		$config_new['current_user_consent'] = true;
	} else {
		$config_new['current_user_consent'] = false;	
	}
	$config_new['current_user_consent_text'] = $_POST['current_user_consent_text'];

	if ($_POST['show_data_protect'] == 'on') {
		$config_new['reg_form_consent']['show_privacy_doc_link'] = true;
	} else {
		$config_new['reg_form_consent']['show_privacy_doc_link'] = false;	
	}
	$config_new['reg_form_consent']['privacyDoc'] = $_POST['tng_protect_url'];
	
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config_privacy.json');
	file_put_contents($path_json, $json);
	$success = 'Changes Saved';
	return $success;
}

//Read text for Registration Complete
function read_reg_complete() {
	$config = optionsConfig();
	$reg_post['regcomplete_title'] = $config['reg_complete']['title'];
	$reg_post['regcomplete_line1'] = $config['reg_complete']['line1'];
	$reg_post['regcomplete_line2'] = $config['reg_complete']['line2'];
	$reg_post['regcomplete_line3'] = $config['reg_complete']['line3'];
	$reg_post['regcomplete_line4'] = $config['reg_complete']['line4'];
	return $reg_post;
}

//Update text for Registration Complete
function update_reg_complete() {
	$path = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new['reg_complete']['title'] = $_POST['regcomplete_title'];
	$config_new['reg_complete']['line1'] = $_POST['regcomplete_line1'];
	$config_new['reg_complete']['line2'] = $_POST['regcomplete_line2'];
	$config_new['reg_complete']['line3'] = $_POST['regcomplete_line3'];
	$config_new['reg_complete']['line4'] = $_POST['regcomplete_line4'];
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$success = "Reg Changes Saved";
	return $success;
}

//Read text for Email in TNG Only
function read_tng_email() {
	$config = optionsConfig();
	$Tngemail_post['Tngemail_title'] = $config['reg_email_tng_only']['title'];
	$Tngemail_post['Tngemail_line1'] = $config['reg_email_tng_only']['line1'];
	$Tngemail_post['Tngemail_line2'] = $config['reg_email_tng_only']['line2'];
	$Tngemail_post['Tngemail_line3'] = $config['reg_email_tng_only']['line3'];
	$Tngemail_post['Tngemail_line4'] = $config['reg_email_tng_only']['line4'];
	return $Tngemail_post;
}

//Update text for Email in TNG Only
function update_tng_email() {
	$path = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new['reg_email_tng_only']['title'] = $_POST['Tngemail_title'];
	$config_new['reg_email_tng_only']['line1'] = $_POST['Tngemail_line1'];
	$config_new['reg_email_tng_only']['line2'] = $_POST['Tngemail_line2'];
	$config_new['reg_email_tng_only']['line3'] = $_POST['Tngemail_line3'];
	$config_new['reg_email_tng_only']['line4'] = $_POST['Tngemail_line4'];
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$success = "TNG Email Notification Changes Saved";
	return $success;
}


//Read text for Registration Email
function read_reg_email() {
	$config = optionsConfig();
	$email_post['regemail_title'] = $config['new_reg_email']['title'];
	$email_post['regemail_line1'] = $config['new_reg_email']['line1'];
	$email_post['regemail_line2'] = $config['new_reg_email']['line2'];
	$email_post['regemail_line3'] = $config['new_reg_email']['line3'];
	$email_post['regemail_line4'] = $config['new_reg_email']['line4'];
	$email_post['regemail_line5'] = $config['new_reg_email']['line5'];
	return $email_post;
}

//Update text for Registration Email
function update_reg_email() {
	$path = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new['new_reg_email']['title'] = $_POST['regemail_title'];
	$config_new['new_reg_email']['line1'] = $_POST['regemail_line1'];
	$config_new['new_reg_email']['line2'] = $_POST['regemail_line2'];
	$config_new['new_reg_email']['line3'] = $_POST['regemail_line3'];
	$config_new['new_reg_email']['line4'] = $_POST['regemail_line4'];
	$config_new['new_reg_email']['line5'] = $_POST['regemail_line5'];
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$success = "Email Changes Saved";
	return $success;
}

//Read text for 'Suggest Password Reset to New Registration
function read_pw_message() {
	$config = optionsConfig();
	$pw_post['PWreset_title'] = $config['reg_pw_reset']['title'];
	$pw_post['PWreset_line1'] = $config['reg_pw_reset']['line1'];
	$pw_post['PWreset_line2'] = $config['reg_pw_reset']['line2'];
	$pw_post['PWreset_line3'] = $config['reg_pw_reset']['line3'];
	$pw_post['PWreset_line4'] = $config['reg_pw_reset']['line4'];
	return $pw_post;
}

//Update text for 'Suggest Password Reset to New Registration
function update_pw_message() {
	$path = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new['reg_pw_reset']['title'] = $_POST['PWreset_title'];
	$config_new['reg_pw_reset']['line1'] = $_POST['PWreset_line1'];
	$config_new['reg_pw_reset']['line2'] = $_POST['PWreset_line2'];
	$config_new['reg_pw_reset']['line3'] = $_POST['PWreset_line3'];
	$config_new['reg_pw_reset']['line4'] = $_POST['PWreset_line4'];
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$success = "Password Reset Text Saved";
	return $success;
}

//Read text for Password Lost
function read_pwlost_message() {
	$config = optionsConfig();
	$pwLost_post['pwLost_title'] = $config['forgot_pw']['title'];
	$pwLost_post['pwLost_line1'] = $config['forgot_pw']['line1'];
	$pwLost_post['pwLost_line2'] = $config['forgot_pw']['line2'];
	$pwLost_post['pwLost_line3'] = $config['forgot_pw']['line3'];
	$pwLost_post['pwLost_line4'] = $config['forgot_pw']['line4'];
	return $pwLost_post;
}

//Update text for Password Lost
function update_pwlost_message() {
	$path = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new['forgot_pw']['title'] = $_POST['pwLost_title'];
	$config_new['forgot_pw']['line1'] = $_POST['pwLost_line1'];
	$config_new['forgot_pw']['line2'] = $_POST['pwLost_line2'];
	$config_new['forgot_pw']['line3'] = $_POST['pwLost_line3'];
	$config_new['forgot_pw']['line4'] = $_POST['pwLost_line4'];
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$success = "Password Lost Text Saved";
	return $success;
}

//Read text for Password Lost Email
function read_lostPW_email() {
	$config = optionsConfig();
	$emailLost_post['pwemail_title'] = $config['forgot_pw_email']['title'];
	$emailLost_post['pwemail_line1'] = $config['forgot_pw_email']['line1'];
	$emailLost_post['pwemail_line2'] = $config['forgot_pw_email']['line2'];
	$emailLost_post['pwemail_line3'] = $config['forgot_pw_email']['line3'];
	$emailLost_post['pwemail_line4'] = $config['forgot_pw_email']['line4'];
	$emailLost_post['pwemail_line5'] = $config['forgot_pw_email']['line5'];
	$emailLost_post['pwemail_line6'] = $config['forgot_pw_email']['line6'];
	return $emailLost_post;
}

//Update text for Password Lost Email
function update_lostPW_email() {
	$path = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new['forgot_pw_email']['title'] = $_POST['pwemail_title'];
	$config_new['forgot_pw_email']['line1'] = $_POST['pwemail_line1'];
	$config_new['forgot_pw_email']['line2'] = $_POST['pwemail_line2'];
	$config_new['forgot_pw_email']['line3'] = $_POST['pwemail_line3'];
	$config_new['forgot_pw_email']['line4'] = $_POST['pwemail_line4'];
	$config_new['forgot_pw_email']['line5'] = $_POST['pwemail_line5'];
	$config_new['forgot_pw_email']['line6'] = $_POST['pwemail_line6'];
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$success = "Email Changes Saved";
	return $success;
}

//Read text for Reg Form Intro
function read_reg_intro() {
	$config = optionsConfig();
	$intro_post['intro_title'] = $config['reg_form_intro']['title'];
	$intro_post['intro_line1'] = $config['reg_form_intro']['line1'];
	$intro_post['intro_line2'] = $config['reg_form_intro']['line2'];
	$intro_post['intro_line3'] = $config['reg_form_intro']['line3'];
	$intro_post['intro_line4'] = $config['reg_form_intro']['line4'];
	$intro_post['intro_line5'] = $config['reg_form_intro']['line5'];
	$intro_post['enabled'] = $config['reg_form_intro']['enabled'];

	return $intro_post;
}

//Update text for Reg Form Intro
function update_reg_intro() {
	$path = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new['reg_form_intro']['title'] = $_POST['intro_title'];
	$config_new['reg_form_intro']['line1'] = $_POST['intro_line1'];
	$config_new['reg_form_intro']['line2'] = $_POST['intro_line2'];
	$config_new['reg_form_intro']['line3'] = $_POST['intro_line3'];
	$config_new['reg_form_intro']['line4'] = $_POST['intro_line4'];
	$config_new['reg_form_intro']['line5'] = $_POST['intro_line5'];

	if (isset($_POST['enabled'])) {
		$config_new['reg_form_intro']['enabled'] = true;
		} else {
		$config_new['reg_form_intro']['enabled'] = false;
		}

	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$success = "Email Changes Saved";
	return $success;
}