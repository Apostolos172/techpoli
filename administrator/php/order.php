
	<?php // order.php
	
	// Προβολή περιεχομένων μιας συγκεκριμένης παραγγελίας
	// Ο διαχειριστής φτάνει εδώ επιλέγοντας μια παραγγελία από τη σελίδα orders.php
	
		if(isset($_GET['oid']))
			$page_title = "Παραγγελία Νο:". $_GET['oid'];
		else
			$page_title = "Παραγγελία";
		require_once "../html/header.html";
	?>
		<main class="main">
		
<?php

require_once ('../libraries/php/createElements.php'); // library
require_once ('../../mysqli_connect.php'); // Connect to the db.

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
			openTable();
				openRow();
					th('Κωδικός προϊόντος','10%');
					th('Προϊόν','20%');
					th('Όνομα προϊόντος','30%');
					th('Τιμή τεμαχίου','15%');
					th('Ποσότητα','10%');
					th('Συνολικό ποσό','15%');
				closeRow();		
			
			// Fetch and print all the records:
			while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
				openRow();
					td("{$row['pid']}");
					td("<img src={$row['img']} width=100%>");
					td("{$row['name']}");
					td("{$row['pricePerPiece']} €");
					td("{$row['q']}");
					$temp = $row['price']*$row['q'];
					td("$temp €");
				closeRow();
			}
			closeTable();
			mysqli_free_result ($r); // Free up the resources.	
		}
		lineBreak();
	
	}
	else
	{
		p('Τι θες να δεις, πες μου, και ήρθες εδώ.');
		p('Επέλεξε μια παραγγελία.');
		a('orders.php','εδώ');
	}

mysqli_close($dbc);
	
?>

		</main>
		<?php 
			require_once "../html/footer.html";
		?>
		