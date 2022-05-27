
<?php // orders.php

// Εδώ φαίνονται όλες οι παραγγελίες που έχουν πραγματοποιηθεί στο ηλεκτρονικό κατάστημα
// Φτάνεις εδώ από το μενού του περιβάλλοντος με την επιλογή Orders

	$page_title = 'Orders';
	require_once "../html/header.html";
?>
<main class="main">

	<h1>Orders</h1>

<?php

require_once ('../libraries/php/createElements.php'); // library
require_once ('../../mysqli_connect.php'); // Connect to the db.

// Make the query:
$q = "	
SELECT order_id AS oid, customers.customer_id, CONCAT_WS(' ',first_name,last_name) AS name, total, status, order_date,
	shipping_method, billing_method
FROM orders JOIN customers ON orders.customer_id=customers.customer_id
ORDER BY order_date DESC;
";	
						
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.
	
	putH('Πρώτα η πιο πρόσφατη παραγγελία');
	openTable();
		openRow();
			th('Id παραγγελίας','5%');
			th('Id πελάτη','5%');
			th('Ονοματεπώνυμο','30%');
			th('Ποσό','10%');
			th('Κατάσταση','10%');
			th('Ημερομηνία πραγματοποίησης','20%');
			th('Τρόπος παραλαβής','10%');
			th('Τρόπος πληρωμής','10%');
		closeRow();	
	// Fetch and print all the records:
	while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		openRow();
			td("<a href='order.php?oid={$row['oid']}'>{$row['oid']}</a>");
			td("{$row['customer_id']}");
			td("{$row['name']}");
			td("{$row['total']}".' €');
			td("{$row['status']}");
			td("{$row['order_date']}");
			td("{$row['shipping_method']}");
			td("{$row['billing_method']}");
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