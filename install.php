<?php 
	
	if(!mysqli_select_db($DB, 'optin')) {
		mysqli_query($DB, "CREATE DATABASE optin");
		mysqli_select_db($DB, 'optin');
		mysqli_query($DB, "CREATE TABLE `optins` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `code` varchar(24) DEFAULT NULL,
		  `responsible_name` varchar(255) DEFAULT NULL,
		  `email` varchar(255) DEFAULT NULL,
		  `language` char(2) DEFAULT NULL,
		  `software` varchar(24) DEFAULT NULL,
		  `software_other` varchar(50) DEFAULT NULL,
		  `optin_mmd` tinyint(1) DEFAULT NULL,
		  `optin_patchpharma` tinyint(1) DEFAULT NULL,
		  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		  `sent` tinyint(1) DEFAULT '0' NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;") or die(mysqli_error($DB));
		unlink($_SERVER['DOCUMENT_ROOT'].'/install.php');
	}
	
