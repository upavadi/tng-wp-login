<?php
//TNG Paths are derived from TNG config.php.
require_once (__DIR__. '/../newreg_config.php');

function set_plugin_paths() {
	global $success;
	global $wpdb;
	if (!$_POST) {	
		$config = optionsConfig();
		$config_paths = ($config['paths']);
		$_POST['tng_path'] = $config_paths['tng_path'];
		$_POST['tng_url'] = $config_paths['tng_url'];
		$_POST['tng_photo_folder'] = $config_paths['tng_photo_folder'];		
	}
	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
	}
	
	if (isset($_POST['Update_Paths'])) {
		$success = "";
		update_paths();
		$success = update_paths();
	}
	
?>
<head>

<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__DIR__). '/css/wp_tng_login.css';?>">

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<div class="wrap container"  style='width: auto'>

	<form class="form-group" action=''  method="post">
	<div class="regsubtitle">
	Plugin Paths:-
	</div>
	<div style="color: red">
	These values would have been setup on first activation. Values mirror values in config.php, in TNG root
	</div>
	<div class="rowadjust regsections">	
		<div class="row">
			<div class='col-md-2' style="width: 155px">
				TNG Root Path: 
			</div>
			<div  class='col-md-3'>	
				<input type="text" class="form-control" name="tng_path" value= '<?php echo $_POST['tng_path']; ?>'>
			</div>
			<div  class='col-md-6'>
			TNG Root Path is absolute path to TNG. You may look this up from TNG Admin Setup or config.php ($rootpath) in TNG folder.
			</div>
		</div>
		<div class="row rowadjust">
			<div class='col-md-2' style="width: 155px">
			TNG URL:
			</div>
			<div  class='col-md-3'>	
				<input type="text" class="form-control" name="tng_url" value= '<?php echo $_POST['tng_url']; ?>'>
			</div>
			<div  class='col-md-6'>
			TNG URL is path to TNG (http://www.mysite.com/tng). You may look this up from TNG Admin Setup or config.php ($tngdomain) in TNG folder.
			</div>
		</div>
		<div class="row rowadjust">
			<div class='col-md-2' style="width: 155px">
			TNG Photo Folder:
			</div>
			<div  class='col-md-3'>	
				<input type="text" class="form-control" name="tng_photo_folder" value= '<?php echo $_POST['tng_photo_folder']; ?>'>
			</div>
			<div  class='col-md-6'>
			Name of TNG Photo Folder. Derived from TNG setup.
			</div>
		</div>

	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="Update_Paths" value="Update Paths">
	</p>
	
	</form>
</div>
<?php
}