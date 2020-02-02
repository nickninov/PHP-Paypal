<?php 

	error_reporting(E_ALL); 
	error_reporting(E_ALL & ~E_NOTICE | E_STRICT); 
	ini_set("display_errors", "1");
	
	// Begin the shopping cart session
	session_start();

	/*
		Check if the shopping cart is null.
		If the shopping cart is null a new array will be created.
	*/
	if(empty($_SESSION['cart'])){
		// Create a new array
		$_SESSION['cart'] = array();
	}

 ?>