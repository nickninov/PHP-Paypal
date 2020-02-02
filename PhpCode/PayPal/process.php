<?php
session_start();
include_once("config.php");
include_once("functions.php");

// Paypal Class
include_once("paypal.class.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

// PayPal variable
$paypal= new MyPayPal();

function downloadFile($file) {
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	ob_clean();
	flush();
	readfile($file);
	exit;
}

// Post Data received from product list page.
if(_GET('paypal') =='checkout'){

	// prepare products
	
	/*
		Mainly 4 variables are needed from product page Item Name, Item Price, Item Number and Item Quantity.

		!!!WARNING!!! People can manipulate hidden field amounts in form,
		Store items in $products array
	*/

	$products = [];


	// Check if digital album Hyladi Belezi was selected
	if ($_SESSION['album'] == 1) {

		// Item Name
		$products[0]['ItemName'] = 'Digital Album Hilyadi Belezi';

		// Item Price
		$products[0]['ItemPrice'] = 11;

		// Item Number
		$products[0]['ItemNumber'] = 1;

		// Item Number
		$products[0]['ItemDesc'] = 'Digital Album Hilyadi Belezi';

		// Item Quantity
		$products[0]['ItemQty']	= 1; 

		// Charges
		$charges = [];

		//Sum of tax for all items in this order. 
		$charges['TotalTaxAmount'] = 0;  

		//Handling cost for this order.
		$charges['HandalingCost'] = 0; 

		// Shipping insurance cost for this order. 
		$charges['InsuranceCost'] = 0;  

		//Shipping discount for this order. Specify this as negative number.
		$charges['ShippinDiscount'] = 0; 

		$charges['ShippinCost'] = 0; 


		// Set a $_SESSION['albumName'] to the digital album's name
		$_SESSION['albumName'] = 'Hilyadi Belezi';

		// Express checkout
		// SetExpressCheckOut obtains the paypal token
		$paypal->SetExpressCheckOut($products, $charges);
	}

	// Check if digital album Vtoro Deistvie was selected
	elseif ($_SESSION['album'] == 2) {

		// Item Name
		$products[0]['ItemName'] = 'Digital Album Vtoro Deistvie';

		// Item Price
		$products[0]['ItemPrice'] = 11;

		// Item Number
		$products[0]['ItemNumber'] = 1;

		// Item Number
		$products[0]['ItemDesc'] = 'Digital Album Vtoro Deistvie';

		// Item Quantity
		$products[0]['ItemQty']	= 1; 

		// Charges
		$charges = [];

		//Sum of tax for all items in this order. 
		$charges['TotalTaxAmount'] = 0;  

		//Handling cost for this order.
		$charges['HandalingCost'] = 0; 

		// Shipping insurance cost for this order. 
		$charges['InsuranceCost'] = 0;  

		//Shipping discount for this order. Specify this as negative number.
		$charges['ShippinDiscount'] = 0; 

		$charges['ShippinCost'] = 0; 


		// Set a $_SESSION['albumName'] to the digital album's name
		$_SESSION['albumName'] = 'Vtoro Deistvie';

		// Express checkout
		// SetExpressCheckOut obtains the paypal token

		$paypal->SetExpressCheckOut($products, $charges);
	}

	// Non virtual items
	else {

		/// Set a $_SESSION['albumName'] to nothing - no digital downloads are added here
		$_SESSION['albumName'] = '';

		// Add regular shopping cart

		//Sum of tax for all items in this order. 
		$charges['TotalTaxAmount'] = 0;  

		//Handling cost for this order.
		$charges['HandalingCost'] = 0; 

		// Shipping insurance cost for this order. 
		$charges['InsuranceCost'] = 0;  

		//Shipping discount for this order. Specify this as negative number.
		$charges['ShippinDiscount'] = 0; 

		$charges['ShippinCost'] = 0; 

		// Set variables for digital download
		$isAlbumAdded = false;


		// Express checkout
		// SetExpressCheckOut obtains the paypal token

		$paypal->SetExpressCheckOut($products, $charges);
	}
}
elseif(_GET('token')!=''&&_GET('PayerID')!=''){
	
	/*
		Paypal redirects back to this page using ReturnURL.
		We should receive TOKEN and Payer ID
		We will be using these two variables to execute the "DoExpressCheckoutPayment"
		Note: we haven't received any payment yet.
	*/
	
	$paypal->DoExpressCheckoutPayment();

	// After payment is executed

	/*
		Check if the transaction was successful and
		if the $_SESSION['albumName'] is not empty.
		This allows to download albums
	*/

	if (defined('transaction') && $_SESSION['albumName'] != '') {

		// Get expire time
		if (!isset($_SESSION['futureTime'])) {
			$_SESSION['futureTime'] = date('d-m-Y H:i:s', strtotime('+1 days'));
		}

		// ---------------------------------------------------------------------------
		// Send email

		$mail = new PHPMailer;

		// Set mailer to use SMTP
		$mail->isSMTP();

		// Specify main and backup SMTP servers                       
		$mail->Host = 'smtp.gmail.com';

		// Enable SMTP authentication
		$mail->SMTPAuth = true;

		// SMTP username
		$mail->Username = 'ndoe.website.order@gmail.com';

		// SMTP password
		$mail->Password = 'ndoendoe2019';

		// Enable TLS encryption, `ssl` also accepted
		$mail->SMTPSecure = 'tls';  

		// TCP port to connect to    
		$mail->Port = 587;

		// Who is the sender and their name
		$mail->setFrom('ndoe.website.order@gmail.com', 'NDOE Store');

		// Who is receiving the email
		$mail->addAddress($_SESSION['email']);

		// Set email format to HTML
		$mail->isHTML(true);

		// Body Content
		$bodyContent = "<h1>Thank you for your purchase!</h1>";
		$bodyContent .= "<a href=\"http://www.nickninov.com/tOpSeCrEt/Download.php\">Download album</a>";
		$bodyContent .= "<h2>Your link expires: ".$_SESSION['futureTime']."</h2>";

		// Email's subject
		$mail->Subject = 'Digital album';

		// Attach body content to $mail 
		$mail->Body = $bodyContent;

		// Check if message was sent 
		if (!$mail->send()) {
			// If email was unsuccessfully sent then initiate the download here
			$message = "Email could not be sent.<br>Album will be downloaded here";

			// Get current time
			$currentTime = date('d-m-Y H:i:s');

			// Check if the page has expired
			if ($currentTime <= $_SESSION['futureTime']) {
				// Check which album to download
				switch ($_SESSION['albumName']) {

					// Download album 1
					case 'Hilyadi Belezi':
						downloadFile("../Downloads/Хиляди белези.zip");
						break;

					// Download album 2
					case 'Vtoro Deistvie':
						downloadFile("../Downloads/Второ действие.zip");
						break;
				}
			}

		} 
		else {
			
			$message = "Email has been sent to {$_SESSION['email']}";

			// Check if the page has expired
			if ($currentTime <= $_SESSION['futureTime']) {
				// Check which album to download
				switch ($_SESSION['albumName']) {

					// Download album 1
					case 'Hilyadi Belezi':
						downloadFile("../Downloads/Хиляди белези.zip");
						break;

					// Download album 2
					case 'Vtoro Deistvie':
						downloadFile("../Downloads/Второ действие.zip");
						break;
				}
			}

		}
	}


}
else{
	exit("<h1>You do not have access to this page</h1>");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>NDOE</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset='utf-8'>
	<link rel="stylesheet" type="text/css" href="../../style.css">
	<link rel="icon" type="image/jpg" href="../../images/index/Yellow.png">
</head>

<body id="indexBody">

	<div id="downloadWrapper">
		<h3><?php echo $message."<br>Link expires: {$_SESSION['futureTime']}"; ?></h3>
	</div>
</body>
</html>