<?php
//Admin Menu: WP-TNG Login
//Admin Submenu: Set Plugin Paths


function set_plugin_profile() {
	$config = optionsConfig();
	//$_SESSION['success'] = '';
	var_dump($_SESSION);
	$config_headers = ($config['show_profile']['sections']);
	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";
	
	if (isset($_POST['show_profile'])) {
		$success = update_profile();
		Header('Location: '.$_SERVER['REQUEST_URI'] . "&success=" . urlencode($success));
	//	var_dump($_SESSION['success']);
		$success = $_SESSION['success'];
		//echo "<meta http-equiv='refresh' content=$success>";
	}
	
	$section_count = 0;
	$section = $config['show_profile']['sections'];
	$section1_fields = $section[0]['fields'];
	$section2_fields = $section[1]['fields'];
	$section3_fields = $section[2]['fields'];
	
?>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__DIR__). '/css/newreg.css';?>">

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<div class="wrap container-fluid" style='width: auto'>

	<form class="form-group" action=''  method="post">
	<input type="hidden" class="form-control" width="auto" name="show_profile" id='show_profile' value=true >
	<div class="regsubtitle">
	Profile Template
	</div>
	<!-- Section One -->	
	<div>
		<b>Section One</b>
	</div>
	<div class="regsections col_md_10">	
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="header1">Header</label>
			<input type="text" class="form-control" width="auto" name="header1" id='header1' value= '<?php echo $config_headers[0]['label']; ?>'>
			</div>
		</div>
		<!-- First Name -->
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label1a">First Name</label>
			<input type="text" class="form-control" width="auto" name="label1a" id='label1a' value= '<?php echo $section1_fields[0]['label']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description1a">Description</label>
			<input type="text" class="form-control" width="auto" name="description1a" id='description1a' value= '<?php echo $section1_fields[0]['description']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder1a">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder1a" id='placeholder1a' value= '<?php echo $section1_fields[0]['placeholder']; ?>'>
			</div>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
		</div>
		<!-- Last Name -->
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label1b">Last Name</label>
			<input type="text" class="form-control" width="auto" name="label1b" id='label1b' value= '<?php echo $section1_fields[1]['label']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description1b">Description</label>
			<input type="text" class="form-control" width="auto" name="description1b" id='description1b' value= '<?php echo $section1_fields[1]['description']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder1b">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder1b" id='placeholder1b' value= '<?php echo $section1_fields[1]['placeholder']; ?>'>
			</div>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
		</div>
		<!-- Nick Name -->
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label1c">Nick Name</label>
			<input type="text" class="form-control" width="auto" name="label1c" id='label1c' value= '<?php echo $section1_fields[2]['label']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description1c">Description</label>
			<input type="text" class="form-control" width="auto" name="description1c" id='description1c' value= '<?php echo $section1_fields[2]['description']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder1c">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder1c" id='placeholder1c' value= '<?php echo $section1_fields[2]['placeholder']; ?>'>
			</div>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
		</div>
		
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label1d">Display Name</label>
			<input type="text" class="form-control" width="auto" name="label1d" id='label1d' value= '<?php echo $section1_fields[3]['label']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description1d">Description</label>
			<input type="text" class="form-control" width="auto" name="description1d" id='description1d' value= '<?php echo $section1_fields[3]['description']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder1d">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder1d" id='placeholder1d' value= '<?php echo $section1_fields[3]['placeholder']; ?>'>
			</div>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
		</div>
	</div>
	<!-- Section Two -->		
	<div style="margin-top: 10px">
	<b>Section Two</b>
	<div class="regsections">	
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="header2">Header</label>
			<input type="text" class="form-control" width="auto" name="header2" id='header2' value= '<?php echo $config_headers[1]['label']; ?>'>
			</div>
		</div>
		<!-- Login Name -->
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label2a">Login Name*</label>
			<input type="text" class="form-control" width="auto" name="label2a" id='label2a' value= '<?php echo $section2_fields[0]['label'];; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description2a">Description</label>
			<input type="text" class="form-control" width="auto" name="description2a" id='description2a' value= '<?php echo $section2_fields[0]['description']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder2a">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder2a" id='placeholder2a' value= '<?php echo $section2_fields[0]['placeholder']; ?>'>
			</div>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
		</div>
		<!-- Email -->
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label2b">Email</label>
			<input type="text" class="form-control" width="auto" name="label2b" id='label2b' value= '<?php echo $section2_fields[1]['label']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description2b">Description</label>
			<input type="text" class="form-control" width="auto" name="description2b" id='description2b' value= '<?php echo $section2_fields[1]['description']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder2b">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder2b" id='placeholder2b' value= '<?php echo $section2_fields[1]['placeholder']; ?>'>
			</div>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
		</div>
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label2c">User Password</label>
			<input type="text" class="form-control" width="auto" name="label2c" id='label2c' value= '<?php echo $section2_fields[2]['label']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description2c">Description</label>
			<input type="text" class="form-control" width="auto" name="description2c" id='description2c' value= '<?php echo $section2_fields[2]['description']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder2c">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder2c" id='placeholder2c' value= '<?php echo $section2_fields[2]['placeholder']; ?>'>
			</div>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
		</div>
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label2d">Re-enter Password</label>
			<input type="text" class="form-control" width="auto" name="label2d" id='label2d' value= '<?php echo $section2_fields[3]['label']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description2d">Description</label>
			<input type="text" class="form-control" width="auto" name="description2d" id='description2d' value= '<?php echo $section2_fields[3]['description']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder2d">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder2d" id='placeholder2d' value= '<?php echo $section2_fields[3]['placeholder']; ?>'>
			</div>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
		</div>
	</div>
	<!-- Section Three -->	
	<div style="margin-top: 10px">
	<b>Section Three</b>
	<div class="regsections">	
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="header3">Header3</label>
			<input type="text" class="form-control" width="auto" name="header3" id='header1' value= '<?php echo $config_headers[2]['label']; ?>'>
			</div>
		</div>
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label3a">Your Interest</label>
			<input type="text" class="form-control" width="auto" name="label3a" id='label3' value= '<?php echo $section3_fields[0]['label']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description3a">Description</label>
			<input type="text" class="form-control" width="auto" name="description3a" id='description3a' value= '<?php echo $section3_fields[0]['description']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder3a">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder3a" id='placeholder3a' value= '<?php echo $section3_fields[0]['placeholder']; ?>'>
			</div>
			<div  class='col-md-2'>
			<input type="checkbox" class="form-check-input" name="enabled3a" id="enabled3a" checked='checked'>
			<label for="enabled3a">Enabled</label>
			</div>
		</div>
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label3b">About You</label>
			<input type="text" class="form-control" width="auto" name="label3b" id='label3b' value= '<?php echo $section3_fields[1]['label']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description3b">Description</label>
			<input type="text" class="form-control" width="auto" name="description3b" id='description3b' value= '<?php echo $section3_fields[1]['description']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder3b">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder3b" id='placeholder3b' value= '<?php echo $section3_fields[1]['placeholder']; ?>'>
			</div>
			<div  class='col-md-2'>
			<input type="checkbox" class="form-check-input" name="enabled3b" id="enabled3b" checked='checked'>
			<label for="enabled3b">Enabled</label>
			</div>
		</div>
	</div>
		<p style="color: green; display: inline-block"><?php echo "<b>". $_GET['success']. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_profile" value="Update Profile Template">
	</p>
	</form>
</div>
	
<style>
#wpfooter {
display: none;
}
</style>

<?php
 } 