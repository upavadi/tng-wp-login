<?php
function registration_complete($config) {
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

			</div>	
		</div>
	</div>
<?php
	return ob_get_clean();
	}
?>