
<?php // products.php

// Εδώ φαίνονται όλα τα προϊόντα του ηλεκτρονικού καταστήματος
// Φτάνεις εδώ από το μενού του περιβάλλοντος με την επιλογή Products

	$page_title = 'Products';
	require_once "../html/header.html";
	require_once ('../libraries/php/createElements.php'); // library
?>
<main class="main">

	<h1 style="color:yellow;">Products</h1>

<?php

require_once ('../../mysqli_connect.php'); // Connect to the db.

// Make the query:
$q = "
SELECT products.category, SUM(orders_contents.quantity) AS piecesSoldFromTheCategory
FROM products JOIN orders_contents ON products.product_id=orders_contents.product_id
GROUP BY products.category;
";
						
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.
	
	putH('Πωλήσεις ανά κατηγορία');
	p('Όσες κατηγορίες δεν έχουν πουλήσει ούτε ένα τεμάχιο δεν φαίνονται εδώ');
	p('Σύνολο '.$num.' κατηγορίες');
	echo "<div id='piechart' style='width:100%; height:500px;'></div>";

	$table = array();
	array_push($table,['Κατηγορία', 'Συνολικές πωλήσεις τεμαχίων']);
	// Fetch and keep all the records in a table:
	while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		//p("{$row['category']}"." {$row['piecesSoldFromTheCategory']}");
		$temp = [$row['category'],(int)$row['piecesSoldFromTheCategory']];
		array_push($table,$temp);
	}
	?>
	
	<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
    <script type='text/javascript'>
		// επικοινωνία php με js
		var length = <?php echo json_encode($num, JSON_HEX_TAG); ?>; // Don't forget the extra semicolon!
		var dataTable = <?php echo json_encode($table, JSON_HEX_TAG); ?>; // Don't forget the extra semicolon!

		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);
		
		//console.log(length);
		//console.log(dataTable);

		function drawChart() {

        var data = google.visualization.arrayToDataTable(dataTable);

        var options = {
          title: 'Οι πωλήσεις ανά κατηγορία',
		  is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
<?php
	mysqli_free_result ($r); // Free up the resources.	
}
else {
	p('There was a problem');
}

// Make the query:
$q = "	
SELECT products.product_id AS pid, products.name, products.OEM, products.price, products.category, 
	products.entry_date,  SUM(orders_contents.quantity) AS piecesSold
FROM products JOIN orders_contents ON products.product_id= orders_contents.product_id
GROUP BY orders_contents.product_id
ORDER BY products.category, products.entry_date DESC, piecesSold DESC;
";	
						
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.
	
	putH('Πρώτα το πιο καινούριο, οργανωμένα ανά κατηγορίες');
	p('Όσα προϊόντα δεν έχουν πουλήσει ούτε ένα τεμάχιο δεν φαίνονται εδώ');
	p('Σύνολο '.$num.' προϊόντα');
	openTable();
		openRow();
			th('Id προϊόντος','10%');
			th('Όνομα','30%');
			th('Κατασκευαστής','10%');
			th('Τιμή','10%');
			th('Κατηγορία','10%');
			th('Ημερομηνία εισαγωγής','20%');
			th('Τεμάχια που έχουν πωληθεί','10%');
		closeRow();	
	// Fetch and print all the records:
	while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		openRow();
			td("{$row['pid']}");
			td("{$row['name']}");
			td("{$row['OEM']}");
			td("{$row['price']}".' €');
			td("{$row['category']}");
			td("{$row['entry_date']}");
			td("{$row['piecesSold']}");
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
SELECT products.product_id AS pid, products.name, products.OEM, products.price, products.category, 
	products.entry_date,  0 AS piecesSold
FROM products 
WHERE products.product_id NOT IN (
SELECT products.product_id 
FROM products JOIN orders_contents ON products.product_id= orders_contents.product_id
GROUP BY orders_contents.product_id
)
ORDER BY products.category, products.entry_date;
";	
						
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.
	
	putH('Πρώτα το πιο παλιό, οργανωμένα ανά κατηγορίες');
	p('Τα προϊόντα που δεν έχουν πουλήσει ούτε ένα τεμάχιο');
	p('Σύνολο '.$num.' προϊόντα');
	openTable();
		openRow();
			th('Id προϊόντος','10%');
			th('Όνομα','30%');
			th('Κατασκευαστής','10%');
			th('Τιμή','10%');
			th('Κατηγορία','10%');
			th('Ημερομηνία εισαγωγής','20%');
			th('Τεμάχια που έχουν πωληθεί','10%');
		closeRow();	
	// Fetch and print all the records:
	while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		openRow();
			td("{$row['pid']}");
			td("{$row['name']}");
			td("{$row['OEM']}");
			td("{$row['price']}".' €');
			td("{$row['category']}");
			td("{$row['entry_date']}");
			td("{$row['piecesSold']}");
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
SELECT products.product_id AS pid, products.name, products.OEM, products.price, products.category, 
	products.entry_date, path_the_img_file AS img
FROM products
ORDER BY products.category, products.entry_date DESC;
";	
						
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.
	
	putH('Πρώτα το πιο καινούριο, οργανωμένα ανά κατηγορίες');
	p('Φαίνονται όλα τα προϊόντα');
	p('Σύνολο '.$num.' προϊόντα');
	openTable();
		openRow();
			th('Id προϊόντος','10%');
			th('Όνομα','30%');
			th('Προϊόν','10%');
			th('Κατασκευαστής','10%');
			th('Τιμή','10%');
			th('Κατηγορία','10%');
			th('Ημερομηνία εισαγωγής','20%');
		closeRow();	
	// Fetch and print all the records:
	while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		openRow();
			td("{$row['pid']}");
			td("{$row['name']}");
			echo "<td style='background-color:white;'><img style='width:100px;' src={$row['img']}></td>";
			td("{$row['OEM']}");
			td("{$row['price']}".' €');
			td("{$row['category']}");
			td("{$row['entry_date']}");
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