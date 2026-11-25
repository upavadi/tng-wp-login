<?php
require_once "newreg_config.php"; 
require_once "templates/view_profile.html.php";
require_once "updateprofile.php";
/** This function drives shortcode [user_profile] ***/
function show_profile() {
	// Logged-out visitors get a login link instead of an empty profile form.
	if (!is_user_logged_in()) {
		return '<p>Please <a href="' . esc_url(home_url('/login/')) . '">log in</a> to view and edit your profile.</p>';
	}
	$configPath = getSubroot() . "config.php";
	include ($configPath); //require_once stopped working
	$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
		if ($db->connect_error) {
			die("Connection failed: " . $db->connect_error);
		}
	//$inputProfile = $_POST;
	$wp_currentuser = (get_currentuser());
	$wp_currentuser_meta = (get_currentuser_meta());
	$profile_user = $wp_currentuser;
	$profile_meta = $wp_currentuser_meta;
	$config = newRegConfig();
	$data['values'] = $wp_currentuser;
	$data_meta['values']= $wp_currentuser_meta;
	$def_photo_path = get_tng_default_photo($db);
	$data['errors'] = validate_profile($_POST);
	
	if (empty($data['errors']) && isset($_POST['submitProfile']))  {
		// CSRF protection: only accept profile changes submitted from this site's own form.
		if ( ! isset( $_POST['_tng_wp_login_profile_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_tng_wp_login_profile_nonce'] ) ), 'tng_wp_login_profile' ) ) {
			wp_die( esc_html__( 'Your session has expired. Please reload the page and try again.' ) );
		}
		$post = $_POST;
		update_wp($post, $data);
		
		}
	$data3 = (array_merge($data, $data_meta));
	echo view_profile($data, $data_meta, $def_photo_path, $config['show_profile']);
	//profile_complete($_POST, $data, $data_meta);
	//var_dump($data);
}

function get_currentuser() {
	$current_user = wp_get_current_user();
	return ($current_user);
}
function get_currentuser_meta() {
	$current_ID = get_current_user_id();
	$currentuser_meta = get_user_meta($current_ID);
	return ($currentuser_meta);
}
$wp_user = get_currentuser();
function get_tng_user($db) {
	$tng_name = (get_currentuser()->user_login);
	$tngUserTable = tngUserTable();
	// Prepared statement: never build SQL from user-controlled values.
	$stmt = $db->prepare("SELECT * FROM {$tngUserTable} WHERE username = ?");
	$stmt->bind_param('s', $tng_name);
	$stmt->execute();
	$result = $stmt->get_result();	
	if ($result) {
		$row = $result->fetch_assoc();
		$tng_username = $row["username"];
	}
	return $row;
}

function get_tng_default_photo($db) {
	$tng_user = get_tng_user($db);
	$personID = $tng_user['personID'];
	$tngMediaLinksTable = medialinks_table();
	// Prepared statement: never build SQL from user-controlled values.
	$stmt = $db->prepare("SELECT * FROM {$tngMediaLinksTable} WHERE personID = ? AND defphoto=1");
	$stmt->bind_param('s', $personID);
	$stmt->execute();
	$result = $stmt->get_result();	
	if ($result) {
		$row = $result->fetch_assoc();
		$tng_defaultphotoID = $row["mediaID"];
	}
	$tngMedia = mediaTable();
	// Prepared statement: never build SQL from user-controlled values.
	$stmt = $db->prepare("SELECT thumbpath FROM {$tngMedia} WHERE mediaID = ?");
	$stmt->bind_param('s', $tng_defaultphotoID);
	$stmt->execute();
	$result = $stmt->get_result();	
	if ($result) {
		$row = $result->fetch_assoc();
		$tng_defaultphoto_path = $row["thumbpath"];
	}
	return $tng_defaultphoto_path;
}
	
function validate_profile($form) {
	$errors = array();
	
	if (isset($_POST['submitProfile'])) {
	if (empty($form['first_name'])) {
		$errors['first_name'] = 'Cannot be empty';
	}
	
	if (empty($form['last_name'])) {
		$errors['last_name'] = 'Cannot be empty';
	}
	
	
	if (empty($form['user_email'])) {
		$errors['user_email'] = 'Cannot be empty';
	}
	if (!is_email($form['user_email'])) {
		$errors['user_email'] = 'email not valid';
	}
	
		if (strlen($form['new_pass']) > 0 && strlen($form['new_pass']) < 8 ) {
		$errors['new_pass'] = 'New Password must be atleast 8 characters';
		}
	}	
		return $errors;
}