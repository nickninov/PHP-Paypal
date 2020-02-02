<?php

  // Start session in all pages
	if (session_status() == PHP_SESSION_NONE) {
		session_start(); 
	}

	// sandbox or live
	define('PPL_MODE', 'sandbox');

	if(PPL_MODE=='sandbox'){
		
		// Sandbox
		// https://developer.paypal.com/developer/accounts/
		// API Credentials

		define('PPL_API_USER', 'sb-d147bj109519_api1.business.example.com');
		define('PPL_API_PASSWORD', 'YBTRG4LN7Y8AD6FS');
		define('PPL_API_SIGNATURE', 'AENcxPw24Z2XdJF2St4-ROlimKUVA5sKmPTwrinDbkd.rZ3n1zz51R9t');
	}
	else{
		// NDOE's details - must change
		define('PPL_API_USER', 'somepaypal_api.yahoo.co.uk');
		define('PPL_API_PASSWORD', '123456789');
		define('PPL_API_SIGNATURE', 'opupouopupo987kkkhkixlksjewNyJ2pEq.Gufar');
	}
	
	define('PPL_LANG', 'EN');
	
	// define('PPL_LOGO_IMG', 'http://localhost:8888/Paypal-Express-Checkout-Example-master/Yellow.png');
	
	define('PPL_RETURN_URL', 'http://www.nickninov.com/tOpSeCrEt/PhpCode/PayPal/process.php');
	define('PPL_CANCEL_URL', 'http://www.nickninov.com/tOpSeCrEt/TOPSECRET/index.html');

	define('PPL_CURRENCY_CODE', 'EUR');
