<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
/*
Plugin Name: TNG-Wordpress-login for TNG V10.1.3beta
Plugin URI: https://github.com/upavadi/tng-wp-login
Description: Login to TNG 10.1.3 with Wordpress, allow new registrations, user profiles and Retrieve password
Version:     1.0.3.beta
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
require_once(ABSPATH. 'wp-load.php');
require_once(ABSPATH . 'wp-includes/pluggable.php'); 
require_once 'newreg.php';
require_once 'newregcomplete.php';
require_once 'showprofile.php';
require_once 'tng_wp_options.php';
require_once 'login-to-wp.php';
require_once 'login-to-tng.php';
require_once 'insert_wp_pages.php';
require_once 'lost_pw_settings.php';
require_once 'templates/lost_password.html.php';
require_once 'templates/reset_password.html.php';
require_once 'templates_admin/admin_set_paths.php';
//require_once "newreg_options.php";

$tngPath = getTngPath(). 'config.php';
if (!file_exists($tngPath)) {
	$e = new Exception('TNG Path not found');
	error_log($e->getMessage());
	error_log($e->getTraceAsString());
//  Display admin message if tng path not specified
	add_action( 'admin_notices', 'tng_path_not_specified' );
}

function tng_path_not_specified() {
	if(isset ($_POST)) {
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
			$config_new["paths"]['tng_path'] = $_POST["tng_path"];
			$config_new['paths']['tng_url'] = $tngdomain;
			$config_new['paths']['tng_photo_folder'] = $photopath;
			$json = (json_encode($config_new, JSON_PRETTY_PRINT));
			$path = __DIR__ . "/config.json";
			file_put_contents($path, $json);
			$success = "Paths saved";
		}
	}
	?>

    
	<?php if($success) {
		echo "<div class='notice notice-success'>";
	} else {
		echo "<div class='notice notice-error'>";
	}
	?>
		<div>
			<h2>We need to know where TNG is installed:</h2>
		</div>
		<form action=''  method="post">	
		<div> 	
			<input type="text"  style="width: 250px" name="tng_path" value= '<?php echo $_POST['tng_path'] ?>' placeholder='TNG Root Path:'>
			TNG Root Path is absolute path to TNG. You may look this up from TNG Admin Setup or in config.php in TNG folder.
		</div>
		<?php
		echo $tngPromt;
		?>
		<div> 	
			<input style="color: green; width: 250px" type="text"  name="tng_url" value= '<?php echo $tngdomain; ?>' placeholder='TNG url:' disabled>
			TNG URL (www.mysite.com/tng) from TNG Admin Setup.
		</div>
		<div> 	
			<input style="color: green" type="text"  name="tng_photo_folder" style="width: 250px" value= '<?php echo $photopath; ?>' placeholder='TNG photo folder:' disabled>
			Name of TNG Photo Folder in TNG Setup.  If you want to use different folder for this plugin, change it in admin menu>WP-TNG Login>Plugin Paths.
		</div>
		<p style="color: green; display: inline-block"><?php echo "<b>". $success. "</b><br />"; ?></p>
		
	<p>
	<input type="submit" name="Update_Paths" value="Update Paths">
	</p>
	</div>
	</form>
	
    <?php
	$config_new = update_init_paths();
}

function checkForTngPath() {
	$tng_path = $_POST['tng_path']. 'config.php';
	$tngFileError = "";
	if (!file_exists($tng_path) || !is_readable($tng_path)) {	
		return array(true, "", "","");
	} else {
	include($tng_path);
	
	return array(false, $rootpath, $tngdomain, $photopath);
	}
}

function update_init_paths() {
	$_POST['tng_url'] = checkForTngPath()[2];
	$_POST['tng_photo_folder'] = checkForTngPath()[3];
	$path_json = (__DIR__. '/config.json');
		$config = optionsConfig();
		$config_new = $config;
		$config_new["paths"]['tng_path'] = $_POST["tng_path"];
		$config_new['paths']['tng_url'] = $_POST['tng_url'];
		$config_new['paths']['tng_photo_folder'] = $_POST['tng_photo_folder'];
		$json = (json_encode($config_new, JSON_PRETTY_PRINT));
		//$path = "config.json";
		file_put_contents($path_json, $json);
		$success = "Changes Saved";
		return $config_new;
	}



function add_tng_wp_login_stylesheets() {
	/** Remove bootstrap here and add to templates to avoid conflucts with other plugins **/
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

/** get real path to wp-load.php 
    function find_wp_path() {
        $dir = dirname(__FILE__);
        do {
            if( file_exists($dir."/wp-config.php") ) {
                return $dir;
            }
        } while( $dir = realpath("$dir/..") );
        return null;
    }
**/