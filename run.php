<?php 
	
	$DB = mysqli_connect('localhost', 'root', 'root');
	@include_once('install.php');
	mysqli_select_db($DB, 'optin') or die(mysqli_error($DB));
	
	$data = $_POST['form'];
	
	$query = "INSERT INTO optins SET";
	foreach($data as $key => $val) {
		$join[] = " `$key` = '$val'";
	}
	$query .= join(',', $join);
	mysqli_query($DB, $query) or die(mysqli_error($DB));