
	<?php // checkout.php

	// This page inserts the order information into the table.
		
		$page_title = "Checkout";
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

if(isset($_SESSION['total']))
{
	if(isset($_SESSION['customer_id'])) //Αν ο χρήστης είναι συνδεδεμένος, go
	{
		# Script 17.10 - checkout.php
		// This page inserts the order information into the table.
		// This page would come after the billing process.
		// This page assumes that the billing process worked (the money has been taken).

		// Set the page title and include the HTML header.

		// Assume that the customer is logged in and that this page has access to the customer's ID:
		$customer = 1; // Temporary.
		$customer = $_SESSION['customer_id'];

		// Assume that this page receives the order total.
		$total = 178.93; // Temporary.
		if(isset($_SESSION['total']))
			$total = $_SESSION['total'];
		else //Αν ο χρήστης προσπέλασε τη δεδομένη σελίδα χωρίς να έχει επιλέξει κάποιο προϊόν για αγορά
		{
					p('Πάρε κάτι!');
					a('view_products.php','Από εδώ...');
					lineBreak();
					lineBreak();
				echo "</main> ";
				require_once "../html/footer.html";
			echo "</body";
		echo "</html>";
		exit();
		}

		require_once ('../../mysqli_connect.php'); // Connect to the database.

		// Turn autocommit off.
		mysqli_autocommit($dbc, FALSE);

		// Add the order to the orders table...
		$q = "	INSERT INTO orders (customer_id, total, order_date, status, shipping_method, billing_method) VALUES 
				($customer, $total, NOW(), 'Καταχωρημένη', 'Από το κατάστημα', 'Στο κατάστημα')";
		$r = mysqli_query($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) {

			// Need the order ID:
			$oid = mysqli_insert_id($dbc);
			$_SESSION['oid'] = $oid;
			
			// Insert the specific order contents into the database...
			
			// Prepare the query:
			$q = "INSERT INTO orders_contents (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
			$stmt = mysqli_prepare($dbc, $q);
			mysqli_stmt_bind_param($stmt, 'iiid', $oid, $pid, $qty, $price);
			
			// Execute each query, count the total affected:
			$affected = 0;
			foreach ($_SESSION['cart'] as $pid => $item) {
				$qty = $item['quantity'];
				$price = $item['price'];
				mysqli_stmt_execute($stmt);
				$affected += mysqli_stmt_affected_rows($stmt);
			}

			// Close this prepared statement:
			mysqli_stmt_close($stmt);

			// Report on the success....
			if ($affected == count($_SESSION['cart'])) { // Whohoo!
			
				// Commit the transaction:
				mysqli_commit($dbc);
				
				// Clear the cart.
				unset($_SESSION['cart']);
				unset($_SESSION['total']);
				unset($_SESSION['oid']);
				
				// Message to the customer:
				p('Ευχαριστούμε για την παραγγελία. Θα ενημερωθείς με email μόλις η παραγγελία είναι έτοιμη προς 
				παραλαβή.');
				a('../../index.php','Επιστροφή στην αρχική σελίδα');
				lineBreak();
				lineBreak();
				
				// Send emails and do whatever else.
			
			} else { // Rollback and report the problem.
			
				mysqli_rollback($dbc);
				
				echo '<p>Your order could not be processed due to a system error. You will be contacted in order to have the problem fixed. We apologize for the inconvenience.</p>';
				// Send the order information to the administrator.
				
			}

		} else { // Rollback and report the problem.

			mysqli_rollback($dbc);

			echo '<p>Your order could not be processed due to a system error. You will be contacted in order to have the problem fixed. We apologize for the inconvenience.</p>';
			
			// Send the order information to the administrator.
			
		}

		mysqli_close($dbc);
	}
	else //Ο χρήστης δεν είναι συνδεδεμένος σε λογαριασμό.
	{
		p('Πρέπει να συνδεθείς για να ολοκληρώσεις την παραγγελία.');
		p('Σε 5 δευτερόλεπτα είσαι εκεί.');
		echo " <script>redirectionTo_In('login_page.php',5000);</script>";
	}
}
else //Αν ο χρήστης προσπέλασε τη δεδομένη σελίδα χωρίς να έχει επιλέξει κάποιο προϊόν για αγορά
{
			p('Πάρε κάτι πρώτα!');
			a('view_products.php','Από εδώ...');
			lineBreak();
			lineBreak();
		echo "</main> ";
		require_once "../html/footer.html";
	echo "</body>";
echo "</html>";
exit();
}
?>
		</main>
		<?php 
			require_once "../html/footer.html";
		?>
	</body>
</html>
