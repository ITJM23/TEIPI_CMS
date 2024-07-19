<?php
	
	// ============ Canteen Database ============
		$servername1 	= "localhost";
		$username1 		= "root";
		$password1 		= "";
		//$dbname1 		= "canteen2";
		$dbname1 		= "canteen_rice";

		$con = mysqli_connect($servername1, $username1, $password1, $dbname1);
	// ============ Canteen Database END ========



	// ============ HR Admin Database ============
		$servername2 	= "localhost";
		$username2 		= "root";
		$password2 		= "";
		$dbname2 		= "teipi_emprice";

		$con2 = mysqli_connect($servername2, $username2, $password2, $dbname2);
	// ============ HR Admin Database END ========	


?>