
<?php
$servername = "localhost";
$username = "tysus636_wp7";
$password = "636H@Lst3@d_DEV";
$dbname = "tysus636_wp7";

//Cpen database connection
	    $conn = new mysqli($servername, $username, $password, $dbname);

	    // Check connection
	    if ($conn->connect_error) {
	        die("Connection failed: " . $conn->connect_error);
	    }
?>