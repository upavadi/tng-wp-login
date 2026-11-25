<?php
require_once "templates/view_profile.html.php";
require_once "showprofile.php";

function profile_complete() {
   if (isset($data['submitProfile'])) {
        update_wp($_POST, $data, $data_meta);
    }
}

if (isset($data))
$display_data = $data['values']->data;
if (isset($display_meta))
$NickName = $display_meta[nickname][0];
function update_wp($post, $data) {
$Id = $data['values']->data->ID;
	global $wpdb;
	$userdata = array(
  	'ID'  => $Id,
	'user_email'   =>  $post['user_email'],
	'display_name'   =>  $post['display_name'],
	'nickname'   =>  $post['nickname'],
	'first_name'   =>  $post['first_name'],
	'last_name'   =>  $post['last_name'],
	'description'   =>  $post['description'],
	'show_admin_bar_front'   =>  false
	);
	if ($post['new_pass']) {
	$newpass = array(
  	'user_pass'  => $post['new_pass']
	);
	$userdata = array_merge($userdata, $newpass);
	}
	wp_update_user($userdata);
	update_user_meta($Id, 'tng_interest', $post['tng_interest']);
	update_tng($post, $data);
	}

function update_tng($post, $data) {
$tngPath = getSubroot(). "config.php";
include ($tngPath);
$password_type = $tngconfig['password_type'];
$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
	}
// Always update the TNG record of the logged-in user. The username used to be
// taken from the submitted form (user_login), which let a member change that
// field and overwrite another member's TNG email and password.
$userName = wp_get_current_user()->user_login;
if ($userName === '') {
	return;
}
$description = $_POST['display_name'];
// Only hash when a new password was entered (this used to run on every save).
$hashed_pass = !empty($_POST['new_pass']) ? tng_wp_login_hash_password($_POST['new_pass'], $password_type) : null;
$notes = $_POST['tng_interest'];;
$realname = $_POST['first_name']. " ". $_POST['last_name'];
$email = $_POST['user_email'];
$tngUserTable = tngUserTable();
if (!empty($_POST['new_pass']) && $hashed_pass === null) {
	echo "<div id='msg'>Your profile was saved, but the TNG password could not be changed (unsupported TNG password type '" . esc_html($password_type) . "').</div>";
}
if (!empty($_POST['new_pass']) && $hashed_pass !== null) {
$stmt = $db->prepare("UPDATE {$tngUserTable} SET description=?, email=?, realname=?, notes=?, password=? WHERE username = ?"); 
$stmt->bind_param("ssssss",$description,$email,$realname,$notes,$hashed_pass,$userName);
//$sql = "UPDATE tng_users SET description='$description', email='$email',  realname='$realname', notes='$notes', password='$hashed_pass' WHERE username='$userName' ";
} else {	
$stmt = $db->prepare("UPDATE {$tngUserTable} SET description=?, email=?, realname=?, notes=? WHERE username = ?"); 
$stmt->bind_param("sssss",$description,$email,$realname,$notes,$userName);
//$sql = "UPDATE tng_users SET description='$description', email='$email',  realname='$realname', notes='$notes' WHERE username='$userName' "; 
}
$success = $stmt->execute();
if ($success === TRUE) {
    echo "<div id='msg_grn'>". "<b>Your changes have been updated</b>"."</div>";
} else {
    echo "<div id='msg'>. Ooops: something went wrong. Please try again " . $db->error;
}
$stmt->close();
}