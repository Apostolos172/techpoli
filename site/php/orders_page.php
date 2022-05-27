
	<?php // orders_page.php
	
	// Σελίδα προβολής των παραγγελιών χρήστη
	// και σε περίπτωση επιλογής και μιας δεδομένης παραγγελίας φορτώνεται εκ νέου με τις πληροφορίες
	// 	για τη συγκεκριμένη παραγγελία να βρίσκονται στην κορυφή της σελίδας και τις συνολικές παραγγελίες
	// 	να φαίνονται από κάτω 
	
		$page_title = "Οι παραγγελίες μου";
		require_once "../html/head.html";
		require_once "../libraries/php/createElements.php"; 
	?>
	<body>
		<header class="header">
		<?php
			include "../html/navigation.html";
		?>
		</header>
		<main class="main general_main">
		
<?php

require_once ('../../mysqli_connect.php'); // Connect to the db.

if(isset($_SESSION['customer_id']))
{
		
	if(isset($_GET['oid']))
	{
		// Make the query:
		$q = "	SELECT o.order_id AS oid, oc.product_id AS pid, oc.quantity AS q, oc.price, p.name, 
					p.price AS pricePerPiece, p.path_the_img_file AS img
				FROM orders AS o JOIN orders_contents AS oc ON o.order_id=oc.order_id 
					JOIN products AS p ON p.product_id=oc.product_id
				WHERE o.order_id={$_GET['oid']}
				ORDER BY oc.product_id ASC;";	
						
		$r = @mysqli_query ($dbc, $q); // Run the query.
		
		// Count the number of returned rows:
		$num = mysqli_num_rows($r);

		if ($num > 0) { // If it ran OK, display the records.
			$temp = 'Παραγγελία Νο: '.$_GET['oid'];
			putH($temp);
			echo "<div class='list_of_products_in_order'>";
			
						echo "	<div>
						<span><b>Κωδικός προϊόντος</b></span>
						<span><b>Προϊόν</span></b>
						<span><b>Όνομα προϊόντος</span></b>
						<span><b>Τιμή τεμαχίου</b></span>
						<span><b>Ποσότητα</b></span>
						<span><b>Συνολικό ποσό</b></span>
						</div>";
						lineBreak();
			
			// Fetch and print all the records:
			while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
				$temp = $row['pricePerPiece']*$row['q'];
				echo "	<div>
						<span><span> {$row['pid']}</span></span>
						<span><img src={$row['img']}></span>
						<span><span> {$row['name']}</span></span>
						<span><span> {$row['price']} €</span></span>
						<span><span> {$row['q']}</span></span>
						<span><span> $temp €</span></span>
						</div>";
				//lineBreak();	
			}
			echo "</div>";
			hr();
			mysqli_free_result ($r); // Free up the resources.	
		}
		lineBreak();
	
	}
		
	// Make the query:
	$q = "	SELECT order_id AS oid, total, status, shipping_method, billing_method, DATE_FORMAT(order_date, '%M %d, %Y') AS order_date
			FROM orders
			WHERE customer_id={$_SESSION['customer_id']}
			ORDER BY order_date DESC;";	
						
	$r = @mysqli_query ($dbc, $q); // Run the query.

	// Count the number of returned rows:
	$num = mysqli_num_rows($r);

	if ($num > 0) { // If it ran OK, display the records.
		putH('Οι παραγγελίες μου');
		echo "<div class='list_of_orders'>";
		
					echo "	<div>
					<span><span>Νο παραγγελίας</span></span>
					<span><span>Ημερομηνία υποβολής</span></span>
					<span><span>Συνολικό ποσό</span></span>
					<span><span>Κατάσταση</span></span>
					<span><span>Παραλαβή</span></span>
					<span><span>Πληρωμή</span></span>
					</div>";
					lineBreak();
		
		// Fetch and print all the records:
		while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
			echo "	<div>
					<span><a href='orders_page.php?oid={$row['oid']}'>{$row['oid']}</a></span>
					<span><span>At: {$row['order_date']}</span></span>
					<span><span> {$row['total']} €</span></span>
					<span><span> {$row['status']}</span></span>
					<span><span> {$row['shipping_method']}</span></span>
					<span><span> {$row['billing_method']}</span></span>
					</div>";
			//lineBreak();
		}
		echo "</div>";
		mysqli_free_result ($r); // Free up the resources.	
	}
	else //no orders 
	{
		p('Δεν έχεις ακόμη παραγγείλει τίποτα! Γρήγορα για ψώνια!');
		a('view_products.php','Πάτα εδώ τώρα!');
	}
	lineBreak();
	lineBreak();
}
else
{
	p('Συνδέσου πρώτα για να δεις τις παραγγελίες που έχεις κάνει.');
}

mysqli_close($dbc);
	
?>

		</main>
		<?php 
			require_once "../html/footer.html";
		?>
	</body>
</html>
