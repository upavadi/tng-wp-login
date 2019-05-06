<?php
//Registration form template
//Admin Menu: WP-TNG Login
//Admin Submenu: Set Registration Messages

function set_plugin_reg_messages() {
	$config = optionsConfig();
	$config_headers = ($config['reg_form']['sections']);
	$action_url = plugin_dir_url( __DIR__ ). "options_update.php";

		if (isset($_POST['reg_message'])) {
			$success = update_reg_complete();
			Header('Location: '.$_SERVER['REQUEST_URI'] . "&success=" . urlencode($success));
		}
	
	
?>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__DIR__). '/css/newreg.css';?>">
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__DIR__). '/css/wp_tng_login.css';?>">

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<div class="container">
	<form class="form-group" action=''  method="post">

	<div class="regsubtitle">
	Registration Messages
	</div>
	<div class="row">
		<div class="regsections" >
		<label for="regcomplete_title" class="col-sm-2 col-md-1 col-lg-1 col-form-label">Title</label>
		<input type="text" class="form-control" width="auto" name="regcomplete_title" id="regcomplete_title inputs" value="<?php echo $regComplete['title']; ?>">
		</div>
	</div>
	
</div>

<!--------------------Reg Messages --------------------------------------------->
<div class="container">
<form class="form-group" action=''  method="post">
	<input type="hidden" class="form-control" width="auto" name="reg_message" id='reg_message' value=true >
	<div class="regsubtitle">
	Registration Messages
	</div>
	<div>
	<b>Registration Success</b>
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $_GET['success']. "</b><br />"; ?></p>
	<div class="regsections  col-md-12 col-sm-12">	
		<div class="form-group row">
		<label for="regcomplete_title" class="col-sm-2 col-md-1 col-lg-1 col-form-label">Title</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" width="auto" name="regcomplete_title" id="regcomplete_title inputs" value="<?php echo $regComplete['title']; ?>">
			</div>
		</div>
		<div class="form-group row">
		<label for="regcomplete_line1" class="col-sm-2 col-md-1 col-lg-1 col-form-label">Line 1</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" name="regcomplete_line1" id="regcomplete_line1 inputs" value="<?php echo $regComplete['line1']; ?>">
			</div> 
		</div>
		<div class="form-group row">
		<label for="regcomplete_line2" class="col-sm-2 col-md-1 col-lg-1 col-form-label">Line 2</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" name="regcomplete_line2" id="regcomplete_line2 inputs" value="<?php echo $regComplete['line2']; ?>">
			</div> 
		</div>
		<div class="form-group row">
		<label for="regcomplete_line3" class="col-sm-2 col-md-1 col-lg-1 col-form-label">Line 3</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" name="regcomplete_line3" id="regcomplete_line3 inputs" value="<?php echo $regComplete['line3']; ?>">
			</div>
		</div>
		<div class="form-group row">
		<label for="regcomplete_line4" class="col-sm-2 col-md-1 col-lg-1 col-form-label">Line 4</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" name="regcomplete_line4" id="regcomplete_line2 inputs" value="<?php echo $regComplete['line4']; ?>">
			</div> 
		</div>
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $_GET['success']. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_Reg_success" value="Update Registration Success" style="width: auto">
	</p>
	</div>
</form>
</div>

<div class="container">
<form class="form-group" action=''  method="post">
	<div>
		<b>New Registration email</b>
	</div>
	<div class="regsections  col-md-12 col-sm-12">	
	<div class="form-group row">
		<label for="regcomplete_title" class="col-sm-2 col-md-1 col-lg-1 col-form-label">Title</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" name="regcomplete_title" id="regcomplete_title inputs" value="<?php echo $regComplete['title']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="regcomplete_line1" class="col-sm-2 col-md-1 col-lg-1 col-form-label">Line 1</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" name="regcomplete_line1" id="regcomplete_line1 inputs" value="<?php echo $regComplete['line1']; ?>">
		 </div> 
	</div>
	<div class="form-group row">
		<label for="regcomplete_line2" class="col-sm-2 col-md-1 col-lg-1 col-form-label">Line 2</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" name="regcomplete_line2" id="regcomplete_line2 inputs" value="<?php echo $regComplete['line2']; ?>">
		 </div> 
	</div>
	<div class="form-group row">
		<label for="regcomplete_line3" class="col-sm-2 col-md-1 col-lg-1 col-form-label">Line 3</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" name="regcomplete_line3" id="regcomplete_line3 inputs" value="<?php echo $regComplete['line3']; ?>">
		 </div>
	</div>
	<div class="form-group row">
		<label for="regcomplete_line4" class="col-sm-2 col-md-1 col-lg-1 col-form-label">Line 4</label>
		<div class="col-sm-8">
		<span>  <input type="text" class="form-control" name="regcomplete_line4" id="regcomplete_line2 inputs" value="<?php echo $regComplete['line4']; ?>"></span>
		</div> 
	</div>
	</div>
	<p style="color: green; display: inline-block"><?php echo "<b>". $success. "</b><br />"; ?></p>
	<p>
	<input type="submit" name="update_Reg_success" value="Update New Registration Email" style="width: auto">
	</p>
	</div>
	
	
</form>
</div>
	<style>
#wpfooter {
display: none;
}
</style>
	<?php
	}
	?>