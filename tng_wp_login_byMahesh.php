<?php
/*
Plugin Name: TNG-Wordpress-login for TNG 9-13 - Login Only
Plugin URI: https://github.com/upavadi/tng-wp-login
Description: Login to TNG with Wordpress, GDPR complient, allow new registrations, edit user profile and Retrieve password. Will work with TNG tables with prefixes.
Version:     3.1.1 Beta Log-In only
Author:      Mahesh Upadhyaya
Author URI:  http://trial.upavadi.net
License:     MIT
License URI: http://opensource.org/licenses/MIT
*************************************************************
* 'Password Reset' module based on tutorial, 
* Build a Custom WordPress User Flow � Part 3, by Jarkko Laine.
* https://code.tutsplus.com/tutorials/build-a-custom-wordpress-user-flow-part-3-password-reset--cms-23811
***********************************************************
* php 5.4 or higher
**/
static $tngPath, $config_paths, $tng_path, $token;
require_once(ABSPATH. 'wp-load.php');
require_once(ABSPATH . 'wp-includes/pluggable.php'); 
require_once 'newreg_config.php';
require_once 'login-to-wp.php';
require_once 'login-to-tng.php';
//Get JSON values
$token == False;
$tngPath = getSubroot(). 'config.php';
$config = newRegConfig();
if ($config) {
$config_paths = ($config['paths']);
$token = $config_paths['tng_success_token'];
}
if (!file_exists($tngPath) OR ($token == False) ) {
add_action( 'admin_notices', 'tng_path_not_specified' ); 
}

function tng_path_not_specified() {
	static $success, $tngPromt, $urlPromt, $photoPromt, $disabled;
	//global $wpdb;
	//$tng_path = getSubroot(). "config.php";
	$tngPromt = "";
	$urlPromt = "";
	$photoPromt = "";
	$FindTngFolder = "Find TNG Folder";
	$userPromt = "";
	$disabled = "disabled";
	//$token = False;
	$tableToken = False;
	$fileToken = False;
	//$success_token = False;
	$config_new = newRegConfig();
		
	if(isset ($_POST['Update_wp_tng_Paths'])) 
    {
		$tngFileError = checkForTngPathInit();
		
		if ($tngFileError[0] == True) {
			$tngPromt = "<div style='color: red; font-size: 1.2em'>Cannot find TNG folder. Please check TNG setup.</div>"; 
		}
		
		if ($tngFileError[0] == False) 
        {
			$_POST['wp_tng_path'] = $tngFileError[1];
			$_POST['wp_tng_url'] = $tngFileError[2];
			$_POST['wp_tng_photo_folder'] = $tngFileError[3];
			$_POST['tng_success_token'] = False;
			$fileToken = True;
			$tableToken = checkTablesInit();			
		

			if (($_POST['Update_wp_tng_Paths'] == "Find TNG Folder")) {
				$config_new["paths"]['tng_path'] = $_POST["wp_tng_path"];
				$config_new["paths"]['tng_url'] = $_POST["wp_tng_url"];
				$config_new["paths"]['tng_photo_folder'] = $_POST["wp_tng_photo_folder"];
				$config_new["paths"]['tng_success_token'] = $_POST["tng_success_token"];
				$json = (json_encode($config_new, JSON_PRETTY_PRINT));
				$path = __DIR__ . "/config.json";
				file_put_contents($path, $json);
			}

	/******************wrap up********************************* */	
		
			if ($_POST['wp_tng_path']) $tngPromt = "<div style='color: green; font-size: 1.2em'>Thanks. Found TNG folder</div>"; 

			if ($_POST['wp_tng_url']) $urlPromt = "<div style='color: green; font-size: 1em'>Genealogy URL OK</div>";
			
			/** check for Photo folder */
			$photoPromt = "<div style='color: red; font-size: 1em'>Enter Name of TNG photo Folder eg photos</div>";
			
			if ($_POST['wp_tng_photo_folder']) $photoPromt = "<div style='color: green; font-size: 1em'> TNG photo folder OK</div>";
			}
	}
/*************************************************************** */
	
	if($success) 
    {
		echo "<div class='notice notice-success'>";	
    } else {
		echo "<div class='notice notice-error'>";	
	}
	?>
	
	<div>
	<h2>WP - TNG login: We need to know where TNG is installed:</h2>
	</div>
	<form action=''  method="post">	
	<div> 	
		<input type="text"  style="width: 250px" name="wp_tng_path" value= '<?php if (isset($_POST['wp_tng_path'])) echo ($_POST['wp_tng_path']) ?>' placeholder='TNG Root Path:'>
		TNG Root Path is absolute path to TNG. You may look this up from TNG Admin Setup>Paths and Folders>Root Path or in config.php in TNG folder.
	</div>
	<?php
	echo $tngPromt;
if (isset($_POST["wp_tng_url"])) {
	?>
	<div> 	
		<input style="color: green; width: 250px" type="text"  name="wp_tng_url" value= '<?php if (isset($_POST['wp_tng_url'])) echo $_POST['wp_tng_url'] ; ?>' placeholder='Genealogy URL:' <?php echo $disabled; ?>/>
		Genealogy URL (www.mysite.com/tng) from TNG Admin Setup.
	</div>
	<?php
		echo $urlPromt;
}
if (isset($_POST["wp_tng_photo_folder"])) {
	?>
	<div> 	
		<input style="color: green" type="text"  name="wp_tng_photo_folder" style="width: 250px" value= '<?php if (isset($_POST['wp_tng_photo_folder'])) echo $_POST['wp_tng_photo_folder']; ?>' placeholder='TNG photo folder:' <?php echo $disabled; ?>/>
		Name of TNG Photo Folder in TNG Setup.
	</div>
	<?php
	
		$userPromt = "<div style='color: green; font-size: 1em'>Found TNG Tables, ".  $tableToken[1]. ", ". $tableToken[2]. " and ". $tableToken[3]. "</div>";
	}
	if (isset($_POST['Update_wp_tng_Paths'])) {
		$FindTngFolder = $_POST['Update_wp_tng_Paths'];
		if ($FindTngFolder == "Find TNG Folder") {
			$FindTngFolder = "Done. Click to Finish";
			echo $userPromt;
		}
		if ($FindTngFolder == "Done. Click to Finish" && ($tableToken[0] == True) && ($fileToken == True) ) {
			$config_new["paths"]['tng_path'] = $_POST["wp_tng_path"];
			$config_new["paths"]['tng_url'] = $_POST["wp_tng_url"];
			$config_new["paths"]['tng_photo_folder'] = $_POST["wp_tng_photo_folder"];
			$config_new["paths"]['tng_success_token'] = $tableToken[0];
			$json = (json_encode($config_new, JSON_PRETTY_PRINT));
			$path = __DIR__ . "/config.json";
			file_put_contents($path, $json);
			
		}
	}

?>
	<p>
	<input type="submit" name="Update_wp_tng_Paths" value="<?php echo $FindTngFolder; ?>">
	</p>
	</div>
	</form>
	
<?php

}


/******** if user tables available continue ************************** */
if (file_exists($tngPath) && $token == TRUE) {
	require_once 'tng_wp_options.php';
	// require_once 'newreg.php';
	// require_once 'newregcomplete.php';
	require_once 'showprofile.php';
	//  require_once 'login-to-wp.php'; delete
	// require_once 'login-to-tng.php'; delete
	require_once 'insert_wp_pages.php';
	// require_once 'lost_pw_settings.php';
	// require_once 'templates/lost_password.html.php';
	// require_once 'templates/reset_password.html.php';
	// require_once 'templates_admin/admin_set_paths.php';

	add_action( 'wp_enqueue_scripts', 'add_tng_wp_login_stylesheets' );

	/*******add shortcodes ************/
	add_shortcode('user_profile', 'show_profile'); //Profile Page
	add_shortcode('user_registration', 'new_reg');

	//Register wP and TNG login Widget
	add_action( 'widgets_init', function(){
		register_widget( 'wp_tng_login_Widget' );
		//register_widget( 'wp_tng_login_Widget' );
	});

	//insert pages on activation
	register_activation_hook( __FILE__, 'do_insert_pages' ); 

	//Password-Reset Page
	add_action('login_form_lostpassword', 'redirect_for_lostpassword');
	add_action( 'login_form_lostpassword', 'do_password_lost' );
	add_action( 'login_form_rp', 'do_password_reset');
	add_action( 'login_form_resetpass', 'do_password_reset' );
	add_action( 'login_form_rp', 'redirect_to_password_reset' );
	add_action( 'login_form_resetpass',  'redirect_to_password_reset' ) ;

	add_filter( 'retrieve_password_message', 'replace_retrieve_password_message', 10, 4 );


	add_shortcode('lost_Password_form', 'lostPassword'); 
	add_shortcode('reset_Password_form', 'resetPassword');
}
function add_tng_wp_login_stylesheets() {
	wp_register_style( 'register-tng_wp_login_css', plugins_url('css/wp_tng_login.css', __FILE__) );
	wp_enqueue_style( 'register-tng_wp_login_css' );
} 