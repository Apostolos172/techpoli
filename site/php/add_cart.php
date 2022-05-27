
	<?php // add_chart.php
		
	// This page adds products to the shopping cart.
		
		$page_title = "Προσθήκη στο καλάθι μου";
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
if (isset ($_GET['pid']) && is_numeric($_GET['pid']) ) { // Check for a product ID.

	$pid = (int) $_GET['pid'];

	// Check if the cart already contains one of these products;
	// If so, increment the quantity:
	if (isset($_SESSION['cart'][$pid])) {
	
		$_SESSION['cart'][$pid]['quantity']++; // Add another.

		// Display a message.
		p('Ακόμη ένα τεμάχιο από το συγκεκριμένο προϊόν προστέθηκε στο καλάθι σου.');
		a('view_products.php','Συνέχεια των αγορών μου');
		lineBreak();
		a('basket.php','Προεπισκόπηση του καλαθιού μου');
		lineBreak();
		lineBreak();
		
	} else { // New product to the cart.

		// Get the product's price from the database:
		require_once ('../../mysqli_connect.php');
		$q = "	SELECT price 
				FROM products 
				WHERE product_id = $pid";
		$r = mysqli_query ($dbc, $q);		
		if (mysqli_num_rows($r) == 1) { // Valid product ID.
		
			// Fetch the information.
			list($price) = mysqli_fetch_array ($r, MYSQLI_NUM);
			
			// Add to the cart:
			$_SESSION['cart'][$pid] = array ('quantity' => 1, 'price' => $price);

			// Display a message:
			p('Το προϊόν προστέθηκε στο καλάθι αγορών σου.');
			a('view_products.php','Συνέχεια των αγορών μου');
			lineBreak();
			a('basket.php','Προεπισκόπηση του καλαθιού μου');
			lineBreak();
			lineBreak();

		} else { // Not a valid product ID.
			p('Αυτή η σελίδα προσπελάστηκε κατά λάθος!');
		}
		
		mysqli_close($dbc);

	} // End of isset($_SESSION['cart'][$pid] conditional.

} 
else 
{ // No product ID.
	p('Αυτή η σελίδα προσπελάστηκε κατά λάθος!');
}

?>
		</main>
		<?php 
			require_once "../html/footer.html";
			endPage();
		?>
