<?php
$wp_path = find_wp_path(); // not sure why I have to find this
require_once ($wp_path.'/wp-load.php');
require_once "newreg_config.php";
require_once "login-to-wp.php";
require_once "login-to-tng.php";
//UPDATE IGNORE `tng_users` SET `dt_consented`='0000-00-00 00:00:00' WHERE `username` = 'gondal'
//add_action( 'wp_login', 'checkConsent' );

$current_user_consent = newRegPrivacy();
$current_user_consent_text = $current_user_consent['current_user_consent_text'];
$privacy_doc_url = newRegPrivacy()['privacyDoc'];

function checkConsent() {
  $wpConsent = "";
  $wpCurrentUser = wp_get_current_user() -> user_login;
  $wpUserId = get_current_user_id();
  $userMeta = get_user_meta($wpUserId);
  $tngUser = getTngUserName($wpCurrentUser);

  //if user is 'admin' ignore
  if (roleTng() == 'admin') return;
  
  if (isset($userMeta['tng_dateconsented'])) $wpConsent = $userMeta['tng_dateconsented'];

  $tngConsent = getTngConsent();
  if ($wpConsent > 0 && $tngConsent > 0)
    {
    // echo "consented";
     return; //wp and tng consented
    }

 //consent in wp only
  if ($wpConsent > 0 && $tngConsent == 0) {
   // echo "consent in wp only";
    $success = updateTngConsent();
  }

  //consent in tng only
  if (!$wpConsent && $tngConsent > 0) {
  //  echo "consent in tng only";
    update_user_meta($wpUserId, 'tng_dateconsented', date('Y-m-d h:i:s'));
    
  }
  
  $logoutUrl = (wp_logout_url(home_url()));
  $logoutUrl = str_replace('&amp;', '&' ,$logoutUrl);
  
  if (!$wpConsent && ($tngConsent == 0 || !$tngConsent)) {
     if(!$_GET['value']) {
        echo '<script type="text/javascript">',
          'getConfirmation();',
          '</script>';
    }
     
    if (!isset($_GET['value'])) return;
     
    $response =  $_GET['value'];
    
     /** user presses OK - udate consent flags in WP and TNG ***/
    if ($response == "true") {
      
      update_user_meta($wpUserId, 'tng_dateconsented', date('Y-m-d h:i:s'));
        return;
    }
      /** user presses cancel - LogOut and return ***/
     if ($response == "false") {
        echo '<script>window.location = "'.$logoutUrl.'";</script>'; 
        return;
      }
       
  return;
    }
}

function updateTngConsent() {
  $tngPath = getSubroot(). "config.php"; 
  include ($tngPath);
  $wpCurrentUser = wp_get_current_user() -> user_login;
  $dt_consented = date('Y-m-d h:i:s');
  $db = mysqli_connect($database_host, $database_username, $database_password, $database_name);

  $sql = "UPDATE tng_users SET dt_consented='$dt_consented' WHERE username='$wpCurrentUser' ";
  $success = mysqli_query($db, $sql);
  return $success;
}

//UPDATE IGNORE `tng_users` SET `dt_consented`='0000-00-00 00:00:00' WHERE `username` = 'gondal'
function getTngConsent() {
	$tng_path = getSubroot(). "config.php";
	include ($tng_path); 
	$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	$wpCurrentUser = wp_get_current_user() -> user_login;
	$sql = "SELECT * FROM tng_users WHERE username='$wpCurrentUser'";
	$result = $db->query($sql);
	if ($result) {
		$row = $result->fetch_assoc();
		$tng_consent = $row["dt_consented"];
	return $tng_consent;
	}
}
?>
<input type="text" id="alerttext" value="<?php echo $current_user_consent_text; ?>" hidden>
<script>
 function getConfirmation() {
   
   var consentText = document.getElementById("alerttext").value
    var retVal = confirm(consentText);
    if (retVal == true) {
      window.location.href = '/login-consent.php?value=true';
    
    } else {
      window.location.href = '/login-consent.php?value=false';
    }
    return;   
  }
</script>