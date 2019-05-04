<?php
require_once "options_update.php";
require_once "templates_admin/admin_set_paths.php";
require_once "templates_admin/admin_set_profile.php";
require_once "templates_admin/admin_set_registration.php";
require_once "templates_admin/admin_set_reg_messages.php";
add_action('admin_menu', 'plugin_admin_add_page');
//add_action('admin_init', 'plugin_admin_add_page');

function optionsConfig() {
	static $config;
	
	if (!$config) {
		$url = plugin_dir_url( __FILE__ ). "config.json";
		$config = json_decode(file_get_contents($url), true);
	}
	return $config;
}

/**
    add_menu_page('My Page Title', 'My Menu Title', 'manage_options', 'my-menu', 'my_menu_output' );
    add_submenu_page('my-menu', 'Submenu Page Title', 'Whatever You Want', 'manage_options', 'my-menu' );
    add_submenu_page('my-menu', 'Submenu Page Title2', 'Whatever You Want2', 'manage_options', 'my-menu2' );
**/

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
}