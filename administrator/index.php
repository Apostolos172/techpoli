<!DOCTYPE html>
<html lang="el">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>TechPoli-Administrator</title>
		<link rel="stylesheet" type="text/css" href="css/template.css" >
		<link rel="stylesheet" type="text/css" href="css/general.css" >
		<link rel="stylesheet" type="text/css" href="css/header.css" >
		<link rel="stylesheet" type="text/css" href="css/navigation.css" >
		
		<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet"> 
		<link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet"> 
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	<body class="grid-container">
		<header class="header">
			<div>
				<h1>TechPoli-Administrator</h1>
				<h2>Control Panel</h2>
			</div>
			<div>
				<img src="images/1.jpg" alt="Me" class="avatar">
			</div>
		</header>
		<nav class="navigation">
			<div class="sidebar sticky">
				<a href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
				<a href="php/customers.php"><i class="fa fa-fw fa-user"></i> Customers</a>
				<a href="php/products.php"><i class="material-icons">storefront</i> Products</a>
				<a href="php/add_product.php"><i class="material-icons">add_business</i> Add product</a>
				<a href="php/orders.php"><i class="fa fa-fw fa-wrench"></i> Orders</a>
				<a href="#contact"><i class="fa fa-fw fa-envelope"></i> Contact</a>
				<a href="../" rel="noreferrer noopener" target="_blank"><i class="material-icons">language</i> TechPoli</a>
			</div>
		</nav>
		<main class="main central">

<?php

require_once ('libraries/php/createElements.php'); // library
require_once ('../mysqli_connect.php'); // Connect to the db.

// Make the query:
$q = "
SELECT *
FROM(
SELECT DATE_FORMAT(order_date, '%M %d, %Y') AS odate, SUM(total) AS incomeFromThisDay
FROM orders 
GROUP BY odate
ORDER BY odate DESC
LIMIT 5) temp
ORDER BY temp.odate ASC;
";
						
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.
	
	putH('Τα έσοδα ανά ημέρα των τελευταίων 5 κερδοφόρων ημερών');
	echo "<div id='chart_div' style='width:100%; height:500px;'></div>";

	$table = array();
	array_push($table,['Ημέρα', 'Τζίρος ημέρας']);
	// Fetch and keep all the records in a table:
	while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		$temp = [$row['odate'],(int)$row['incomeFromThisDay']];
		array_push($table,$temp);
	}
	?>

	<div id='png' class="png"></div>
	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
		// επικοινωνία php με js
		var dataTable = <?php echo json_encode($table, JSON_HEX_TAG); ?>; // Don't forget the extra semicolon!
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);
	  
		//console.log(dataTable);

		function drawChart() {
			var data = google.visualization.arrayToDataTable(dataTable);
			var options = {
				title: 'Company Performance',
				hAxis: {title: 'Ημέρα',  titleTextStyle: {color: '#333'}},
				vAxis: {minValue: 0}
			};

			var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
		
			// Wait for the chart to finish drawing before calling the getImageURI() method.
			google.visualization.events.addListener(chart, 'ready', function () {
			/*
			//Αν θέλω στη θέση του διαδραστικού γραφήματος να εμφανιστεί μια εικόνα png
			(document.getElementById('chart_div')).innerHTML = '<img src="' + chart.getImageURI() + '">';
			console.log((document.getElementById('chart_div')).innerHTML);
			*/
			document.getElementById('png').innerHTML = '<a  rel="noreferrer noopener" target="_blank" href="' + chart.getImageURI() + '">Πάρε ένα αντίγραφο εικόνας του γραφήματος</a>';
			});

			chart.draw(data, options);		
		}
    </script>
		
<?php
	mysqli_free_result ($r); // Free up the resources.	
}
else {
	p('There was a problem');
}

mysqli_close($dbc);

?>
		
			<h2>Υπηρεσίες του πίνακα ελέγχου</h2>
			<br>
			<p>
			Από την επιλογή Customers οδηγείσαι σε μια λίστα με τα στοιχεία των εγγεγραμμένων πελατών 
			του καταστήματος. Βέβαια οι κωδικοί των χρηστών δεν είναι ορατοί αφού κατά την εγγραφή των πελατών, 
			αλλά και κατά την σύνδεσή τους, γίνεται άμεσα κρυπτογράφηση χωρίς να φτάνει στην βάση δεδομένων της 
			επιχείρησης ο αρχικός κωδικός.
			</p>
			<p>
			Από την επιλογή Products οδηγείσαι σε μια λίστα με τα προϊόντα του καταστήματος. Ακόμη, μπορείς 
			να δεις την πορεία πωλήσεων των προϊόντων μέσα από διάφορους πίνακες.
			</p>
			<p>
			Από την επιλογή Add product οδηγείσαι σε μια φόρμα όπου υπάρχει η δυνατότητα προσθήκης νέων 
			προϊόντων.
			</p>
			<p>
			Τέλος από την επιλογή Orders οδηγείσαι σε μια λίστα με όλες τις παραγγελίες που έχουν πραγματοποιηθεί 
			από τους διάφορους πελάτες.
			</p>
		</main>
		<aside class="aside bgimg">
		</aside>
		<footer id="contact" class="footer">
			<div class="copy_design">
				&copy; Copyright 2020 TechPoli
				<span> 
					Created by tolis' s team
				</span>
				<a href="php/contact.php">Διαχειριστής</a>
			</div>
		</footer>
	</body>
</html>