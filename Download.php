<?php 
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
session_start();

// Check if the user has bought an album
if ($_SESSION['albumName'] == '') {
	exit("You do not have access to this page!");
	session_destroy();
}
else {

	// Get current time
	$currentTime = date('d-m-Y H:i:s');

	// Get expire time
	if (!isset($_SESSION['futureTime'])) {
		$_SESSION['futureTime'] = date('d-m-Y H:i:s', strtotime('+1 days'));
	}

	// Check if the page has expired
	if ($currentTime <= $_SESSION['futureTime']) {
		// Check which album to download
		switch ($_SESSION['albumName']) {

			// Download album 1
			case 'Hilyadi Belezi':
				downloadFile("PhpCode/Downloads/Хиляди белези.zip");
				break;

			// Download album 2
			case 'Vtoro Deistvie':
				downloadFile("PhpCode/Downloads/Второ действие.zip");
				break;
		}
	}
	else {
		session_destroy();
		exit("Access has expired");
	}

}
?>