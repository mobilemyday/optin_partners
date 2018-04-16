<?php 
	
	if(!mysqli_select_db($DB, 'optin')) {
		mysqli_query($DB, "CREATE DATABASE optin");
		mysqli_select_db($DB, 'optin');
		mysql_query($DB, 'DROP TABLE IF EXISTS optins');
		mysqli_query($DB, "CREATE TABLE `optins` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `code` varchar(24) DEFAULT NULL,
		  `sex` char(1) DEFAULT NULL,
		  `lastname` varchar(255) DEFAULT NULL,
		  `firstname` varchar(255) DEFAULT NULL,
		  `email` varchar(255) DEFAULT NULL,
		  `pointOfSaleName` varchar(255) DEFAULT NULL,
		  `street` varchar(255) DEFAULT NULL,
		  `number` varchar(10) DEFAULT NULL,
		  `box` varchar(10) DEFAULT NULL,
		  `city` varchar(255) DEFAULT NULL,
		  `zip` varchar(10) DEFAULT NULL,
		  `country` char(2) DEFAULT NULL,
		  `idSoftware` int(11) DEFAULT NULL,
		  `otherSoftware` varchar(255) DEFAULT NULL,
		  `software_has_change` char(1) DEFAULT NULL,
		  `old_idSoftware` int(11) DEFAULT NULL,
		  `old_otherSoftware` varchar(255) DEFAULT NULL,
		  `language` char(2) DEFAULT NULL,
		  `optin_mmd` tinyint(1) DEFAULT NULL,
		  `optin_partner` tinyint(1) DEFAULT NULL,
		  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		  `sent` tinyint(1) DEFAULT '0' NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;") or die(mysqli_error($DB));
		unlink($_SERVER['DOCUMENT_ROOT'].'/install.php');
	}
