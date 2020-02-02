<?php 
	// Checks if an album is selected
	// Checks if $_GET['album'] is with a value different from 1 or 2
	if (!isset($_GET['album']) || ($_GET['album'] !== '1' && $_GET['album'] !== '2')) {
			exit("<h1>You do not have access to this page</h1>");
	}

	else {
		session_start();
		
		// Checks which album is selected
		switch ($_GET['album']) {
		 	case '1':
		 		// For Hilyadi Belezi - 1
		 		$_SESSION['album'] = 1;
		 		break;
		 	
		 	case '2':
		 		// For Vtoro Deistvie - 2
		 		$_SESSION['album'] = 2;
		 		break;
		 }
	}	
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>NDOE</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset='utf-8'>
	<link rel="stylesheet" type="text/css" href="../style.css">

	<link rel="icon" type="image/jpg" href="../images/index/Yellow.png">

	<!-- Icons -->
	<link rel="stylesheet" type="text/css" href="../TextInputEffects/css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="../TextInputEffects/fonts/font-awesome-4.2.0/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="../TextInputEffects/css/demo.css" />
	<link rel="stylesheet" type="text/css" href="../TextInputEffects/css/set1.css" />
</head>

<body id="emailBody">

	<div id="centText">
		<form action="./checkEmail.php" method="POST">
			
			<span class="input input--kyo">
				<input class="input__field input__field--kyo" type="text" id="input-19" name="email" />
				<label class="input__label input__label--kyo" for="input-19">
					<span class="input__label-content input__label-content--kyo">What's your email?
					</span>
				</label>
			</span>
			<br>
			<input type="submit" value="Buy" class="addButton">
		</form>
	</div>

<script src="../TextInputEffects/js/classie.js"></script>
<script>
	(function() {
		if (!String.prototype.trim) {
			(function() {
				// Make sure we trim BOM and NBSP
				var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
				String.prototype.trim = function() {
					return this.replace(rtrim, '');
				};
			})();
		}

		[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
			// in case the input is already filled..
			if( inputEl.value.trim() !== '' ) {
				classie.add( inputEl.parentNode, 'input--filled' );
			}

			// events:
			inputEl.addEventListener( 'focus', onInputFocus );
			inputEl.addEventListener( 'blur', onInputBlur );
		} );

		function onInputFocus( ev ) {
			classie.add( ev.target.parentNode, 'input--filled' );
		}

		function onInputBlur( ev ) {
			if( ev.target.value.trim() === '' ) {
				classie.remove( ev.target.parentNode, 'input--filled' );
			}
		}
	})();
</script>

</body>
</html>