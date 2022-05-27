
<?php // account_page.php 

// The user is redirected here from login.php,
// or if he is connected, he has access here from the menu.

$page_title = 'Ο λογαριασμός μου';
require_once "../html/head.html";

// If no session value is present, redirect the user:
if (!isset($_SESSION['customer_id'])) {
	require_once ('../libraries/php/login_functions.inc.php');
	$url = absolute_url('login.php');
	header("Location: $url");
	exit();
}
?>

	<body>
		<header class="header">
		<?php
			include "../html/navigation.html";
		?>
		</header>
		<main class="info_container">
			<div class="aside">
				<br>
				<ul class="sticky">
					<li><a href="account_page.php">Ο λογαριασμός μου</a></li>
					<li><a href="basket.php">Το καλάθι μου</a></li>
					<li><a href="favourite.php">Τα αγαπημένα μου</a></li>
					<li><a href="orders_page.php">Οι παραγγελίες μου</a></li>
					<li><a href="logout.php">Αποσύνδεση</a></li>
				</ul>
			</div>
			<div class="main">
				<h1>Καλώς ήρθες, <?php echo "{$_SESSION['first_name']} {$_SESSION['last_name']}"?>!</h1>
				<div class="grid">
				<div>
				<table>
				<caption>Τα στοιχεία μου</caption>
				<tr><td>Όνομα:</td><td><?php echo "{$_SESSION['first_name']}";?></td></tr>
				<tr><td>Επώνυμο:</td><td><?php echo "{$_SESSION['last_name']}";?></td></tr>
				<tr><td>Email:</td><td><?php echo "{$_SESSION['email']}";?></td></tr>
				</table>
				</div>
				<div>
				<table class="orders">
				<caption>Οι πρόσφατες παραγγελίες μου</caption>
				<tr><th>Νο παραγγελίας</th><th>Ημερομηνία</th></tr>
				
<?php
	require_once ('../../mysqli_connect.php'); // Connect to the db.
		
	// Make the query:
	$q = "	SELECT order_id AS oid, DATE_FORMAT(order_date, '%M %d, %Y') AS order_date
			FROM orders
			WHERE customer_id={$_SESSION['customer_id']}
			ORDER BY order_date DESC, order_id DESC
			LIMIT 2;";	
						
	$r = @mysqli_query ($dbc, $q); // Run the query.

	// Count the number of returned rows:
	$num = mysqli_num_rows($r);

	if ($num > 0) { // If it ran OK, display the records.
		
		// Fetch and print all the records:
		while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
			echo "<tr><td><a href='orders_page.php?oid={$row['oid']}'>{$row['oid']}</a></td><td>At: {$row['order_date']}</td></tr>";
		}
		
		mysqli_free_result ($r); // Free up the resources.	
	}
	lineBreak();	
?>
				
				<tr><td colspan="2">Δες όλες τις παραγγελίες σου <a href="orders_page.php">εδώ</a></td></tr>
				</table>
				</div>
				</div>
			</div>
		</main>
		<?php 
			require_once "../html/footer.html";
		?>
	</body>
</html>
