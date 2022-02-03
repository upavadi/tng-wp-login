<?php
/*
Plugin Name: 2 - TNG-Wordpress-login
Plugin URI: https://github.com/upavadi/tng-wp-login
Description: Login to TNG with Wordpress, GDPR complient, allow new registrations, edit user profile and Retrieve password
Version:     3.01 prefix Beta
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
	static $success, $tngPromt, $urlPromt, $photoPromt, $prefix_db, $Update_wp_tng_Paths,$wp_tng_db_prefix, $prefix_line, $disabled;
	global $wpdb;
	$tngPromt = "";
	$urlPromt = "";
	$photoPromt = "";
	$FindTngFolder = "Find TNG Folder";
	$userPromt = "";
	//$disabled = "disabled";
	$disablePrefix = "disabled";
	$token = false;
	$prefixCheck = (checkPrefixInit());
	$config_new = newRegConfig();
	//$config_paths = ($config['paths']);
	
	if(isset ($_POST['Update_wp_tng_Paths'])) 
    {
		$tngFileError = checkForTngPathInit();
		
		if ($tngFileError[0] == true) {
			$tngPromt = "<div style='color: red; font-size: 1.2em'>Cannot find TNG folder. Please check TNG setup.</div>"; 
		}
		
		if ($tngFileError[0] == false) 
        {
				//get values from config.php
				$_POST['wp_tng_path'] = $tngFileError[1];
				$_POST['wp_tng_url'] = $tngFileError[2];
				$_POST['wp_tng_photo_folder'] = $tngFileError[3];
				$prefix_db = $config_new["paths"]['tng_db_prefix'];
				$_POST['tng_prefix_token'] = False;
				

			if (($_POST['Update_wp_tng_Paths'] == "Find TNG Folder")) {
				$config_new["paths"]['tng_path'] = $_POST["wp_tng_path"];
				$config_new["paths"]['tng_url'] = $_POST["wp_tng_url"];
				$config_new["paths"]['tng_photo_folder'] = $_POST["wp_tng_photo_folder"];
				//$config_new["paths"]['tng_db_prefix'] = $prefix_db;
				$config_new["paths"]['tng_prefix_token'] = $_POST['tng_prefix_token'];
				$json = (json_encode($config_new, JSON_PRETTY_PRINT));
				$path = __DIR__ . "/config.json";
				file_put_contents($path, $json);
			}

			//no table prefix make $token = true 
			if ($prefixCheck == 'tng_users') {
				$token = true;
				$prefix_db = "";
				$disablePrefix = "disabled";
				$prefixComment = "";
				$success = "<div style='color: green; font-size: 1.2em'>No Table prefixes - <b>Click Update ALL</b> and we are done</div>";			
			}
			//No table prefix - encode
			if (($_POST['Update_wp_tng_Paths'] ==  "Update ALL" && ($prefixCheck == 'tng_users') )) {
				$config_new["paths"]['tng_path'] = $_POST["wp_tng_path"];
				$config_new["paths"]['tng_url'] = $_POST["wp_tng_url"];
				$config_new["paths"]['tng_photo_folder'] = $_POST["wp_tng_photo_folder"];
				$config_new["paths"]['tng_db_prefix'] = $prefix_db;
				$config_new["paths"]['tng_prefix_token'] = $token;
				$json = (json_encode($config_new, JSON_PRETTY_PRINT));
				$path = __DIR__ . "/config.json";
				file_put_contents($path, $json);
			}

			// Table has prefix.
			if ($prefixCheck != 'tng_users') {
				$token = true;
				$prefix_db = $config_new["paths"]['tng_db_prefix'];
				$prefix_line = true; //show prefix input line
				$disablePrefix = "required";
				$prefixComment = "Name of TNG Table Prefix. TNG DB User table is <b>". $prefixCheck;
				$success = "<div style='color: green; font-size: 1.2em'>Update Table Prefix and <b>click update</b></div>";	
			}
			//table has prefix - encode
			if (($_POST['Update_wp_tng_Paths'] ==  "Update ALL" && ($prefixCheck != 'tng_users') )) {
				
				$config_new["paths"]['tng_path'] = $_POST["wp_tng_path"];
				$config_new["paths"]['tng_url'] = $_POST["wp_tng_url"];
				$config_new["paths"]['tng_photo_folder'] = $_POST["wp_tng_photo_folder"];
				$config_new["paths"]['tng_db_prefix'] = $_POST['wp_tng_db_prefix'];
				$config_new["paths"]['tng_prefix_token'] = $token;
				$json = (json_encode($config_new, JSON_PRETTY_PRINT));
				$path = __DIR__ . "/config.json";
				file_put_contents($path, $json);
				$success = "All Done Refresh page";
				$success = "<div style='color: green; font-size: 1.2em'><b>All Done Refresh page</b></div>";	
				
			}


		/*************************************************** */	
		
			if ($_POST['wp_tng_path']) $tngPromt = "<div style='color: green; font-size: 1.2em'>Thanks. Found TNG folder</div>"; 

			if ($_POST['wp_tng_url']) $urlPromt = "<div style='color: green; font-size: 1em'>Genealogy URL OK</div>";
			
			/** check for Photo folder */
			$photoPromt = "<div style='color: red; font-size: 1em'>Enter Name of TNG photo Folder eg photos</div>";
			if ($_POST['wp_tng_photo_folder']) $photoPromt = "<div style='color: green; font-size: 1em'> TNG photo folder OK</div>";

			}
	}
//var_dump($_POST);
	
	if($success) 
    {
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
			echo $photoPromt;
	}

/**************** END *******************/

	if ($prefix_line == true) {
	?>
		
        <div> 	
			<input style="color: " type="text"  name="wp_tng_db_prefix" style="width: 250px" value= '<?php echo $prefix_db; ?>' placeholder='TNG Table Prefix:' <?php echo $disablePrefix; ?>/><?php echo $prefixComment; ?></b> 
		</div>
		<?php
		echo $userPromt;
	}
	if(isset ($_POST['Update_wp_tng_Paths'])) $FindTngFolder = "Update ALL";
	if(isset ($_POST['Update_wp_tng_Paths'])) $_POST['Update_wp_tng_Paths'] = "Update ALL";

	
		?>
		<p style="display: inline-block"><?php echo "<b>". $success. "</b><br />"; ?></p>
	<p>
	<?php
	
	?>
	</p>
	<p>
	<input type="submit" name="Update_wp_tng_Paths" value="<?php echo $FindTngFolder; ?>">
	</p>
	</div>
	</form>
	
<?php


return;
}


/******************************************** */
if (file_exists($tngPath) && $prefixToken == TRUE) {
	require_once 'tng_wp_options.php';
	require_once 'newreg.php';
	require_once 'newregcomplete.php';
	require_once 'showprofile.php';
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
}
function add_tng_wp_login_stylesheets() {
	wp_register_style( 'register-tng_wp_login_css', plugins_url('css/wp_tng_login.css', __FILE__) );
	wp_enqueue_style( 'register-tng_wp_login_css' );
} 
