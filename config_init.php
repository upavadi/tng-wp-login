<?php
/*
Plugin Name: 1 - TNG-Wordpress-login
Plugin URI: https://github.com/upavadi/tng-wp-login
Description: Login to TNG with Wordpress, GDPR complient, allow new registrations, edit user profile and Retrieve password
Version:     3.0 prefix Beta
Author:      Mahesh Upadhyaya
Author URI:  http://trial.upavadi.net
License:     MIT
License URI: http://opensource.org/licenses/MIT
**/
// find tng config on initiation
static $tngPath;

require_once(ABSPATH. 'wp-load.php');
require_once(ABSPATH . 'wp-includes/pluggable.php'); 
require_once 'newreg_config.php';

$done = "DONE"; //temp variable
//$userTableName = checkPrefixInit(); //check for tng_users
$tngPath = getSubrootInit(). 'config.php';
$config = newRegConfig();
$config_paths = ($config['paths']);
$prefixCheck = (checkPrefixInit());

if (!file_exists($tngPath) OR $done == "") {
add_action( 'admin_notices', 'tng_path_not_specified' );
}

function tng_path_not_specified() {
	static $success, $tngPromt, $urlPromt, $photoPromt, $userTableName, $prefixPrompt, $disabled; 
	global $wpdb;
	$tngPromt = "";
	$urlPromt = "";
	$photoPromt = "";
	$prefixPrompt = "";

	$userTableName = checkPrefixInit();
	$userPromt = $userTableName. " Enter Table prefix ";
	if ($userTableName == "tng_users") $userPromt = "No Prefix. Leave Blank";

	if(isset ($_POST['Update_wp_tng_Paths'])) 
    {
		$tngFileError = checkForTngPath();
		
		if ($tngFileError[0] == true) {
			$tngPromt = "<div style='color: red; font-size: 1.2em'>Cannot find TNG folder. Please check TNG setup.</div>"; 
			
		}
		
		if ($tngFileError[0] == false) 
        {
			$tngPromt = "<div style='color: green; font-size: 1.2em'>Found TNG folder</div>"; 
			//get values from config.php
			$_POST['wp_tng_url'] = $tngFileError[2];
			$_POST['wp_tng_photo_folder'] = $tngFileError[3];
            //$_POST['wp_tng_db_prefix'] = $tngFileError[4];

			/** check for url */
			$urlPromt = "<div style='color: red; font-size: 1.2em'>Enter TNG URL</div>";
			if ($_POST['wp_tng_url']) $urlPromt = "<div style='color: green; font-size: 1.2em'>TNG URL OK</div>";
			
			/** check for Photo folder */
			$photoPromt = "<div style='color: red; font-size: 1.2em'>Enter Name of TNG photo Folder eg photos</div>";
			if ($_POST['wp_tng_photo_folder']) $photoPromt = "<div style='color: green; font-size: 1.2em'> TNG photo folder OK</div>";

			$config_new = newRegConfig();
			$config_new["paths"]['tng_path'] = $_POST["wp_tng_path"];
			$config_new['paths']['tng_url'] = $_POST["wp_tng_url"];
			$config_new['paths']['tng_photo_folder'] = $_POST["wp_tng_photo_folder"];
			$config_new['paths']['tng_db_prefix'] = $_POST["wp_tng_db_prefix"];
			$json = (json_encode($config_new, JSON_PRETTY_PRINT));
			$path = __DIR__ . "/config.json";
			file_put_contents($path, $json);
			$success = "Paths saved";
			
		
		}
	}
	    
	if($success) 
    {
		echo "<div class='notice notice-success'>";
		$disabled = "";
        
	} else {
		echo "<div class='notice notice-error'>";
		$disabled = "";
	}
	?>
		<div>
			<h2>wp-tng login: We need to know where TNG is installed:</h2>
		</div>
		<form action=''  method="post">	
		<div> 	
			<input type="text"  style="width: 250px" name="wp_tng_path" value= '<?php if (isset($_POST['wp_tng_path'])) echo ($_POST['wp_tng_path']) ?>' placeholder='TNG Root Path:'>
			TNG Root Path is absolute path to TNG. You may look this up from TNG Admin Setup or in config.php in TNG folder.
		</div>
		<?php
		
		echo $tngPromt;
		?>
		<div> 	
			<input style="color: green; width: 250px" type="text"  name="wp_tng_url" value= '<?php if (isset($_POST['wp_tng_url'])) echo $_POST['wp_tng_url'] ; ?>' placeholder='TNG url:' <?php echo $disabled; ?>/>
			TNG URL (www.mysite.com/tng) from TNG Admin Setup.
		</div>
		<?php
		
		echo $urlPromt;
		?>
		<div> 	
			<input style="color: green" type="text"  name="wp_tng_photo_folder" style="width: 250px" value= '<?php if (isset($_POST['wp_tng_photo_folder'])) echo $_POST['wp_tng_photo_folder']; ?>' placeholder='TNG photo folder:' <?php echo $disabled; ?>/>
			Name of TNG Photo Folder in TNG Setup.  If you want to use different folder for this plugin, change it in admin menu>WP-TNG Login>Plugin Paths.
		</div>
		<?php
		
		echo $photoPromt;
		?>
        <div> 	
			<input style="color: green" type="text"  name="wp_table_prefix" style="width: 250px" value= '<?php if (isset($_POST['wp_tng_db_prefix'])) echo $_POST['wp_tng_db_prefix']; ?>' placeholder='TNG Table Prefix:' <?php echo $disabled; ?>/>
			Name of TNG Table Prefix for  TNG DB.  If you are using Prefix for TNG tables (eg. wp_tng_xxxx), enter prefix. Leave <b>Blank</b> if you are not using prefix. Your default Wordpress prefix is defined as <b><?php echo $wpdb->prefix; ?></b> 
		</div>
		<?php
		echo $userPromt;
		?>
		<p style="color: green; display: inline-block"><?php echo "<b>". $success. "</b><br />"; ?></p>
		
	<p>
	<input type="submit" name="Update_wp_tng_Paths" value="Update Paths">
	</p>
	</div>
	</form>
	
<?php
}

function checkForTngPath() {
	//static $tngPrefix;
	$wp_tng_path = $_POST['wp_tng_path']. 'config.php'; 
	//$tngFileError = "";
	if (!file_exists($wp_tng_path) || !is_readable($wp_tng_path)) {	
		return array(true, "", "","","");
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

require_once 'tng_wp_options.php';
require_once 'newreg.php';
require_once 'newregcomplete.php';
require_once 'showprofile.php';
//require_once 'tng_wp_options.php';
require_once 'login-to-wp.php';
require_once 'login-to-tng.php';
require_once 'insert_wp_pages.php';
require_once 'lost_pw_settings.php';
require_once 'templates/lost_password.html.php';
require_once 'templates/reset_password.html.php';
require_once 'templates_admin/admin_set_paths.php';


add_action( 'wp_enqueue_scripts', 'add_tng_wp_login_stylesheets' );

/*******add shortcodes ************/
// add shortcode for Profile Page
add_shortcode('user_profile', 'show_profile'); //Profile Page
add_shortcode('user_registration', 'new_reg');

//Register wP and TNG login Widget
add_action( 'widgets_init', function(){
	register_widget( 'wp_tng_login_Widget' );
	register_widget( 'wp_tng_login_Widget' );
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
