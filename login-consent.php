<?php
$wp_path = find_wp_path(); // not sure why I have to find this
require_once ($wp_path.'/wp-load.php');
require_once "newreg_config.php";
require_once "login-to-wp.php";
require_once "login-to-tng.php";
//add_action( 'wp_login', 'checkConsent' );

function checkConsent() {
  $wpCurrentUser = wp_get_current_user() -> user_login;
  $wpUserId = get_current_user_id();
  $userMeta = get_user_meta($wpUserId);
  $tngUser = getTngUserName($wpCurrentUser);
  $wpConsent = $userMeta['tng_dateconsented'];
  $tngConsent = getTngConsent();
  $logoutUrl = (wp_logout_url(home_url()));
  $logoutUrl = str_replace('&amp;', '&' ,$logoutUrl);
  if (!$wpConsent && ($tngConsent == 0 || !$tngConsent)) {
     $_GET['value'] == null;
     if($_GET['value'] == null)
        echo '<script type="text/javascript">',
          'getConfirmation();',
          '</script>';
      }
      $response =  $_GET['value'];

      
      /** user presses OK - udate consent flags in WP and TNG ***/
      if ($response == "true") {



      }

      /** user presses cancel - LogOut and return ***/
      if ($response == "false") {
        var_dump($logoutUrl);
        echo '<script>window.location = "'.$logoutUrl.'";</script>'; 
        return;
      }
return;
}


function updateWpConsent() {



  
}


?>
<script>
 function getConfirmation() {
               var retVal = confirm("I give my consent to upavadi.net to store the personal information collected here. I understand that I may ask the site owner to remove this information at any time.");
                if (retVal == true) {
                  window.location.href = 'http://localhost/login-consent.php?value=true';
               
                } else {
                  window.location.href = 'http://localhost/login-consent.php?value=false';
                 }
                


    return;   
  }
</script>