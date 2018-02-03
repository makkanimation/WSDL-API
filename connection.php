<?php

	globle $con;
	$con = mysqli_connect("localhost","root","","wsdl");

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}



?>