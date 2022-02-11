<?php
// function getTngPrefix() {
// 	//get tng table prefix
// 	$config = newRegConfig();
// 	$tngPrefix = $config['paths']['tng_db_prefix'];
// 	$tngPrefix = str_replace(' ', '', $tngPrefix);
// 	return $tngPrefix;
// }
/*** Initialize ***/
function getSubroot() {
	//alternative place for configuration files
	$tngPath = getTngPath(); 
	if ((!$tngPath)) return;
	$subroot_path = getTngPath(). "subroot.php"; 
	include($subroot_path);
	$subrootPath = $tngconfig['subroot'];
	if ($subrootPath) return $subrootPath;
	$tngPath = getTngPath();
	return $tngPath;
}

function getTngPath() {
	static $config, $tngPath;
	$config = newRegConfig();
	if($config) $tngPath = $config['paths']['tng_path'];
	if ((!$tngPath)) return;
	$tngPath = preg_replace('/\\\\\"/',"\"", $tngPath); // this is for php 5.3 to remove escape characters.
	$tngPath = realpath($tngPath); 
	if (!$tngPath) {
	   // Show an error and die
	   //error_log("TNG path is not real");
	   return null;
	}
	return $tngPath . DIRECTORY_SEPARATOR;
}

function newRegConfig() {
	static $config;
	
	if (!$config) {
		$url = __DIR__ . "/config.json";
		$config = json_decode(file_get_contents($url), true);
	}
	return $config;
}


function find_wp_path() {
	$dir = dirname(__FILE__);
	do {
		if( file_exists($dir."/wp-config.php") ) {
			return $dir;
		}
	} while( $dir = realpath("$dir/..") );
	return null;
}

function newRegPrivacy() {
	static $configPrivacy;
	
	if (!$configPrivacy) {
		$url = __DIR__ . "/config_privacy.json";
		$configPrivacy = json_decode(file_get_contents($url), true);
	}
	return $configPrivacy;
}

function tngUserTable() {
	$tngPath = getSubroot(). "config.php";
	if (file_exists($tngPath)) {
		include $tngPath;
		$tngUserTable = $users_table;
	}
	return $tngUserTable ;
}

function medialinks_table() {
	$tngPath = getSubroot(). "config.php";
	if (file_exists($tngPath)) {
		include $tngPath;
		$tngMediaLinksTable = $medialinks_table;
	}
	return $tngMediaLinksTable; 
}

function mediaTable() {
	$tngPath = getSubroot(). "config.php";
	if (file_exists($tngPath)) {
		include $tngPath;
		$tngMediaTable = $media_table;
	}
	return $tngMediaTable; 
}

function tngImageTagTable() {
	$tngPath = getSubroot(). "config.php";
	if (file_exists($tngPath)) {
		include $tngPath;
		$tng_image_tag_table = $image_tags_table;
	}
	return $tng_image_tag_table;
}



function getTngUserName($wp_user) {
	$wp_user = wp_get_current_user() -> user_login;
	$tngPath = getSubroot(). "config.php";
	$config = newRegConfig();
	if (!file_exists($tngPath)) {
		return;
	}
	include ($tngPath); // NEED TO USE __dir__!!!
	
	$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	$tngUserName = tngUserTable();
	$sql = "SELECT username FROM {$tngUserName} WHERE username='$wp_user'";
	$result = $db->query($sql);
	if ($result) {
		$row = $result->fetch_assoc();
		$tng_loginname = $row["username"];
	}
	
	return $tng_loginname;
}

function roleTng() {
	//does user name in tng exist
	$tngPath = getTngPath();
	if ((!$tngPath)) return;
	global $tng_name_check;
	$tng_user_name = wp_get_current_user() -> user_login;;
	$tng_path = getSubroot(). "config.php";
	include ($tng_path); 
	$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	$tng_user_table = tngUserTable();
	$sql = "SELECT * FROM {$tng_user_table} WHERE username='$tng_user_name'";
	$result = $db->query($sql);
	if ($result) {
		$row = $result->fetch_assoc();
		$tng_user_role = $row["role"];
	return $tng_user_role;
	}
	return false;
}

function guessTngVersion() {
	static $languageID, $dt_consented, $allow_private_notes;
	$tngPath = getTngPath();
	if ((!$tngPath)) return;
	$tng_path = getSubroot(). "config.php";
	include($tng_path);
	$tng_user_table = tngUserTable();
	$tng_image_tags = tngImageTagTable();
	$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
	$sql = "SELECT * FROM {$tng_user_table} ";
	$result = $db->query($sql);
	$sql2 = "SELECT * FROM {$tng_image_tags} ";
	$result2 = $db->query($sql2);
	$version = 10;
	$row = $result->fetch_assoc();
	
	if (isset($row['languageID'])) {
		$languageID = True;
		$version = 11;
	}
	
	if (isset($row['dt_consented'])) {
		$dt_consented = TRUE;
		$version = 12;
	}
	
	if (isset ($result2)) {
		 $media_tags = TRUE;
		$version = 13;
	}	 

	if (isset($row['allow_private_notes'])) {
		$allow_private_notes = TRUE;
			$version = 13.1;
		}

return $version;
}

function is_logged_in(){
	$currentUser = wp_get_current_user();
	   return $currentUser;
   
}

function checkForTngPathInit() {
	$wp_tng_path = $_POST['wp_tng_path']. 'config.php'; 
	//$tngFileError = "";
	if (!file_exists($wp_tng_path) || !is_readable($wp_tng_path)) {	
		return array(true, "", "","","");
	} else {
	include($wp_tng_path);
	return array(false, $rootpath, $tngdomain, $photopath);
	}
}

function checkTablesInit() {
	$wp_tng_path = $_POST['wp_tng_path']. 'config.php'; 
	//$tngFileError = "";
		include ($wp_tng_path);
		if($users_table && $media_table && $medialinks_table) {
		return array(true, $users_table, $media_table, $medialinks_table);
	}	
	return array(false, "", "","","");
}

/*** Profile ***/
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

function getTng_photo_folder() {
	$config = newRegConfig();
	$tngPhotos = $config['paths']['tng_photo_folder'];
	return $tngPhotos;
}

