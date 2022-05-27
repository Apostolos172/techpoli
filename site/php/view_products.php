
	<?php // view_products.php
	
	// Σελίδα εμφάνισης των προϊόντων, εξετάζοντας κάθε φορά μήπως ο χρήστης θέλησε να δει 
	// 	συγκεκριμένα προϊόντα επιλέγοντας κάποια κατηγορία ή κάποιο φίλτρο κλπ 
	
		$page_title = "Τα προϊόντα μας";
		require_once "../html/head.html";
		require_once "../libraries/php/createElements.php"; 
	?>
	<body>
		<header class="header">
		<?php
			include "../html/navigation.html";
		?>
		</header>	

<?php

// Main header:
echo '<h1>Τα προϊόντα μας</h1>';

require_once ('../../mysqli_connect.php'); // Connect to the db.
		
// Make the query:
//Γενικό query για την προβολή των προϊόντων ομαδοποιημένα κατά κατηγορία και έπειτα από το πιο πρόσφατο 
	//στο παλιότερο
$q = "	SELECT product_id AS pid, name, OEM, price, path_the_img_file AS img, description, category, entry_date 
		FROM products 
		ORDER BY category, entry_date DESC;";	
		
//overwrite if a category link pressed from the navigation
if((isset($_GET['category']))&& (is_string($_GET['category']))) {
	$category = (string) $_GET['category'];
		$q = "	SELECT product_id AS pid, name, OEM, price, path_the_img_file AS img, description, category, entry_date 
				FROM products
				WHERE category = $category
				ORDER BY category, OEM, entry_date DESC;";
}

//query για την συλλογή των κατηγοριών ώστε να ελεγχθεί αν ανήκει το αλφαριθμητικό της αναζήτησης εδώ
$query_for_getting_categories = 
	"	SELECT category
		FROM products
		GROUP BY category;";
$categories=array();
$r_categories = @mysqli_query ($dbc, $query_for_getting_categories); // Run the query.
while($category_row = mysqli_fetch_array($r_categories, MYSQLI_ASSOC)){
	array_push($categories,$category_row['category']);
}

//query για την συλλογή των κατασκευαστών ώστε να ελεγχθεί αν ανήκει το αλφαριθμητικό της αναζήτησης εδώ
$query_for_getting_OEMs = 
	"	SELECT OEM
		FROM products
		GROUP BY OEM;";
$OEMs=array();
$r_OEMs= @mysqli_query ($dbc, $query_for_getting_OEMs); // Run the query.
while($OEM_row = mysqli_fetch_array($r_OEMs, MYSQLI_ASSOC)){
	array_push($OEMs,$OEM_row['OEM']);
}

//Αν ανήκει το αλφαριθμητικό σε ένα από τα 2 παραπάνω σύνολα τότε εμφάνισε τα σχετικά επαναδιατυπώνοντας
	//το ίδιο q query
if (((isset($_GET['search'])) && (in_array($_GET['search'],$categories)) && is_string($_GET['search']))||
	((isset($_GET['search'])) && (in_array($_GET['search'],$OEMs)) && is_string($_GET['search']) )) {
	$search = (string) $_GET['search'];
		$q = "	SELECT product_id AS pid, name, OEM, price, path_the_img_file AS img, description, category, DATE_FORMAT(entry_date, '%M %d, %Y') AS entry_date 
				FROM products
				WHERE category = '$search' || OEM = '$search'
				ORDER BY category, OEM, entry_date DESC;";
}

//Εκτέλεσε query (ένα από τα 3 παραπάνω, το q)
$r = @mysqli_query ($dbc, $q); // Run the query.
$rows = @mysqli_query ($dbc, $q); // Run the query.

$page=array();
while($rtemp = mysqli_fetch_array($rows, MYSQLI_ASSOC)){
	array_push($page,(int)$rtemp['pid']);
}

if(isset($_GET['filterOEM']))
{
	$filterOEM = $_GET['filterOEM'];
	$t = $_GET['filterOEM'];
	$q = "
	SELECT product_id AS pid, name, OEM, price, path_the_img_file AS img, description, category, DATE_FORMAT(entry_date, '%M %d, %Y') AS entry_date 
	FROM products
	WHERE OEM = '$t' AND product_id IN (".implode(',',$page).")
	ORDER BY category, OEM, entry_date DESC;";
	$r = @mysqli_query ($dbc, $q); // Run the query.
}

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many products there are:
	putH("Συνολικά $num προϊόντα.");
	
		opendiv("products_container");
			opendiv("aside");
				putH('Διάλεξε φίλτρα');
				lineBreak();
				echo "<ul class='sticky' style='list-style:none;'>";
					$q2 = "	SELECT OEM
							FROM products
							GROUP BY OEM;";
					if (((isset($_GET['search'])) && (in_array($_GET['search'],$categories)) && is_string($_GET['search']))||
						((isset($_GET['search'])) && (in_array($_GET['search'],$OEMs)) && is_string($_GET['search']) )||
						((isset($_GET['category']))&& (is_string($_GET['category']))))
					{
						if(isset($_GET['search']))
						{
							$search = (string) $_GET['search'];
						$q2 = "	
						SELECT OEM
						FROM products
						WHERE OEM='$search' || category='$search' 
						GROUP BY OEM;";
						}
						elseif(isset($_GET['category']))
						{
							$search = (string) $_GET['category'];
						$q2 = "	
						SELECT OEM
						FROM products
						WHERE category=$search 
						GROUP BY OEM;";
						}
					}
					$r2 = @mysqli_query ($dbc, $q2); // Run the query.
					while($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC)){
						$temp = $row2['OEM'];
 						echo "<li><label><input name='$temp' type='checkbox' size='10'>$temp</label></li>\n";
					}
				echo "</ul>";
			closediv();
			opendiv("main");	

				// Fetch and print all the records:
				while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
					createAProductCard($row['pid'], $row['img'], $row['name'], $row['OEM'], ''.$row['price']);
				}

			closediv();
		closediv();
	
	mysqli_free_result ($r); // Free up the resources.
?>
	<script>
	var checkboxes = window.document.querySelectorAll('input[type=\"checkbox\"]');
	var currentOEM = 
	<?php 
		if(isset($filterOEM)) {echo json_encode($filterOEM, JSON_HEX_TAG);}
		else{echo "null";}
	?>;
	for(var checkbox of checkboxes)
	{
		if(currentOEM!=null)
		{
			if(((checkbox.name).localeCompare(currentOEM))==0)
				checkbox.checked=true;
		}
	}
	</script>
<?php
	js("
		var checkboxes = window.document.querySelectorAll('input[type=\"checkbox\"]');
		for(var checkbox of checkboxes)
		{
			checkbox.addEventListener('click',function(){dofilter(this);});
		}
		function dofilter(checkbox)
		{
			if(checkbox.checked)
			{
				var filter = checkbox.name;
				var temp= window.location.href;
				if(temp.includes('?'))
					temp= temp+'&filterOEM=';
				else
					temp= temp+'?filterOEM=';					
				temp= temp+filter;
				window.location.href=temp;
			}
			else
			{
				var temp= window.location.href;
				window.location.href=temp;
			}
		}
	");

} else { // If no records were returned.

	echo '<p class="error">There are currently no products.</p>';
	echo '</main>';

}

mysqli_close($dbc); // Close the database connection.

?>
		<?php 
			require_once "../html/footer.html";
			endPage();
		?>
