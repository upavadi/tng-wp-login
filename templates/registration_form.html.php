<?php
function input($field, $label, $description, $placeholder, $value, $error, $type = 'text') {
	$errorClass = '';
	if ($error) {
		$errorClass = 'has-error';
	}
	
	if (($_POST)) {
		$newreg_entries = (validate($_POST)); 
		$userExists = $newreg_entries['userExists'];
		$emailExists = $newreg_entries['emailExists'];

		if (!$newreg_entries || $emailExists ) {	
			echo newreg_complete(); return null;
		}
	}
	
	if ($_POST && $data['errors']) {
		echo "<div class='text-danger'>Please check for errors</div>";
	}
?>
<!DOCTYPE html>
<!-- add bootstrap here instead of primary file to avoid conflicts with other plugins -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<html lang="en">
<script src='https://www.google.com/recaptcha/api.js'></script>	

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

function registration_form($data, $config, $intro, $configPrivacy, $keys) {
	//global $data;
ob_start(); 
$privacyText = $configPrivacy['line1'];
$privacyConsent = $configPrivacy['enabled'];
$showPrivacyDocLink =  $configPrivacy['show_privacy_doc_link'];    
$privacyDoc = "";
if ($showPrivacyDocLink)
$privacyDoc = "<a href=" . $configPrivacy['privacyDoc']. ' target="_blank">Our Privacy Policy</a> '; 
$message = $intro['line1']. $intro['line2']. $intro['line3']. $intro['line4']. $intro['line5']. $intro['line6'];
?>

<div class="container">
<form action="" method="post">
<?php
if (($intro['enabled'])) {
?>
<div class="regsubtitle"><?php echo $intro['title']; ?></div>
<div class="regsections"><?php echo $message; ?></div>
<?php
if ($_POST && $data['errors']) {
	echo "<div class='text-danger'><strong>Please check for errors</strong></div>";
}
}
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

if($privacyConsent) { 
	?>
	<div class="regsections">	
	 <p>
	 <input type="checkbox" name="consentGiven" id="consentGiven" <?php if(isset($_POST['consentGiven'])) echo "checked='checked'"; ?>> 
	 <?php echo $privacyText. " ". $privacyDoc; ?> </p>
	 <div class="text-danger"><?php echo $data['errors']['consentGiven'] ?></div>
	 </div>
	 <?php
	}
if ($_POST && $error) {
	echo "<div class='text-danger'>Please check for errors</div>";
}

if ($keys['enabled']) {
?>
<div style="color: red" id="alertText"><br /></div>
<div class="g-recaptcha" style="margin-left: 20px" data-sitekey="<?php echo $keys['key1']; ?>"></div>
<script>
function varified(event) {
console.log(event)
console.log(grecaptcha.getResponse())
if (grecaptcha.getResponse() == ""){
    document.getElementById("alertText").innerHTML = "<b>Please verify that you are not a robot.";
	document.getElementById("theForm").value="";
	} else {
    document.getElementById("theForm").submit();
}
return;
}
</script>
<?php
}
?>

<input style="margin-top: 10px" type="submit" onclick="varified()" id="reg_submit" value="Submit Request">

</form>
</div>
</div><!--container-->

</html>
<?php
}