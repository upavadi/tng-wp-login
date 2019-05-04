<?php
function input($field, $label, $description, $placeholder, $value, $error, $type = 'text') {
	$errorClass = '';	
	if ($error) {
		$errorClass = 'has-error';
	}
	
	
	if (isset($_POST['loginname'])) {
		$newreg_entries = (validate($_POST));
		$newreg_entries = $newreg_entries['emailExists'];
		echo newreg_complete();
		return "newreg";
	}

?>
<div class="row rowadjust <?php echo $errorClass; ?>">
	<div class="col-md-2 entrylabel"><?php echo $label; ?>
	</div>
	<div class="col-md-4">
		<input type="<?php echo $type; ?>" 
			   class="form-control" 
			   name="<?php echo $field; ?>" 
			   placeholder="<?php echo $placeholder; ?>" 
			   value="<?php echo $value; ?>">
	</div>
	<div class="col-md-3"><?php echo $description; ?>
	</div>
</div>
<?php if ($error): ?>
<div class="row rowadjust">
	<div class="col-md-8">
		<p class="text-danger"><?php echo $error; ?></p>
	</div>
</div>
<?php endif; ?>
<?php
}


function registration_form($data, $config, $keys) {
ob_start();

if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
if(!$captcha && $_POST){
          $captchaAlert = '<h2>Please check the the captcha form.</h2>';
          
    }

$redirect = "plugin_dir_url( __DIR__ ). 'newregcomplete.php'";
?>



<div class="container">
<form action="" method="post">
<?php
	foreach ($config['sections'] as $section) {
?>
	<div class="regsubtitle"><?php echo $section['label']; ?>
	</div>
	<div class="regsections">
<?php
		foreach($section['fields'] as $spec) {
			$field = $spec['name'];
			if ($spec['enabled'] === false) {
		
			continue;
			}
			if ($spec['textenabled'] === false) {
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
<!--
	<div class="captcha g-recaptcha" data-sitekey="<?php echo $keys['key1']; ?>"></div>
-->	
<?php //echo $captchaAlert; 
	$error1 = $data['errors']['firstname'];
	$error2 = $data['errors']['lastname'];
	$error3 = $data['errors']['loginname'];
	$error4 = $data['errors']['email'];
	
	if (isset ($error1)) {
	$error_prompt = "First Name: ". $error1;
	}
	if (isset ($error2)) {
	$error_prompt = $error_prompt. ", Last Name: ". $error2;
	}
	if (isset ($error3)) {
	$error_prompt = $error_prompt. ", User Name: ". $error3;
	}
	if (isset ($error4)) {
	$error_prompt = $error_prompt. ", Email: ". $error4;
	}
	
?>
	
<div style='color: red'><?php echo $error_prompt; ?></div>
    <div id="alertText"><br /></div>
	<input type="submit" onclick="varified()" value="Submit Request">
</form>
<script src='https://www.google.com/recaptcha/api.js'></script>
	</div>
</div><!--container-->
<?php
		
	return;
}
/** SCRIPT CAUSES TNG.PHP TO MISBEHAVE - NOT SHOWING IMAGES
?>
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
**/
