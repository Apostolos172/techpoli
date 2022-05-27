
	<?php // basket.php
	
	// Προβολή του καλαθιού
		
		$page_title = "Το καλάθι μου";
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
// Check if the form has been submitted (to update the cart):
if (isset($_POST['submitted'])) {

//qty έρχεται σαν πίνακας από τη φόρμα με δείκτες τους κωδικούς των προϊόντων
	// Change any quantities:
	foreach ($_POST['qty'] as $k => $v) {

		// Must be integers!
		$pid = (int) $k;
		$qty = (int) $v;
		
		if ( $qty == 0 ) { // Delete.
			unset ($_SESSION['total']);
			unset ($_SESSION['cart'][$pid]);
		} elseif ( $qty > 0 ) { // Change quantity.
			$_SESSION['cart'][$pid]['quantity'] = $qty;
		}
		
	} // End of FOREACH.
} // End of SUBMITTED IF.

// Display the cart if it's not empty...
if (!empty($_SESSION['cart'])) {

	// Retrieve all of the information for the products in the cart:
	require_once ('../../mysqli_connect.php');
	$q = "	SELECT product_id, name, path_the_img_file AS img
			FROM products
			WHERE product_id IN (";
	foreach ($_SESSION['cart'] as $pid => $value) {
		$q .= $pid . ',';
	}
	$q = substr($q, 0, -1) . ') ORDER BY name ASC';
	$r = mysqli_query ($dbc, $q);
	
	// Create a form and a table:
	echo '	<form action="basket.php" method="post">
			<table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
			<tr>
				<td align="left" width="10%"><b>Product</b></td>
				<td align="left" width="50%"><b>Όνομα προϊόντος</b></td>
				<td align="center" width="10%"><b>Τιμή</b></td>
				<td align="center" width="10%"><b>Ποσότητα</b></td>
				<td align="right" width="10%"><b>Σύνολο</b></td>
				<td align="right" width="10%"><b>Αφαίρεση</b></td>
			</tr>
		';

	// Print each item...
	$total = 0; // Total cost of the order.
	while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {
		
		// Calculate the total and sub-totals.
		$subtotal = $_SESSION['cart'][$row['product_id']]['quantity'] * $_SESSION['cart'][$row['product_id']]['price'];
		$total += $subtotal;
		
		// Print the row.
		echo "\t<tr>
					<td align=\"left\"><img src={$row['img']}></td>
					<td align=\"left\">{$row['name']}</td>
					<td align=\"center\">€{$_SESSION['cart'][$row['product_id']]['price']}</td>
					<td align=\"center\"><input class='quantity' type=\"text\" size=\"3\" name=\"qty[{$row['product_id']}]\" value=\"{$_SESSION['cart'][$row['product_id']]['quantity']}\" /></td>
					<td align=\"right\">‎€" . number_format ($subtotal, 2) . "</td>
					<td align=\"right\"><a class='delete' ><img src='../images/delete.png'></a></td>
			</tr>\n";
			
	} // End of the WHILE loop.
	?>

	<?php
	
	mysqli_close($dbc); // Close the database connection.

	// Print the footer, close the table, and the form.
	echo '<tr>
			<td colspan="4" align="right"><b>Total:</b></td>
			<td align="right">€' . number_format ($total, 2) . '</td>
		</tr>
	</table>
	<div align="center"><input type="submit" name="submit" value="Update My Cart" /></div>
	<input type="hidden" name="submitted" value="TRUE" />
	</form>';
	p('Μπορείς να αφαιρέσεις ένα προϊόν από το καλάθι είτε πατώντας το πλήκτρο 
	στα δεξιά, είτε μηδενίζοντας την ποσότητα του προϊόντος και ανανεώνοντας το καλάθι.');
	$_SESSION['total'] = $total;
	a("checkout.php",'Checkout');
	lineBreak();
	a("view_products.php",'Συνέχεια των αγορών μου');
	lineBreak();
	lineBreak();

} else {
	p('Το καλάθι σου είναι ακόμη άδειο.');
	img('../images/sad.png',10);
	p('Συνέχισε τις αγορές σου');
	a('view_products.php','εδώ');
	lineBreak();
	a('checkout.php','checkout');
	lineBreak();
	lineBreak();
}
?>
		</main>
		<?php 
			require_once "../html/footer.html";
		?>
		
	<script>
		var bins = window.document.getElementsByClassName('delete');
		var quantities = window.document.getElementsByClassName('quantity');
		for(var bin=0; bin<bins.length; bin++)
		{
			var t = ''+bin;
			//console.log(t);
			bins[bin].id=t;
			//console.log(t,quantities.length,bin,quantities[bin].value);
			var temp = bins[bin];
			temp.addEventListener("click",function(){zeroToField(this.id);});
		}
		function zeroToField(binNo)
		{
			var t2 = parseInt(binNo);
			//console.log(t2,binNo,(quantities.length),quantities[t2].value);
			var temp2 = quantities[t2];
			temp2.value=0;
			//console.log(t2,binNo,(quantities.length),quantities[t2].value);
			var submit = window.document.querySelector('input[type="submit"]');
			submit.click();
		}
	</script>
		
	</body>
</html>
