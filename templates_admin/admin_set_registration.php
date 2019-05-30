<?php
//Registration form template
//Admin Menu: WP-TNG Login
//Admin Submenu: Set Registration Page

function set_plugin_registration() {
	$config = optionsConfig();
	$config_headers = ($config['reg_form']['sections']);
	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";
			
	if(!isset($_POST['reg_form'])) {
		$post = read_reg_form();
	}
	
	if (isset($_POST['reg_form'])) {
		$post = $_POST;
		$success = update_registration();
		
	//	echo "<meta http-equiv='refresh' content=$success>";
		//Header('Location: '.$_SERVER['REQUEST_URI'] . "&success=" . urlencode($success));
	}
?>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__DIR__). '/css/wp_tng_login.css';?>">

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<div class="wrap">
<div class="container" style='width: auto'>
	<form class="form-group" action=''  method="post">
	<input type="hidden" class="form-control" width="auto" name="reg_form" id='reg_form' value=true >
	<div class="regsubtitle">
	Registration Form Template
	</div>
	<!-- Section One -->
	<p style="color: green; display: inline-block"><?php echo "<b>". $success. "</b><br />"; ?></p>
	<div>
		<b>Section One</b>
	</div>
	<div class="regsections col_md_10">	
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="header1">Header</label>
			<input type="text" class="form-control" width="auto" name="header1" id='header1' value= '<?php echo $post['header1']; ?>'>
			</div>
		</div>
		<!-- First Name -->
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label1a">First Name</label>
			<input type="text" class="form-control" width="auto" name="label1a" id='label1a' value= '<?php echo $post['label1a']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description1a">Description</label>
			<input type="text" class="form-control" width="auto" name="description1a" id='description1a' value= '<?php echo $post['description1a']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder1a">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder1a" id='placeholder1a' value= '<?php echo $post['placeholder1a']; ?>'>
			</div>
			<div class='col-md-2'>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
			</div>
		</div>
		<!-- Last Name -->
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label1b">Last Name</label>
			<input type="text" class="form-control" width="auto" name="label1b" id='label1b' value= '<?php echo $post['label1b']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description1b">Description</label>
			<input type="text" class="form-control" width="auto" name="description1b" id='description1b' value= '<?php echo $post['description1b']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder1b">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder1b" id='placeholder1b' value= '<?php echo $post['placeholder1b']; ?>'>
			</div>
			<div  class='col-md-2'>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
			</div>
		</div>
		<!-- Nick Name -->
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label1c">Nick Name</label>
			<input type="text" class="form-control" width="auto" name="label1c" id='label1c' value= '<?php echo $post['label1c']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description1c">Description</label>
			<input type="text" class="form-control" width="auto" name="description1c" id='description1c' value= '<?php echo $post['description1c']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder1c">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder1c" id='placeholder1c' value= '<?php echo $post['placeholder1c']; ?>'>
			</div>
			<div  class='col-md-2'>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
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
			<input type="text" class="form-control" width="auto" name="header2" id='header2' value= '<?php echo $post['header2']; ?>'>
			</div>
		</div>
		<!-- Login Name -->
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label2a">Login Name*</label>
			<input type="text" class="form-control" width="auto" name="label2a" id='label2a' value= '<?php echo $post['label2a'];; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description2a">Description</label>
			<input type="text" class="form-control" width="auto" name="description2a" id='description2a' value= '<?php echo $post['description2a']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder2a">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder2a" id='placeholder2a' value= '<?php echo $post['placeholder2a']; ?>'>
			</div>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
		</div>
		<!-- Email -->
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label2b">Email</label>
			<input type="text" class="form-control" width="auto" name="label2b" id='label2b' value= '<?php echo $post['label2b']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description2b">Description</label>
			<input type="text" class="form-control" width="auto" name="description2b" id='description2b' value= '<?php echo $post['description2b']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder2b">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder2b" id='placeholder2b' value= '<?php echo $post['placeholder2b']; ?>'>
			</div>
			<div  class='col-md-2 col-ms-2' style="color:red">
			<br />Required
			</div>
		</div>
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label2c">User Password</label>
			<input type="text" class="form-control" width="auto" name="label2c" id='label2c' value= '<?php echo $post['label2c']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description2c">Description</label>
			<input type="text" class="form-control" width="auto" name="description2c" id='description2c' value= '<?php echo $post['description2c']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder2c">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder2c" id='placeholder2c' value= '<?php echo $post['placeholder2c']; ?>'>
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
			<input type="text" class="form-control" width="auto" name="header3" id='header1' value= '<?php echo $post['header3']; ?>'>
			</div>
		</div>
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label3a">Your Interest</label>
			<input type="text" class="form-control" width="auto" name="label3a" id='label3' value= '<?php echo $post['label3a']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description3a">Description</label>
			<input type="text" class="form-control" width="auto" name="description3a" id='description3a' value= '<?php echo $post['description3a']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder3a">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder3a" id='placeholder3a' value= '<?php echo $post['placeholder3a']; ?>'>
			</div>
			<div  class='col-md-2'>
			<input type="checkbox" class="form-check-input" name="enabled3a" id="enabled3a"  <?php if($post['enabled3a']) echo "checked='checked'"; ?>>
			<label for="enabled3a">Enabled</label>
			</div>
		</div>
		<div class="row rowadjust">
			<div  class='col-md-3'>
			<label for="label3b">About You</label>
			<input type="text" class="form-control" width="auto" name="label3b" id='label3b' value= '<?php echo $post['label3b']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="description3b">Description</label>
			<input type="text" class="form-control" width="auto" name="description3b" id='description3b' value= '<?php echo $post['description3b']; ?>'>
			</div>
			<div  class='col-md-3'>
			<label for="placeholder3b">Place Holder</label>
			<input type="text" class="form-control" width="auto" name="placeholder3b" id='placeholder3b' value= '<?php echo $post['placeholder3b']; ?>'>
			</div>
			<div  class='col-md-2'>
			<input type="checkbox" class="form-check-input" name="enabled3b" id="enabled3b"  <?php if($post['enabled3b']) echo "checked='checked'"; ?>>
			<label for="enabled3a">Enabled</label>
			</div>
		</div>
	</div>
	<p style="color: green; display: inline-block; padding-left: 25px"><?php echo "<b>". $success. "<b><br />"; ?></p>
	<p>
	<input type="submit" name="update_Registration" value="Update Registration Template" style="width: auto">
	</p>
	</form>
</div>


</div><!-- end class container -->	
</div><!-- end class wrap -->	
<style>
#wpfooter {
display: none;
}
</style>

<?php
 } 