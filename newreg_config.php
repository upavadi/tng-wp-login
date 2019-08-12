<?php
/*
* JSON file used is config.json.
* Sections: "label": Title for each section
* Fields: "name": Name of the field,
*	"enabled": true to display false to hide
*	"textenabled": true for text area else false ,
*	"type": "text",
*	"label": "Label for field",
*	"description": "Field Description",
*	"placeholder": "Text inside the field"
*
*/

function is_logged_in(){
     $currentUser = wp_get_current_user();
		return $currentUser;
    
}
function keyValues() {
	static $key_value;
	if (!$key_value) {
		$key_url =  __DIR__ . "/keyValue.json";
		$key_value = json_decode(file_get_contents($key_url), true);
	}
	return $key_value;
}

function newRegConfig() {
	static $config;
	
	if (!$config) {
		$url = __DIR__ . "/config.json";
		$config = json_decode(file_get_contents($url), true);
	}
	return $config;
}

function getTng_photo_folder() {
	$config = newRegConfig();
	$tngPhotos = $config['paths']['tng_photo_folder'];
	return $tngPhotos;
}
function getTngUrl() {
	$config = newRegConfig();
	$tngUrl = $config['paths']['tng_url'];
	$tngUrl = preg_replace('/\\\\\"/',"\"", $tngUrl); // this is for php 5.3 to remove escape characters.
	if (!$tngUrl) {
	   // Show an error and die
	   echo "TNG url is not configured";
	   die;
	}
	return $tngUrl . DIRECTORY_SEPARATOR;
}

function getTngPath() {
	$config = newRegConfig();
	$tngPath = $config['paths']['tng_path'];
	$tngPath = preg_replace('/\\\\\"/',"\"", $tngPath); // this is for php 5.3 to remove escape characters.
	// if (!$tngPath) {
	//    // Show an error and die
	//    echo "TNG path is not configured";
	//    die;
	// }
	$tngPath = realpath($tngPath);
	if (!$tngPath) {
	   // Show an error and die
	   error_log("TNG path is not real");
	   return null;
	}
	return $tngPath . DIRECTORY_SEPARATOR;
}

function nameTng() {
	//does user name in tng exist
	$tng_name_check = ($_POST['loginname']);
	$tng_path = getTngPath(). "config.php";
	include ($tng_path); 
	$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	$sql = "SELECT * FROM tng_users WHERE username='$tng_name_check'";
	$result = $db->query($sql);
	if ($result) {
		$row = $result->fetch_assoc();
		$tng_username = $row["username"];
	return $row;
	}
	return false;
}

function emailTng() {
	$tng_email_check = ($_POST['email']);
	//does email in tng exist
	$tngPath = getTngPath(). '/config.php';
	include ($tngPath); 
	$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	$sql = "SELECT * FROM tng_users WHERE email='$tng_email_check'";
	$result = $db->query($sql);
	if ($result) {
		$row = $result->fetch_assoc();
		$tng_email = $row['email'];
		return $row;
	}
	return false;
}

/*** for login-to-tng ***/
function getTngUserName($wp_user) {
	$wp_user = wp_get_current_user() -> user_login;
	$tngPath = getTngPath(). "config.php";
	$config = newRegConfig();
	if (!file_exists($tngPath)) {
		return;
	}
	include ($tngPath); // NEED TO USE __dir__!!!
	
		$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	$sql = "SELECT username FROM tng_users WHERE username='$wp_user'";
	$result = $db->query($sql);
	if ($result) {
		$row = $result->fetch_assoc();
		$tng_loginname = $row["username"];
	}
	
return $tng_loginname;
}