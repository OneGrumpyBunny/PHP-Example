<!-- admin screen -->
<?php 
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
		include 'dbconn.php';	
		include 'config.php';
		include 'globalconfig.php';
	  	include $globals["INCL_DIR"].'header.php';

		if ($_SESSION['accessprivs'] == "Admin") {
    		include $globals["ADMIN_DIR"].'index.php';
    	}
?>


