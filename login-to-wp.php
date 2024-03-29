<?php
/** Log-In Widget ****/
require_once(ABSPATH. 'wp-load.php');
require_once "newreg_config.php";
require_once "login-consent.php";
/********** Class   *******/
class wp_tng_login_Widget extends WP_Widget {
	public function __construct() {
		
		parent::__construct(
            'wp_tng_login_Widget',
            __( 'WP and TNG Login Widget', 'Log-in' ),
            array(
                'classname'   => 'wp_tng_login_Widget',
                'description' => __( 'A Logs in to Wordpress & TNG.', 'Log-in' )
                )
        );

	} // end construct
	
	public function widget( $args, $instance ) {
		global $wpdb, $currentUser, $wpCurrentUser, $args, $status3, $status4, $status5, $status6;
		
		$log_in_text = optionsConfig()['login_text'];
		$loggedout_greeting = $log_in_text['loggedout_greeting'];
		$greeting = $log_in_text['greeting'];
		$cookie_notification = $log_in_text['cookie_notification'];
		$identifier = $log_in_text['version_id'];
		$user_page = $log_in_text['user_page'];
		$user_page_name = $log_in_text['user_page_name'];
		$reg_page = $log_in_text['reg_page'];
		$reg_page_name = $log_in_text['reg_page_name'];
		$lost_password = $log_in_text['lost_password'];
		$RememberMe = $log_in_text['RememberMe'];
		$ask_user_contest = newRegPrivacy();
		$ask_user_contest = $ask_user_contest['current_user_consent'];
		$user_page_url = home_url(). "/". $user_page;
		$register_page_url = home_url(). "/". $reg_page;
		$wp_url = site_url();
		$wpCurrentUser = wp_get_current_user() -> user_login;
		$status8 = "";

		$user_redirect = 
			$args = array(
			'echo'           => false,
			'remember'       => true,
			'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
			'form_id'        => 'loginform',
			'id_username'    => 'user_login',
			'id_password'    => 'user_pass',
			'id_remember'    => 'rememberme',
			'id_submit'      => 'wp-submit',
			'label_username' => __( 'Username or Email Address' ),
			'label_password' => __( 'Password' ),
			'label_remember' => __( $RememberMe ),
			'label_log_in'   => __( 'Log In' ),
			'value_username' => '',
			'value_remember' => true
			
		);
		$plugin_dir_path = plugin_dir_url( __FILE__ );
		$login_redirect = $plugin_dir_path. "/login-to-tng.php";
		$login_url = esc_url(site_url( 'wp-login.php', $_SERVER['PHP_SELF'] ));
		//$loginout = wp_loginout($_SERVER['REQUEST_URI'], false );
		$loginout = wp_loginout(home_url(), false ); // changed this to avoid logout conflict with MB method.

		$logoutUrl = (wp_logout_url(home_url()));
		$logoutUrl = str_replace('&amp;', '&' ,$logoutUrl);

		//check for user consent
		if ($wpCurrentUser && ($ask_user_contest == true)) {
			renderConsent();
			$consent = checkConsent();
		} 

		if (is_user_logged_in()) {
			// Do consent check & JS
			$adminurl = get_admin_url();
			$status1 = $greeting. " ". is_logged_in() ->user_firstname. " ". $identifier; 
			if (current_user_can('administrator')) {
				$status2 = "<a href=\"$adminurl\">Dashboard</a>". " - ". $loginout;
			} else {
				$status2 = "<a href=".$user_page_url. ">". $user_page_name. "</a>". " - ". $loginout;
			}
			
		} else {
			/** replace with these 2 to get fields verticallly aligned.**
			 $status1 = $loggedout_greeting. "<br />". ("<label for='log'></label><input style='width: 95%; margin: 4px'  placeholder='user name or email' type='text' id='". $args['id_username']. " 'name='log'><input style='width: 95%; margin: 4px' placeholder='password' type='password' id='". $args['id_password']. "' name='pwd'>");
  
			$status5 = "<br />". ("<input style='width: 100%; margin: 2px'' type='submit' id='". $args['id_submit']. "' class='button-primary' value='Log In' name='wp-submit'>");
			****/
			
			
			$status1 = $loggedout_greeting. " - ". ("<label for='log'>Login</label><input placeholder='user name or email' type='text' id='". $args['id_username']. "' name='log'> - <input placeholder='password' type='password' id='". $args['id_password']. "' name='pwd'>");

			$status2 = ( $args['remember'] ? '<input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . ' |</label>' : '' );
			
			$status3 =  ("<a href='$login_url?action=lostpassword' title='Lost Password' id='LostP'>". $lost_password. " |</a>");
			$status4 = ("<a href=". $register_page_url. ">  ". $reg_page_name. " </a>");
			$status5 = ("<input type='submit' id='". $args['id_submit']. "' class='button-primary' value='Log In' name='wp-submit'>");
			$status7 = "error message";
			$status6 = ("<input type='hidden' value='". $args['redirect']. "' name='redirect_to'>");
			$status8 = "<div id='cookie_alert'>". $cookie_notification. "</div>";
			/** Private Mod defines Social Media redirect button as $status9 ***/
			//$status9 = ("<input type='button' . ' class='button-primary' style='margin-left: 0px; width: 100%'  value='Log in with Facebook or Google' name='social' onclick='social()' />");
		}
	?>
	<form id="<?php echo $args['form_id' ]; ?>" name="loginform" action="<?php echo $login_redirect; ?>" method="post">
		<div id="container">
			<div id="upper" class="row">
			<?php echo $status1; ?>
			</div>
			<div id="lower_login">
			<?php echo $status2. $status3. $status4. $status5;	$status6; $status7; ?>
			</div>
			<?php echo "<b>". $status8. "</b>"; ?>
			<div id="msg"class="row">
			<?php echo $status6; ?>
			</div>
		</div>
	</form>
	
 <script>
 function social() {
 window.location = '../social/'
 }
 </script>
<?php
/**Private mod to display social login redirect  */	
//echo $status9;
}	//widget
} //class


function register_wp_tng_login_Widget() {
     register_widget( 'wp_tng_login_Widget' );
 }
 ?>