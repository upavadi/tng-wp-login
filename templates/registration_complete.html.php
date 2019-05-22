<?php
function registration_complete($config) {
	if (isset($config['token'])) {
		$login_url = esc_url(site_url( 'wp-login.php', $_SERVER['PHP_SELF'] ));
		$Pw_reset_line = ("<a href='$login_url?action=lostpassword' title='Lost Password' id='LostP'><b>Reset My Password</b></a>");
	}
	
ob_clean();
ob_start();
?>

	<div class="container">
		<div class="regsubtitle">
			<div class='row' style="margin-left: 10px">
				<?php echo $config['title']; ?>
			</div>
		</div>	
		<div class="regsections col-sm-6" style="width: 550px">	
			<div class='row' style="margin-left: 10px">
			<p>
		<?php 	echo $config['line1']. "<b>". $_POST['firstname']. "</b> ". "<b>". $_POST['lastname']. ".</b><br />";
				echo $config['line2']; ?>
			</p>
			<p>
			<?php
				echo $config['line3'];
			?>
			<br />
			<?php
				echo $config['line4'];
			?>
			<P>
			<?php echo $Pw_reset_line; 
			
			?>
			</p>	

			</div>	
		</div>
	</div>
<?php
	return ob_get_clean();
	}
?>