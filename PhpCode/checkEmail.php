<?php 
session_start();

// Check if email field is valid
if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	// Store the email in a session
	$_SESSION['email'] = $_POST['email'];
	header("Location: ./PayPal/process.php?paypal=checkout");

}
else {
	header("Location: ../index.html");
}
 ?>