<?php
require_once(ABSPATH. 'wp-load.php');
require_once "newreg_config.php";
/********** Class   *******/
class wp_tng_login_Widget2 extends WP_Widget {
	public function __construct() {
		
		parent::__construct(
            'wp_tng_login_Widget2',
            __( 'WP and TNG Login Widget2', 'Log-in' ),
            array(
                'classname'   => 'wp_tng_login_Widget2',
                'description' => __( 'A Logs in to Wordpress & TNG.', 'Log-in' )
                )
        );

	} // end construct
	
	public function widget( $args, $instance ) {
		global $wpdb, $currentUser, $wpCurrentUser, $args;
		$config = newRegConfig();
		$wp_profile_page = 'wp-tng-profile';
		$wp_reg_page = 'wp-tng-registration';
		$profile = home_url(). "/". $wp_profile_page;
		$register = site_url(). "/". $wp_reg_page;
		$wp_url = site_url();
		$wpCurrentUser = wp_get_current_user() -> user_login;
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
			'label_remember' => __( 'Remember Me' ),
			'label_log_in'   => __( 'Log In' ),
			'value_username' => '',
			'value_remember' => true
			
		);
		$plugin_dir_path = plugin_dir_url( __FILE__ );
		$login_redirect = $plugin_dir_path. "/login-to-tng.php";
		$login_url = esc_url(site_url( 'wp-login.php', $_SERVER['PHP_SELF'] ));
		$loginout = wp_loginout($_SERVER['REQUEST_URI'], false );
		
		if (is_user_logged_in()) {
			//$_SESSION['currentuser'] = wp_get_current_user() -> user_login;
			$adminurl = get_admin_url();
			$status1 = "Welcome ". is_logged_in() ->user_firstname. " (Beta Version of wp-tng-login widget)"; 
			if (current_user_can('administrator')) {
				$status2 = "<a href=\"$adminurl\">Dashboard</a>". " - ". $loginout;
			} else {
				$status2 = "<a href=\"$profile\">Your Profile</a>". " - ". $loginout;
			}
			
		} else {
			
			$status1 = ("<label for='log'>wp-tng-login Beta Version:</label><input placeholder='user name or email' type='text' id='". $args['id_username']. "' name='log'> - <input placeholder='password' type='password' id='". $args['id_password']. "' name='pwd'>");

			$status2 = ( $args['remember'] ? '<input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . ' |</label>' : '' );

			$status3 = ("<a href='$login_url?action=lostpassword' title='Lost Password' id='LostP'>Lost Password |</a>");
			$status4 = ("<a href=\"$register\"> Register </a>");
			$status5 = ("<input type='submit' id='". $args['id_submit']. "' class='button-primary' value='Log In' name='wp-submit'>");
			$status7 = "error message";
			$status6 = ("<input type='hidden' value='". $args['redirect']. "' name='redirect_to'>");;
		}

	?>
	<form id="<?php echo $args['form_id' ]; ?>" name="loginform" action="<?php echo $login_redirect; ?>" method="post">
		<div id="container">
			<div id="upper" class="row">
			<?php echo $status1; ?>
			</div>
			<div id="lower"class="row">
			<?php echo $status2. $status3. $status4. $status5;	$status6; $status7?>
			</div>
			<div id="msg"class="row">
			<?php echo $status6; ?>
			</div>
		</div>
	</form>
<?php	

}	//widget
			

} //class


function register_wp_tng_login_Widget2() {
     register_widget( 'wp_tng_login_Widget2' );
 }