<?php
function input($field, $label, $description, $placeholder, $value, $error, $type = 'text') {
	$errorClass = '';	
	if ($error) {
		$errorClass = 'has-error';
	}
	
	if (($_POST)) {
		$newreg_entries = (validate($_POST));
		if (!$newreg_entries) {	
			echo newreg_complete(); return null;
		}
	}
	
	/**
	if (isset($_POST['loginname'])) {
		$newreg_entries = (validate($_POST));
		$newreg_entries = $newreg_entries['emailExists'];
		//var_dump(validate($_POST)); ///// work on this ***************************
		//echo newreg_complete();
		return "newreg";
	}
	**/
?>
<div class="row rowadjust <?php echo $errorClass; ?>">
	<div class="col-md-2 entrylabel"><?php echo $label; ?></div>
	<div class="col-md-4">
		<input type="<?php echo $type; ?>" 
			   class="form-control" 
			   name="<?php echo $field; ?>" 
			   placeholder="<?php echo $placeholder; ?>" 
			   value="<?php echo $value; ?>">
	</div>
	<div class="col-md-3"><?php echo $description; ?></div>
</div>

<?php if ($error): ?>
<div class="row rowadjust">
	<div class="col-md-8">
		<p class="text-danger"><?php echo $error; ?></p>
	</div>
</div>
<?php endif; 
}

function registration_form($data, $config, $keys) {
ob_start();
?>

<div class="container">
<form action="" method="post">
<?php
	foreach ($config['sections'] as $section) {
?>
	<div class="regsubtitle"><?php echo $section['label']; ?></div>
	<div class="regsections">
<?php
	foreach($section['fields'] as $spec) {
		$field = $spec['name'];
		if ($spec['enabled'] === false)
			{
			continue;
			}
		if ($spec['textenabled'] === false)
		{
		$value = $data['values'][$field];
		$error = $data['errors'][$field] ?: '';
		
		$res = input($field, $spec['label'], $spec['description'], $spec['placeholder'], $value, $error, $spec['type']);
		if ($res === "newreg") {
			return;
		}
		} else {
		$value = $data['values'][$field];
?>
	<div class="row rowadjust"><!--Interest -->
			<div class="col-md-2 entrylabel"><?php echo $spec['label']; ?></div>
			<div class="col-md-6"><textarea class="form-control" name="<?php echo $spec['name']; ?>" placeholder="<?php echo $spec['placeholder']; ?>"><?php echo $value; ?></textarea></div>
	</div>
<?php
		}
	}
?>
</div>
<?php		
	}

?>
	
<div id="alertText"><br /></div>
<input type="submit" onclick="varified()" value="Submit Request">
</form>
</div>
</div><!--container-->
<?php
	
}

