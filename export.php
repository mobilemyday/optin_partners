<?php 
	
	ini_set('error_reporting', E_ALL); ini_set('display_errors', TRUE);
	
	$DB = mysqli_connect('localhost', 'root', 'root');
	mysqli_select_db($DB, 'optin');
	
	$rs = mysqli_query($DB, "SELECT * FROM optins where sent = 0");
	while($rw = mysqli_fetch_array($rs)) {
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL,"http://trends.mobilemyday.com/optins/patchpharma/");
		curl_setopt($ch, CURLOPT_POST, 1);
		$data = http_build_query($rw);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		mysqli_query($DB, "UPDATE optins set sent = 1 where id = '{$rw['id']}'");
	}
	
