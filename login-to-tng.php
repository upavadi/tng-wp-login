<?php

/** log in to tng if user exists and if logged in to Wordpress ***/
$wp_path = find_wp_path(); // not sure why I have to find this
require_once ($wp_path.'/wp-load.php');
require_once "newreg_config.php";
require_once "login-to-wp.php";
//require_once("templates/lost_pw.html.php");

add_action('init', 'StartSession', 1);
add_action( 'wp_login', 'destroy_session' );
add_action( 'wp_logout', 'destroy_session' );


function StartSession() {
   
    //check to see if tng path is specified
    $tngPath = getTngPath(). 'config.php';
    if (!file_exists($tngPath)) return;

    //Check if current user is logged in WordPress
    if( is_user_logged_in() ) {
        if(!session_id()) {
            session_start();
        }

	   mutng_login();
	   if ($_COOKIE['tnguser_rememberme'] === 'forever') {
		set_cookie();
	   }
	   return;        
         
    }
	if ($_SESSION['logged_in']) {
		mutng_logout();
	}
    return;
}

//get real path to wp-load.php
function find_wp_path() {
	$dir = dirname(__FILE__);
	do {
		if( file_exists($dir."/wp-config.php") ) {
			return $dir;
		}
	} while( $dir = realpath("$dir/..") );
	return null;
}

$args['id_username'] = $_POST['log'];
$args['id_password'] = $_POST['pwd'];
$args['redirect'] = $_POST['redirect_to'];
$args['rememberme'] = $_POST['rememberme'];

if ($_POST['log']) {
	setcookie('tnguser_rememberme', $args['rememberme'], 0,  '/', "", false, true);
	require_once ($wp_path. '/wp-login.php');// need actual url
}

if ($_POST['redirect_to'] && (!$_POST['log'] || !$_POST['pwd'])) {
	header('Location: ' . $_POST['redirect_to']);
	exit;
}

function mutng_login() {
    global $current_user, $rootpath, $users_table, $args;
	$currentuser = wp_get_current_user() -> user_login;
    $tng_user_name = getTngUserName($tng_loginname);
    
    $tng_folder = getTngPath();
	if (!file_exists($tng_folder)) {
		return;
	}
    include($tng_folder.'config.php');
    //include($tng_folder."subroot.php");
    $session_language = $_SESSION['session_language'];
    $session_charset = $_SESSION['session_charset'];
    $username = $tng_user_name;
    $row = mutng_db_connect();
    $newroot = preg_replace( "~/~", "", $rootpath );
	$newroot = preg_replace( "~/~", "", $newroot );
    $newroot = preg_replace( "~/.~", "", $newroot );

    $logged_in = $_SESSION['logged_in'] = 1;
    $allow_edit = $_SESSION['allow_edit'] = ($row['allow_edit'] == 1 ? 1 : 0);
    $allow_add = $_SESSION['allow_add'] = ($row['allow_add'] == 1 ? 1 : 0);
    $allow_admin = $row['allow_edit'] || $row['allow_add'] || $row['allow_delete'] ? 1 : 0;
	$tentative_edit = $_SESSION['tentative_edit'] = $row['tentative_edit'];
	$allow_delete = $_SESSION['allow_delete'] = ($row['allow_delete'] == 1 ? 1 : 0);
	$allow_media_edit = $_SESSION['allow_media_edit'] = ($row['allow_edit'] ? 1 : 0);
	$allow_media_add = $_SESSION['allow_media_add'] = ($row['allow_add'] ? 1 : 0);
	$allow_media_delete = $_SESSION['allow_media_delete'] = ($row['allow_delete'] ? 1 : 0);
	$_SESSION['mygedcom'] = $row['mygedcom'];
    $_SESSION['mypersonID'] = $row['personID'];
    $_SESSION['allow_admin'] = $allow_admin;
	$allow_living = $_SESSION['allow_living'] = $row['allow_living'];
	$allow_private = $_SESSION['allow_private'] = $row['allow_private'];
	$allow_ged = $_SESSION['allow_ged'] = $row['allow_ged'];
	$allow_pdf = $_SESSION['allow_pdf'] = $row['allow_pdf'];
    $allow_profile = $_SESSION['allow_profile'] = $row['allow_profile'];
    $allow_lds = $_SESSION['allow_lds'] = $row['allow_lds'];
	$assignedtree = $_SESSION['assignedtree'] = $row['gedcom'];
	$assignedbranch = $_SESSION['assignedbranch'] = $row['branch'];
	$currentuser = $_SESSION['currentuser'] = $row['username'];
	$currentuserdesc = $_SESSION['currentuserdesc'] = $row['description'];
    $session_rp = $_SESSION['session_rp'] = $rootpath;
    $tngrole = $_SESSION['tngrole'] = $row['role'];
    $newdate = mutng_db_update(); //check this !!
    return;
       
}

function mutng_db_connect() {
    $tng_folder = getTngPath();
	if (!file_exists($tng_folder)) {
		return;
	}
    $currentuser = wp_get_current_user() -> user_login;
    $newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );  
    include($tng_folder.'/config.php');
    include($tng_folder.'/customconfig.php');
    $db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
	$sql = "SELECT * FROM tng_users WHERE username='$currentuser'";
    
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    return $row;	
}

function mutng_db_update() { 
    $tng_folder = getTngPath();
    $newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );   
    $currentuser = wp_get_current_user() -> user_login;
    include($tng_folder.'/config.php');
    include($tng_folder.'/customconfig.php');
    $db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
    $sql = "SELECT * FROM tng_users WHERE username='$currentuser'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $userID = $row['userID'];
    $sql = "UPDATE tng_users SET lastlogin=\"$newdate\" WHERE userID=\"{$row['userID']}\"";
    $result = $db->query($sql) or die ("{$admtext['cannotexecutequery']}: {$query}");
    return $row['userID'];
}


function destroy_session() {
   session_destroy();
  // session_start();
return;
}
function reset_cookie() {
    global $rootpath;
    //$_SESSION['reset_cookie'] = 'start';
   // $_SESSION['set_cookie'] = '';
    $row = mutng_db_connect();
    $newroot = preg_replace( "~/~", "", $rootpath );
	$newroot = preg_replace( "~/~", "", $newroot );
    $newroot = preg_replace( "~/.~", "", $newroot );
	
    setcookie("tnguser_$newroot", "", time()+31536000, "/", "", false, true);
    setcookie("tngpass_$newroot", "", time()-31536000, "/", "",  false, true);
    setcookie("tngloggedin_$newroot", "", time()-31536000, "/", "",  false, true); 
    return;
}

function set_cookie() {
	global $rootpath;
    //$_SESSION['set_cookie'] = 'start';
   // $_SESSION['reset_cookie'] = '';
    $row = mutng_db_connect();
    $newroot = preg_replace( "~/~", "", $rootpath );
	$newroot = preg_replace( "~/~", "", $newroot );
    $newroot = preg_replace( "~/.~", "", $newroot );
    
   /** adding to avoide headers sent */
    $tnguser_newroot = ("tnguser_".$newroot);
    if ($_COOKIE[$tnguser_newroot]) return;
    /** adding to avoide headers sent */
    setcookie("tnguser_$newroot", $row['username'], time()+31536000, "/", "",  false, true);
    setcookie("tngpass_$newroot", $row['password'], time()+31536000, "/", "",  false, true);
    setcookie("tngpasstype_$newroot", $row['password_type'], time()+31536000, "/", "", false, true);
    $allow_admin = $row['allow_edit'] || $row['allow_add'] || $row['allow_delete'] ? 1 : 0;
    if($allow_admin) setcookie("tngloggedin_$newroot", "1", 0, "/");
    return;
}


function mutng_logout() {
    reset_cookie();
    session_start();
    $session_language = $_SESSION['session_language'];
    $session_charset = $_SESSION['session_charset'];
     
    $_SESSION['currentuser'] = '';
    $_SESSION['currentuserdesc'] = '';
    $_SESSION['mygedcom'] = '';
    $_SESSION['mypersonID'] = '';
    $_SESSION['assignedtree'] = '';
    $_SESSION['tngrole'] = 'guest';
    $_SESSION['allow_admin'] = 0;
    $_SESSION['allow_edit'] = 0;
    $_SESSION['allow_add'] = 0;
    $_SESSION['tentative_edit'] = 0;
    $_SESSION['allow_delete'] = 0;
    $_SESSION['allow_media_edit'] = 0;
    $_SESSION['allow_media_add'] = 0;
    $_SESSION['allow_media_delete'] = 0;
    $_SESSION['allow_living'] = 0;
    $_SESSION['allow_private'] = i0;
    $_SESSION['allow_ged'] = 0;
    $_SESSION['allow_pdf'] = 0;
    $_SESSION['allow_lds'] = 0;
    $_SESSION['allow_profile'] = 0;
    $_SESSION['logged_in'] = 0;
    return $_SESSION;
    }
    