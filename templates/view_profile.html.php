<?php
function inputProfile($field, $label, $description, $placeholder, $value, $error, $type = 'text') {
	$errorClass = '';	
	if(isset($_POST['submitProfile'])){
	$value = $_POST[$field];
	}
	if ($error) {
		$errorClass = 'has-error';
	}
?>
<!-- add bootstrap here instead of primary file to avoid conflucts with other plugins -->	
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<div class="row rowadjust <?php echo $errorClass; ?>">
	<div class="col-md-2 entrylabel"><?php echo $label; ?></div>
	<div class="col-md-4">
		<input type="<?php echo $type; ?>" 
			   class="form-control" 
			   name="<?php echo $field; ?>" 
			   placeholder="<?php echo $placeholder; ?>" 
			   value="<?php echo $value; ?>"
			   <?php
			   
			   if ($field == "user_login" || $field == "user_pass") {
			   ?>
			   readonly
			   <?php
			   }
			   ?>
			   >
	</div>
	<div class="col-md-6"><?php echo $description; ?></div>
</div>
<?php if ($error): ?>
<div class="row rowadjust">
	<div class="col-md-12">
		<p class="text-danger"><?php echo $error; ?></p>
	</div>
</div>
<?php endif; ?>
<?php
}
global $data, $data_meta;
function view_profile($data, $data_meta, $def_photo_path, $config) {
	global $nickname, $count, $error, $user_meta_values;
	/** array for display name dropdown **/
	$display_meta = ($data_meta['values']);
	$NickName = $data_meta['values']['nickname'][0];
	$FirstName = $data_meta['values']['first_name'][0];
	$LastName = $data_meta['values']['last_name'][0];
	$display_data = $data['values']->data;
	$userName = $display_data->user_login;
	$FirstLastName = $FirstName. " ". $LastName;
	$LastFirstName = $LastName. " ". $FirstName;
	$DisplayedName = $display_data->display_name;
	$DropDownArray = array($NickName, $userName, $FirstName, $LastName, $FirstLastName, $LastFirstName);


ob_start();
$tngUrl = getTngUrl();
$tngPhotoFolder = getTng_photo_folder();
$photopath = $tngUrl. $tngPhotoFolder. "/". $def_photo_path;

?>

<div class="container-fluid">
<?php
if ($def_photo_path) { ?>
<img src="<?php echo $photopath; ?>">
<?php } ?>
<form method="post">
<?php

	//$count = 0;
foreach ($config['sections'] as $section) {
?>

	<div class="regsubtitle"><?php echo $section['label']; ?></div>
		<div class="regsections">
		<?php
		$detail = ($section['fields']);
		foreach($section['fields'] as $spec) {
			$field = $spec['name'];
			$user_meta_values = ($data_meta['values']); 
			$data_value = $spec['name'];
			
			$value = null;
			if (isset($user_meta_values[$data_value]))
				$value = $user_meta_values[$data_value][0];
				
			if (isset($data['errors'][$field]))
				$error = $data['errors'][$field] ?: '';
			if (!$value) {
				$user_data = ($data['values']);
				$value = ($user_data -> $data_value);
			}
			
			$dataArray[$count] = ($value);
			$count = $count + 1;
			if ($spec['textenabled'] === false && $spec['name'] !== "display_name" ) {
		inputProfile($spec['name'], $spec['label'], $spec['description'], $spec['placeholder'], $value, $error, $spec['type']);
			} elseif ($spec['name'] == "display_name") {
		
		?>
			<div class="row rowadjust">
			<div class="col-md-2 entrylabel"><?php echo $spec['label']; ?></div>
			<div class="col-md-4">
			<select name="<?php echo $spec['name']; ?>" class="form-control">
			<?php
			forEach ($DropDownArray as $value) {
			?>
			<option value="<?php echo $value; ?>" ><?php echo $value; ?></option>
			<?php 
			if ($value == $DisplayedName) {
			?>
			<option value="<?php echo $value; ?>" selected><?php echo $value; ?></option>
			<?php
			}
			} 
			?>	
			</select>
			</div>
		<div class="col-md-4 entrylabel"><?php echo $spec['description']; ?></div>	
		</div>	
		<?php
			} elseif ($spec['textenabled'] === true ) {
			
			?>
		<div class="row rowadjust"><!-- for textarea -->
			<div class="col-md-2 entrylabel"><?php echo $spec['label']; ?></div>
			<div class="col-md-6"><textarea name="<?php echo $data_value; ?>" placeholder="<?php echo $spec['placeholder']; ?>" class="form-control"><?php echo $value; ?></textarea></div>
			<div class="col-md-4 entrylabel"><?php echo $spec['description']; ?></div>
		</div>
		<?php
		}
	}
?>
</div>
<?php		
	}

	?>

</div>

<input type="submit" name="submitProfile" id="profile_submit" value="Update Your Profile">
</form>
</div><!--container-->
<?php

return ob_get_clean();
}