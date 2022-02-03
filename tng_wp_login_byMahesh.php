<?php
/*
Plugin Name: TNG-Wordpress-login for TNG 9-13 
Plugin URI: https://github.com/upavadi/tng-wp-login
Description: Login to TNG with Wordpress, GDPR complient, allow new registrations, edit user profile and Retrieve password. Will work with TNG tables with prefixes.
Version:     3.0
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
// find tng config on initiation
static $tngPath, $prefixToken;
require_once(ABSPATH. 'wp-load.php');
require_once(ABSPATH . 'wp-includes/pluggable.php'); 
require_once 'newreg_config.php';

//Get JSON values
$tngPath = getSubrootInit(). 'config.php';
$config = newRegConfig();
$config_paths = ($config['paths']);
$tng_Path = $config_paths['tng_path'];
$tng_url = $config_paths['tng_url'];
$tng_Photo_folder = $config_paths['tng_photo_folder'];
//$prefix_db = $config_paths['tng_db_prefix'];
$prefixToken = $config_paths['tng_prefix_token'];
//check for no prefix
$prefixCheck = (checkPrefixInit()); 
$test = true;
var_dump($prefixToken);
if (!file_exists($tngPath) OR ($prefixToken == False) ) {
add_action( 'admin_notices', 'tng_path_not_specified' );
}

function tng_path_not_specified() {
	if(isset ($_POST['Update_wp_tng_Paths'])) {
		$tngFileError = checkForTngPath();
		$tngPromt = "";
		if ($tngFileError[0] == true) {
			$tngPromt = "<div style='color: red; font-size: 1.2em'>Cannot find TNG folder. Please check TNG setup.</div>";
		}
		
		if ($tngFileError[0] == false) {
			$tngPromt = "<div style='color: green; font-size: 1.2em'>Found TNG folder</div>";
			$tngdomain = $tngFileError[2];
			$photopath = $tngFileError[3];
			$config_new = optionsConfig();
			$config_new["paths"]['tng_path'] = $_POST["wp_tng_path"];
			$config_new['paths']['tng_url'] = $tngdomain;
			$config_new['paths']['tng_photo_folder'] = $photopath;
			$json = (json_encode($config_new, JSON_PRETTY_PRINT));
			$path = __DIR__ . "/config.json";
			file_put_contents($path, $json);
			$success = "Paths saved";
		}
	}
	    
	if($success) {
		echo "<div class='notice notice-success'>";
	} else {
		echo "<div class='notice notice-error'>";
	}
	?>
		<div>
			<h2>wp-tng login: We need to know where TNG is installed:</h2>
		</div>
		<form action=''  method="post">	
		<div> 	
			<input type="text"  style="width: 250px" name="wp_tng_path" value= '<?php echo $_POST['wp_tng_path'] ?>' placeholder='TNG Root Path:'>
			TNG Root Path is absolute path to TNG. You may look this up from TNG Admin Setup or in config.php in TNG folder.
		</div>
		<?php
		echo $tngPromt;
		?>
		<div> 	
			<input style="color: green; width: 250px" type="text"  name="wp_tng_url" value= '<?php echo $tngdomain; ?>' placeholder='TNG url:' disabled>
			TNG URL (www.mysite.com/tng) from TNG Admin Setup.
		</div>
		<div> 	
			<input style="color: green" type="text"  name="wp_tng_photo_folder" style="width: 250px" value= '<?php echo $photopath; ?>' placeholder='TNG photo folder:' disabled>
			Name of TNG Photo Folder in TNG Setup.  If you want to use different folder for this plugin, change it in admin menu>WP-TNG Login>Plugin Paths.
		</div>
		<p style="color: green; display: inline-block"><?php echo "<b>". $success. "</b><br />"; ?></p>
		
	<p>
	<input type="submit" name="Update_wp_tng_Paths" value="Update Paths">
	</p>
	</div>
	</form>
	
    <?php

}

function checkForTngPath() {
	$wp_tng_path = $_POST['wp_tng_path']. 'config.php';
	$tngFileError = "";
	if (!file_exists($wp_tng_path) || !is_readable($wp_tng_path)) {	
		return array(true, "", "","");
	} else {
	include($wp_tng_path);
	
	return array(false, $rootpath, $tngdomain, $photopath);
	}
}


function add_tng_wp_login_stylesheets() {
	/** Remove bootstrap here and add to templates to avoid conflicts with other plugins **/
		//wp_register_style( 'register-tng_wp_bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css');
		//wp_enqueue_style( 'register-tng_wp_bootstrap' );
		wp_register_style( 'register-tng_wp_login_css', plugins_url('css/wp_tng_login.css', __FILE__) );
		wp_enqueue_style( 'register-tng_wp_login_css' );
} 
add_action( 'wp_enqueue_scripts', 'add_tng_wp_login_stylesheets' );

/*******add shortcodes ************/
// add shortcode for Profile Page
add_shortcode('user_profile', 'show_profile'); //Profile Page
add_shortcode('user_registration', 'new_reg');

//Register wP and TNG login Widget
add_action( 'widgets_init', function(){
	 register_widget( 'wp_tng_login_Widget' );
	// register_widget( 'wp_tng_login_Widget' );
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

//add_shortcode( 'lost_Password_form', array( $this, 'render_login_form' ) );
add_shortcode('lost_Password_form', 'lostPassword'); 
add_shortcode('reset_Password_form', 'resetPassword'); 