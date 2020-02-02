<?php

	class MyPayPal {
		
		function GetItemTotalPrice($item){
		
			// (Item Price x Quantity = Total) Get total amount of product;
			return $item['ItemPrice'] * $item['ItemQty']; 
		}
		
		function GetProductsTotalAmount($products){
		
			$ProductsTotalAmount=0;

			foreach($products as $p => $item){
				
				$ProductsTotalAmount = $ProductsTotalAmount + $this -> GetItemTotalPrice($item);	
			}
			
			return $ProductsTotalAmount;
		}
		
		function GetGrandTotal($products, $charges){
			
			// Total - all tax, insurance, shipping cost and discount
			
			$GrandTotal = $this -> GetProductsTotalAmount($products);
			
			foreach($charges as $charge){
				
				$GrandTotal = $GrandTotal + $charge;
			}
			
			return $GrandTotal;
		}
		
		function SetExpressCheckout($products, $charges, $noshipping='1'){
			
			// Parameters for SetExpressCheckout, which are be sent to PayPal
			
			$padata  = 	'&METHOD=SetExpressCheckout';
			
			$padata .= 	'&RETURNURL='.urlencode(PPL_RETURN_URL);
			$padata .=	'&CANCELURL='.urlencode(PPL_CANCEL_URL);
			$padata .=	'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE");
			
			foreach($products as $p => $item){
				
				$padata .=	'&L_PAYMENTREQUEST_0_NAME'.$p.'='.urlencode($item['ItemName']);
				$padata .=	'&L_PAYMENTREQUEST_0_NUMBER'.$p.'='.urlencode($item['ItemNumber']);
				$padata .=	'&L_PAYMENTREQUEST_0_DESC'.$p.'='.urlencode($item['ItemDesc']);
				$padata .=	'&L_PAYMENTREQUEST_0_AMT'.$p.'='.urlencode($item['ItemPrice']);
				$padata .=	'&L_PAYMENTREQUEST_0_QTY'.$p.'='. urlencode($item['ItemQty']);
			}		

			$padata .=	'&NOSHIPPING='.$noshipping; 

			$padata .=	'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($this -> GetProductsTotalAmount($products));
			
			$padata .=	'&PAYMENTREQUEST_0_TAXAMT='.urlencode($charges['TotalTaxAmount']);
			$padata .=	'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($charges['ShippinCost']);
			$padata .=	'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($charges['HandalingCost']);
			$padata .=	'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($charges['ShippinDiscount']);
			$padata .=	'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($charges['InsuranceCost']);
			$padata .=	'&PAYMENTREQUEST_0_AMT='.urlencode($this->GetGrandTotal($products, $charges));
			$padata .=	'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode(PPL_CURRENCY_CODE);
			
			// Paypal custom template

			// PayPal page to match the language of the website;
			$padata .=	'&LOCALECODE='.PPL_LANG; 

			// Site's logo
			// $padata .=	'&LOGOIMG='.PPL_LOGO_IMG;

			// Border color of cart
			$padata .=	'&CARTBORDERCOLOR=FFFFFF'; 
			$padata .=	'&ALLOWNOTE=1';
						
			// Set session variable that will be needed later for DoExpressCheckoutPayment
			$_SESSION['ppl_products'] =  $products;
			$_SESSION['ppl_charges'] 	=  $charges;
			
			$httpParsedResponseAr = $this->PPHttpPost('SetExpressCheckout', $padata);
			
			// Respond according to message we receive from Paypal
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){

				$paypalmode = (PPL_MODE=='sandbox') ? '.sandbox' : '';
			
				// Redirect user to PayPal store with Token received.
				$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
				
				header('Location: '.$paypalurl);
			}
			else{
				
				//Show error message
				echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			}	
		}		
		
			
		function DoExpressCheckoutPayment(){
			
			if(!empty(_SESSION('ppl_products'))&&!empty(_SESSION('ppl_charges'))){
				
				$products=_SESSION('ppl_products');
				
				$charges=_SESSION('ppl_charges');
				
				$padata  = 	'&TOKEN='.urlencode(_GET('token'));
				$padata .= 	'&PAYERID='.urlencode(_GET('PayerID'));
				$padata .= 	'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE");
				
				// Set item details here or product details won't be seen later	
				foreach($products as $p => $item){
					
					$padata .=	'&L_PAYMENTREQUEST_0_NAME'.$p.'='.urlencode($item['ItemName']);
					$padata .=	'&L_PAYMENTREQUEST_0_NUMBER'.$p.'='.urlencode($item['ItemNumber']);
					$padata .=	'&L_PAYMENTREQUEST_0_DESC'.$p.'='.urlencode($item['ItemDesc']);
					$padata .=	'&L_PAYMENTREQUEST_0_AMT'.$p.'='.urlencode($item['ItemPrice']);
					$padata .=	'&L_PAYMENTREQUEST_0_QTY'.$p.'='. urlencode($item['ItemQty']);
				}
				
				$padata .= 	'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($this -> GetProductsTotalAmount($products));
				$padata .= 	'&PAYMENTREQUEST_0_TAXAMT='.urlencode($charges['TotalTaxAmount']);
				$padata .= 	'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($charges['ShippinCost']);
				$padata .= 	'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($charges['HandalingCost']);
				$padata .= 	'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($charges['ShippinDiscount']);
				$padata .= 	'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($charges['InsuranceCost']);
				$padata .= 	'&PAYMENTREQUEST_0_AMT='.urlencode($this->GetGrandTotal($products, $charges));
				$padata .= 	'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode(PPL_CURRENCY_CODE);
				
				// "DoExpressCheckoutPayment" needs to be executed at to receive payment from user.
				
				$httpParsedResponseAr = $this->PPHttpPost('DoExpressCheckoutPayment', $padata);
					

				// Check if everything went alright.
				if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){

					// echo '<h2>Success</h2>';
					// echo 'Your Transaction ID : '.urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);

					/*
						Sometimes Payment are kept pending even when transaction is complete. 
						We need to notify user about it and ask him manually approve the transiction
					*/
					
					if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]){
						// Payment was successful

						// echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';

						define("transaction", "completed");

					}
					elseif('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]){
						// Payment is still pending

						// echo '<div style="color:red">Transaction Complete, but payment may still be pending! '.
						// 'If that\'s the case, You can manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';

						define("transaction", "pending");
					}
					
				}
				else{
						
					// echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
					
					// Redirect to NDOE error page
				}
			}
		}
				
		function GetTransactionDetails(){
		
			// we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
			// GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
			
			$padata = 	'&TOKEN='.urlencode(_GET('token'));
			
			$httpParsedResponseAr = $this->PPHttpPost('GetExpressCheckoutDetails', $padata, PPL_API_USER, PPL_API_PASSWORD, PPL_API_SIGNATURE, PPL_MODE);

			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
				
				// echo '<br /><b>Stuff xD to store in database :</b><br /><pre>';
				
				// echo '<pre>';
				
				// 	print_r($httpParsedResponseAr);
					
				// echo '</pre>';
			}
			
			else  {
				
				// echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
				
				// echo '<pre>';
				
				// 	print_r($httpParsedResponseAr);
					
				// echo '</pre>';

			}
		}
		
		function PPHttpPost($methodName_, $nvpStr_) {
				
				// Set up your API credentials, PayPal end point, and API version.
				$API_UserName = urlencode(PPL_API_USER);
				$API_Password = urlencode(PPL_API_PASSWORD);
				$API_Signature = urlencode(PPL_API_SIGNATURE);
				
				$paypalmode = (PPL_MODE=='sandbox') ? '.sandbox' : '';
		
				$API_Endpoint = "https://api-3t".$paypalmode.".paypal.com/nvp";
				$version = urlencode('109.0');
			
				// Set the curl parameters.
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
				curl_setopt($ch, CURLOPT_VERBOSE, 1);
				//curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
				
				// Turn off the server and peer verification (TrustManager Concept).
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
			
				// Set the API operation, version, and API signature in the request.
				$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
			
				// Set the request as a POST FIELD for curl.
				curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
			
				// Get response from the server.
				$httpResponse = curl_exec($ch);
			
				if(!$httpResponse) {
					exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
				}
			
				// Extract the response details.
				$httpResponseAr = explode("&", $httpResponse);
			
				$httpParsedResponseAr = array();
				foreach ($httpResponseAr as $i => $value) {
					
					$tmpAr = explode("=", $value);
					
					if(sizeof($tmpAr) > 1) {
						
						$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
					}
				}
			
				if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
					
					exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
				}
			
			return $httpParsedResponseAr;
		}
	}
