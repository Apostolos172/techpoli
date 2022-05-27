
<?php // login.php

if (isset($_POST['submitted'])) {

	require_once ('../libraries/php/login_functions.inc.php');
	require_once ('../../mysqli_connect.php');
	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['psw']);
	
	if ($check) { // OK!
			
		// Set the session data:.
		session_start();
		$_SESSION['customer_id'] = $data['customer_id'];
		$_SESSION['first_name'] = $data['first_name'];
		$_SESSION['last_name'] = $data['last_name'];
		$_SESSION['email'] = $data['email'];
		
		// Redirect:
		//$url = absolute_url ('loggedin.php');
		$url = absolute_url ('account_page.php');
		header("Location: $url");
		exit();
			
	} else { // Unsuccessful!
		$errors = $data;
	}
		
	mysqli_close($dbc);

} // End of the main submit conditional.

include ('login_page.php');
?>
