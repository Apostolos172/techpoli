
<?php // product.php
	
// Σελίδα εμφάνισης συγκεκριμένου προϊόντος
	
require_once "../libraries/php/createElements.php"; 

$row = FALSE; // Assume nothing!

if (isset($_GET['pid']) && is_numeric($_GET['pid']) ) { // Make sure there's a product ID!

	$pid = (int) $_GET['pid'];
	
	// Get the print info:
	require_once ('../../mysqli_connect.php'); 
	$q = "	SELECT product_id AS pid, name, OEM, price, path_the_img_file AS img, description, category, DATE_FORMAT(entry_date, '%M %d, %Y') AS entry_date 
			FROM products
			WHERE product_id=$pid;";
	$r = mysqli_query ($dbc, $q);
	if (mysqli_num_rows($r) == 1) { // Good to go!
	
		// Fetch the information:
		$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
		
		// Start the HTML page:
		$page_title = $row['name'];
		require_once "../html/head.html";
		
		echo "<body>";
		echo "<header class='header'>";
			include "../html/navigation.html";
		echo "</header>";
	
		// Display the information
		opendiv("product_container");
			opendiv("main");
				opendiv();
					putH($row['name'],'product_name','','h1');
					img($row['img']);
					putH('Κατασκευαστής: '.$row['OEM']);
					p($row['description']);
				closediv();
			closediv();
			opendiv("aside");
				opendiv("sticky");
				lineBreak();
				//price
				putH($row['price'],'product_price','purple','h1');
				//add to cart
				echo "<a href='add_cart.php?pid=$pid'><img title='Προσθήκη στο καλάθι' src='../images/add.png'></a>";
				lineBreak();
				lineBreak();
				//add to favourite
				echo "<a href='add_favourite.php?pid=$pid'><img title='Προσθήκη στα αγαπημένα' src='../images/add_favourite.png'></a>";
				lineBreak();
				lineBreak();
				closediv();
			closediv();
		closediv();
	
	} // End of the mysqli_num_rows() IF.
	
	mysqli_close($dbc);

}

if (!$row) { // Show an error message.
	$page_title = 'Error';
	include ('../html/head.html');
			echo "<body>";
		echo "<header class='header'>";
			include "../html/navigation.html";
		echo "</header>";
	opendiv('main');
	lineBreak();
	echo '<div align="center">Αυτή η σελίδα προσπέλαστηκε κατά λάθος!</div>';
	lineBreak();
	hr();
	closediv();
}

// Complete the page:
require_once "../html/footer.html";
endPage();

?>
