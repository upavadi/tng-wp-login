<?php
//Check to see that path to TNG folder is set

function update_init_paths() {
	$path_json = (__DIR__. '/config.json');
		$config = optionsConfig();
		$config_new = $config;
		$config_new["paths"]['tng_path'] = $_POST["tng_path"];
		$config_new['paths']['tng_url'] = $_POST['tng_url'];
		$config_new['paths']['tng_photo_folder'] = $_POST['tng_photo_folder'];
		$json = (json_encode($config_new, JSON_PRETTY_PRINT));
		$path = "config.json";
		//file_put_contents($path, $json);
		$suceess = "Changes Saved";
		return $config_new;
	}