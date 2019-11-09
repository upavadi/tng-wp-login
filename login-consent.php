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
if(isset($current_user_consent['privacyDoc']))
$privacy_doc_url = newRegPrivacy()['privacyDoc'];

function checkConsent() { 

  $wpConsent = "";
  $wpCurrentUser = wp_get_current_user() -> user_login;
  $wpUserId = get_current_user_id();
  $userMeta = get_user_meta($wpUserId, $key = '', $single=false);
  $tngUser = getTngUserName($wpCurrentUser);
  $tngRole = roleTng();
  $wpRole = current_user_can('administrator'); 
  $tngVersion = guessTngVersion();

  if ($tngVersion < 12) $tngTen = true;
  if ($tngVersion >= 12) $tngTwelve = true;
  
  // user is 'admin' ignore and return
  if ($tngRole == 'admin' || $wpRole == true) return;
   
  if (isset($userMeta['tng_dateconsented'])) $wpConsent = $userMeta['tng_dateconsented'][0];
  
  //tng version 12+
  if ($tngTwelve) 
  {
     $tngConsent = getTngConsent();
  } 
 
  //check if consent in both or v10 in use
  if ($wpConsent && ($tngConsent > 0 || $tngTen == true ))
  {
    //echo "consented";
    return; //wp and tng consented
  }
  
  //consent in wp and not V12
  if ($wpConsent > 0 && (isset($tngTen))) return;
 
  if ($wpConsent > 0 && ($tngConsent == 0) ) {
    
    if($tngTwelve) $success = updateTngConsent();
    return; 
  }
  
  //consent in tng only
  if (!$wpConsent && ($tngConsent>0 && $tngTwelve )) {
    //echo "consent in tng only";
    update_user_meta($wpUserId, 'tng_dateconsented', date('Y-m-d h:i:s'));
    return;
  }
  
//process consent
  $logoutUrl = (wp_logout_url(home_url()));
  $logoutUrl = str_replace('&amp;', '&' ,$logoutUrl);
  
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
      $success = updateTngConsent();
        return;
    }
      /** user presses cancel - LogOut and return ***/
     if ($response == "false") {
        echo '<script>window.location = "'.$logoutUrl.'";</script>'; 
        return;
      }
  return;
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

<?php
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

function updateTngConsent() {
  $tngVersion = guessTngVersion();
  if($tngVersion < 12) return ''; 
  $tngPath = getSubroot(). "config.php"; 
  include ($tngPath);
  $wpCurrentUser = wp_get_current_user() -> user_login;
  $dt_consented = date('Y-m-d h:i:s');
  $db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
  $stmt = $db->prepare("UPDATE tng_users SET dt_consented= ? WHERE username = ?");
$stmt->bind_param("ss", $dt_consented, $wpCurrentUser);
$success = $stmt->execute();
$stmt->close();
return $success;
}