
<?php // customers.php

// Εδώ φαίνονται όλοι οι πελάτες στο ηλεκτρονικό κατάστημα
// Φτάνεις εδώ από το μενού του περιβάλλοντος με την επιλογή Customers

	$page_title = 'Customers';
	require_once "../html/header.html";
?>
<main class="main">

	<h1>Customers</h1>

<?php

require_once ('../libraries/php/createElements.php'); // library
require_once ('../../mysqli_connect.php'); // Connect to the db.

// Make the query:
$q = "	
SELECT customers.customer_id AS cid, customers.first_name, customers.last_name, customers.email, 
	DATE_FORMAT(customers.registration_date, '%M %d, %Y') AS registration_date,
	SUM(total) AS incomeFromThisCustomer, COUNT(*) AS numberOfOrders
FROM customers JOIN orders ON customers.customer_id=orders.customer_id
GROUP BY customers.customer_id
ORDER BY registration_date ASC;
";	
						
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.
	
	putH('Πρώτος ο παλιότερος, εγγεγραμμένος πιο παλιά');
	openTable();
		openRow();
			th('Id πελάτη','10%');
			th('Όνομα πελάτη','10%');
			th('Επώνυμο','10%');
			th('Email','20%');
			th('Ημερομηνία εγγραφής','20%');
			th('Έσοδα από τον πελάτη','10%');
			th('Παραγγελίες που έχει πραγματοποιήσει','20%');
		closeRow();	
	// Fetch and print all the records:
	while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		openRow();
			td("{$row['cid']}");
			td("{$row['first_name']}");
			td("{$row['last_name']}");
			td("{$row['email']}");
			td("{$row['registration_date']}");
			td("{$row['incomeFromThisCustomer']}".' €');
			td("{$row['numberOfOrders']}");
		closeRow();
	}

	closeTable();
	
	mysqli_free_result ($r); // Free up the resources.	
}
else {
	p('There was a problem');
}
	
// Make the query:
$q = "	
SELECT customers.customer_id AS cid, customers.first_name, customers.last_name, customers.email, 
	DATE_FORMAT(customers.registration_date, '%M %d, %Y') AS registration_date,
	SUM(total) AS incomeFromThisCustomer, COUNT(*) AS numberOfOrders
FROM customers JOIN orders ON customers.customer_id=orders.customer_id
GROUP BY customers.customer_id
ORDER BY incomeFromThisCustomer DESC;
";	
						
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.
	
	putH('Πρώτος αυτός που μας έχει φέρει τα περισσότερα κέρδη');
	openTable();
		openRow();
			th('Id πελάτη','10%');
			th('Όνομα πελάτη','10%');
			th('Επώνυμο','10%');
			th('Email','20%');
			th('Ημερομηνία εγγραφής','20%');
			th('Έσοδα από τον πελάτη','10%');
			th('Παραγγελίες που έχει πραγματοποιήσει','20%');
		closeRow();	
	// Fetch and print all the records:
	while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		openRow();
			td("{$row['cid']}");
			td("{$row['first_name']}");
			td("{$row['last_name']}");
			td("{$row['email']}");
			td("{$row['registration_date']}");
			td("{$row['incomeFromThisCustomer']}".' €');
			td("{$row['numberOfOrders']}");
		closeRow();
	}

	closeTable();
	
	mysqli_free_result ($r); // Free up the resources.	
}
else {
	p('There was a problem');
}

// Make the query:
$q = "	
SELECT customers.customer_id AS cid, customers.first_name, customers.last_name, customers.email, 
	DATE_FORMAT(customers.registration_date, '%M %d, %Y') AS registration_date,
	SUM(total) AS incomeFromThisCustomer, COUNT(*) AS numberOfOrders
FROM customers JOIN orders ON customers.customer_id=orders.customer_id
GROUP BY customers.customer_id
ORDER BY numberOfOrders DESC;
";	
						
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.
	
	putH('Πρώτος αυτός που μας έχει πραγματοποιήσει τις περισσότερες παραγγελίες');
	openTable();
		openRow();
			th('Id πελάτη','10%');
			th('Όνομα πελάτη','10%');
			th('Επώνυμο','10%');
			th('Email','20%');
			th('Ημερομηνία εγγραφής','20%');
			th('Έσοδα από τον πελάτη','10%');
			th('Παραγγελίες που έχει πραγματοποιήσει','20%');
		closeRow();	
	// Fetch and print all the records:
	while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		openRow();
			td("{$row['cid']}");
			td("{$row['first_name']}");
			td("{$row['last_name']}");
			td("{$row['email']}");
			td("{$row['registration_date']}");
			td("{$row['incomeFromThisCustomer']}".' €');
			td("{$row['numberOfOrders']}");
		closeRow();
	}

	closeTable();
	
	mysqli_free_result ($r); // Free up the resources.	
}
else {
	p('There was a problem');
}

mysqli_close($dbc);

?>

</main>
<?php
	require_once "../html/footer.html";
?>