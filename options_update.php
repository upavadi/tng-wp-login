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
function update_profile() {
	$config = optionsConfig();
	$config_new = $config;
	$section1 = $config_new['show_profile']['sections'][0];
	$config_new['show_profile']['sections'][0];
	($config_new['show_profile']['sections'][0]);
var_dump($_POST);
	/****headers 1 ****/
	$config_new['show_profile']['sections'][0]['label'] = $_POST[header1];
	
	$config_new['show_profile']['sections'][0]['fields'][0]['label'] = $_POST['label1a'];
	$config_new['show_profile']['sections'][0]['fields'][0]['description'] = $_POST['description1a'];
	$config_new['show_profile']['sections'][0]['fields'][0]['placeholder'] = $_POST['placeholder1a'];
	
	$config_new['show_profile']['sections'][0]['fields'][1]['label'] = $_POST[label1b];
	$config_new['show_profile']['sections'][0]['fields'][1]['description'] = $_POST['description1b'];
	$config_new['show_profile']['sections'][0]['fields'][1]['placeholder'] = $_POST['placeholder1b'];
	
	$config_new['show_profile']['sections'][0]['fields'][2]['label'] = $_POST[label1c];
	$config_new['show_profile']['sections'][0]['fields'][2]['description'] = $_POST['description1c'];
	$config_new['show_profile']['sections'][0]['fields'][2]['placeholder'] = $_POST['placeholder1c'];
	
	$config_new['show_profile']['sections'][0]['fields'][3]['label'] = $_POST[label1d];
	$config_new['show_profile']['sections'][0]['fields'][3]['description'] = $_POST['description1d'];
	$config_new['show_profile']['sections'][0]['fields'][3]['placeholder'] = $_POST['placeholder1d'];
	
	/****headers 2 ****/
	$config_new['show_profile']['sections'][1]['label'] = $_POST[header2];
	
	$config_new['show_profile']['sections'][1]['fields'][0]['label'] = $_POST[label2a];
	$config_new['show_profile']['sections'][1]['fields'][0]['description'] = $_POST['description2a'];
	$config_new['show_profile']['sections'][1]['fields'][0]['placeholder'] = $_POST['placeholder2a'];
	
	$config_new['show_profile']['sections'][1]['fields'][1]['label'] = $_POST[label2b];
	$config_new['show_profile']['sections'][1]['fields'][1]['description'] = $_POST['description2b'];
	$config_new['show_profile']['sections'][1]['fields'][1]['placeholder'] = $_POST['placeholder2b'];
	$config_new['show_profile']['sections'][1]['fields'][2]['label'] = $_POST[label2c];
	$config_new['show_profile']['sections'][1]['fields'][2]['description'] = $_POST['description2c'];
	$config_new['show_profile']['sections'][1]['fields'][2]['placeholder'] = $_POST['placeholder2c'];
	$config_new['show_profile']['sections'][1]['fields'][3]['label'] = $_POST[label2d];
	$config_new['show_profile']['sections'][1]['fields'][3]['description'] = $_POST['description2d'];
	$config_new['show_profile']['sections'][1]['fields'][3]['placeholder'] = $_POST['placeholder2d'];
	
	/****headers 3 ****/
	$config_new['show_profile']['sections'][2]['label'] = $_POST[header3];
	
	$config_new['show_profile']['sections'][2]['fields'][0]['label'] = $_POST['label3a'];
	$config_new['show_profile']['sections'][2]['fields'][0]['description'] = $_POST['description3a'];
	$config_new['show_profile']['sections'][2]['fields'][0]['placeholder'] = $_POST['placeholder3a'];
	if (isset($_POST['enabled3a'])) {
	$config_new['show_profile']['sections'][2]['fields'][0]['enabled'] = true;
	} else {
	$config_new['show_profile']['sections'][2]['fields'][0]['enabled'] = false;
	}
	
	$config_new['show_profile']['sections'][2]['fields'][1]['label'] = $_POST[label3b];
	$config_new['show_profile']['sections'][2]['fields'][1]['description'] = $_POST['description3b'];
	$config_new['show_profile']['sections'][2]['fields'][1]['placeholder'] = $_POST['placeholder3b'];
	if (isset($_POST['enabled3b'])) {
	$config_new['show_profile']['sections'][2]['fields'][1]['enabled'] = true;
	} else {
	$config_new['show_profile']['sections'][2]['fields'][1]['enabled'] = false;
	}
	var_dump($config_new['show_profile']['sections'][0]);
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$success = 'Changes Saved';
	return $success;
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
	$config_new['reg_form']['sections'][0]['label'] = $_POST[header1];
	
	$config_new['reg_form']['sections'][0]['fields'][0]['label'] = $_POST[label1a];
	$config_new['reg_form']['sections'][0]['fields'][0]['description'] = $_POST[description1a];
	$config_new['reg_form']['sections'][0]['fields'][0]['placeholder'] = $_POST[placeholder1a];
	if (isset($_POST['enabled1a'])) {
	$config_new['reg_form']['sections'][0]['fields'][0]['enabled'] = true;
	} else {
	$config_new['reg_form']['sections'][0]['fields'][0]['enabled'] = false;
	}
	
	$config_new['reg_form']['sections'][0]['fields'][1]['label'] = $_POST[label1b];
	$config_new['reg_form']['sections'][0]['fields'][1]['description'] = $_POST[description1b];
	$config_new['reg_form']['sections'][0]['fields'][1]['placeholder'] = $_POST[placeholder1b];
	if (isset($_POST['enabled1b'])) {
	$config_new['reg_form']['sections'][0]['fields'][1]['enabled'] = true;
	} else {
	$config_new['reg_form']['sections'][0]['fields'][1]['enabled'] = false;
	}
	
	$config_new['reg_form']['sections'][0]['fields'][2]['label'] = $_POST[label1c];
	$config_new['reg_form']['sections'][0]['fields'][2]['description'] = $_POST[description1c];
	$config_new['reg_form']['sections'][0]['fields'][2]['placeholder'] = $_POST[placeholder1c];
	if (isset($_POST['enabled1c'])) {
	$config_new['reg_form']['sections'][0]['fields'][2]['enabled'] = true;
	} else {
	$config_new['reg_form']['sections'][0]['fields'][2]['enabled'] = false;
	}
	
	/****headers 2 ****/
	$config_new['reg_form']['sections'][1]['label'] = $_POST[header2];
	$config_new['reg_form']['sections'][1]['fields'][0]['label'] = $_POST[label2a];
	$config_new['reg_form']['sections'][1]['fields'][0]['description'] = $_POST[description2a];
	$config_new['reg_form']['sections'][1]['fields'][0]['placeholder'] = $_POST[placeholder2a];
	
	$config_new['reg_form']['sections'][1]['fields'][1]['label'] = $_POST[label2b];
	$config_new['reg_form']['sections'][1]['fields'][1]['description'] = $_POST[description2b];
	$config_new['reg_form']['sections'][1]['fields'][1]['placeholder'] = $_POST[placeholder2b];
	
	$config_new['reg_form']['sections'][1]['fields'][2]['label'] = $_POST[label2c];
	$config_new['reg_form']['sections'][1]['fields'][2]['description'] = $_POST[description2c];
	$config_new['reg_form']['sections'][1]['fields'][2]['placeholder'] = $_POST[placeholder2c];
	/**
	$config_new['reg_form']['sections'][1]['fields'][3]['label'] = $_POST[label2d];
	$config_new['reg_form']['sections'][1]['fields'][3]['description'] = $_POST[description2d];
	$config_new['reg_form']['sections'][1]['fields'][3]['placeholder'] = $_POST[placeholder2d];
	**
	/****headers 3 ****/
	$config_new['reg_form']['sections'][2]['label'] = $_POST[header3];
	
	$config_new['reg_form']['sections'][2]['fields'][0]['label'] = $_POST[label3a];
	$config_new['reg_form']['sections'][2]['fields'][0]['description'] = $_POST[description3a];
	$config_new['reg_form']['sections'][2]['fields'][0]['placeholder'] = $_POST[placeholder3a];
	if (isset($_POST['enabled3a'])) {
	$config_new['reg_form']['sections'][2]['fields'][0]['enabled'] = true;
	} else {
	$config_new['reg_form']['sections'][2]['fields'][0]['enabled'] = false;
	}
	
	$config_new['reg_form']['sections'][2]['fields'][1]['label'] = $_POST[label3b];
	$config_new['reg_form']['sections'][2]['fields'][1]['description'] = $_POST[description3b];
	$config_new['reg_form']['sections'][2]['fields'][1]['placeholder'] = $_POST[placeholder3b];
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

//Update text for Registration Email
function update_reg_email() {
	$path = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new['new_reg_email']['title'] = $_POST['regemail_title'];
	$config_new['new_reg_email']['CC'] = $_POST['regemail_cc'];
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

function update_pwlost_message() {
	$path = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new['forgot_pw']['title'] = $_POST['PWreset_title'];
	$config_new['forgot_pw']['line1'] = $_POST['PWreset_line1'];
	$config_new['forgot_pw']['line2'] = $_POST['PWreset_line2'];
	$config_new['forgot_pw']['line3'] = $_POST['PWreset_line3'];
	$config_new['forgot_pw']['line4'] = $_POST['PWreset_line4'];
	$json = (json_encode($config_new, JSON_PRETTY_PRINT));
	$path_json = (__DIR__. '/config.json');
	file_put_contents($path_json, $json);
	$success = "Password Reset Text Saved";
	return $success;
}

//Update text for Registration Email
function update_lostPW_email() {
	$path = (__DIR__. '/config.json');
	$config = optionsConfig();
	$config_new = $config;
	$config_new['forgot_pw_email']['title'] = $_POST['pwemail_title'];
	$config_new['forgot_pw_email']['CC'] = $_POST['pwemail_cc'];
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