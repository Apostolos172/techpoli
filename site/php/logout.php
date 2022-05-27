
<?php //logout.php

// This page lets the user logout.

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';
include ('../html/head.html');

// If no session variable exists, redirect the user:
if (!isset($_SESSION['customer_id'])) {

	require_once ('../libraries/php/login_functions.inc.php');
	$url = absolute_url('login.php');
	header("Location: $url");
	exit();

} else { // Cancel the session.

	$_SESSION = array(); // Clear the variables.
	session_destroy(); // Destroy the session itself.
}
?>
<body>
	<header>
		<?php include "../html/navigation.html"; ?>
	</header>
	<main class="main logout">
		<h1>Logged Out!</h1>
		<p>You are now logged out!</p>
		<p>
			Θα ανακατευθυνθείτε σε 7 δευτερόλεπτα στην αρχική σελίδα του καταστήματος. 
			Καλή συνέχεια!
		</p>
		<script>redirectionTo_In("../../index.php",7000);</script>
	</main>
	<?php 
		include ('../html/footer.html'); 
		endPage();
	?>
