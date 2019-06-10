<?php
require_once "options_update.php";
require_once "templates_admin/admin_set_paths.php";
require_once "templates_admin/admin_set_keys.php";
require_once "templates_admin/admin_set_profile.php";
require_once "templates_admin/admin_set_registration.php";
require_once "templates_admin/admin_set_reg_messages.php";
require_once "templates_admin/admin_set_pwReset_messages.php";
require_once "templates_admin/admin_set_login_text.php";
add_action('admin_menu', 'plugin_admin_add_page');

//add_action('admin_init', 'plugin_admin_add_page');
//6LdACicUAAAAAJwHZ194fiKcwhxiX4EHbmttcTCq

function optionsConfig() {
	static $config;
	
	if (!$config) {
		$url = plugin_dir_url( __FILE__ ). "config.json";
		$config = json_decode(file_get_contents($url), true);
	}
	return $config;
}

function optionsKeys() {
	static $key_value;
	if (!$key_value) {
		$key_url = plugin_dir_url( __FILE__ ). "keyValue.json";
		$key_value = json_decode(file_get_contents($key_url), true);
	}
	return $key_value;
}


function plugin_admin_add_page() {
	add_menu_page(
	'WP-TNG Login Config',
	'WP-TNG Login',
	'manage_options',
	'wp-tng-login',
	'set_plugin_paths'
	);
	add_submenu_page(
    'wp-tng-login',
	'WP-TNG Login Config',
	'Plugin Paths',
	'manage_options',
	'wp-tng-login',
	'set_plugin_paths'
	);
	add_submenu_page(
		'wp-tng-login',
		'WP-TNG Login Config',
		'LogIn Text',
		'manage_options',
		'wp-tng-login-text',
		'set_plugin_login_messages'
	);
	add_submenu_page(
		'wp-tng-login',
		'WP-TNG Login Config',
		'Captcha Keys',
		'manage_options',
		'wp-tng-keys',
		'set_plugin_keys'
		);
	add_submenu_page(
    'wp-tng-login',
	'WP-TNG Login Config',
	'Profile Page',
	'manage_options',
	'wp-tng-profile',
	'set_plugin_profile'
	);

	add_submenu_page(
    'wp-tng-login',
	'wp-tng Login',
	'Registration Page',
	'manage_options',
	'wp-tng-registration',
	'set_plugin_registration'
    );	
	add_submenu_page(
    'wp-tng-login',
	'wp-tng Login',
	'Registration Messages',
	'manage_options',
	'wp-tng-reg_msg',
	'set_plugin_reg_messages'
	);
	add_submenu_page(
		'wp-tng-login',
		'wp-tng Login',
		'Password-Reset Messages',
		'manage_options',
		'wp-tng-pw_msg',
		'set_plugin_pwreset_messages'
		);
	
}