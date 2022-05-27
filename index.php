<!DOCTYPE html>
<html lang="el">
<?php // index.php
	$page_title = 'TechPoli';
	require_once "site/html/headForMainPage.html"; 
	require_once "site/libraries/php/createElements.php"; 
?>	
	<body>
		<header class="header bgimg-1">
			<?php require_once "site/html/navigationForMainPage.html"; ?>
			<h1><a id="letsgo" href="#main">Ας ξεκινήσουμε</a></h1>
		</header>
		<aside id="main" class="aside1">
			<div>
			<h2>Οι Αξίες μας, μας ενώνουν!</h2>
			<p id="typewriter"></p>
			<a href="#new">Δείτε τα νέα προϊόντα μας</a>
			<br><br>
			</div>
			<div class="bgimg-2 different"></div>
		</aside>
<script>
	var i = 0;
	var txt = 'Με οδηγό το όραμά μας, δημιουργούμε μια σύγχρονη, δυναμική, πελατοκεντρική εταιρεία, υψηλών επιδόσεων με ηγετική θέση στην αγορά δραστηριοποίησής μας. Κινητήριος δύναμή μας, είναι οι αξίες μας, όπως τις έχουν ορίσει οι άνθρωποί μας.'; /* The text */
	var speed = 50; /* The speed/duration of the effect in milliseconds */

	document.getElementById('letsgo').addEventListener("click",typeWriter);
	function typeWriter() 
	{
		if (i < txt.length) 
		{
			document.getElementById("typewriter").innerHTML += txt.charAt(i);
			i++;
			setTimeout(typeWriter, speed);
		}
	}
</script>
		<main class="main">

<?php

	require_once ('mysqli_connect.php'); // Connect to the db.
		
	// Make the query:
	$q = "	
		SELECT product_id AS pid, name, price, path_the_img_file AS img, entry_date 
		FROM products 
		ORDER BY entry_date DESC
		LIMIT 5;";	
							
	$r = @mysqli_query ($dbc, $q); // Run the query.

	// Count the number of returned rows:
	$num = mysqli_num_rows($r);

	if ($num > 0) { // If it ran OK, display the records.
		
		$id = 'new';
		$title = 'Τα νέα προϊόντα μας';
					
		openChapterWithFlip($title, $id);
		
		// Fetch and print all the records:
		while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
			createFlipBox($row['pid'], $row['price'], $row['name'], $row['img']);
		}

		closeChapterWithFlip();
		
		mysqli_free_result ($r); // Free up the resources.	
					
	}
	lineBreak();	

?>
			
			<a href="#best_sellers">Δείτε τα best sellers!</a>
			<br><br>
			<div class="bgimg-3"></div>
			
<?php

	// Make the query:
	$q = "	
		SELECT p.product_id AS pid, sold, name, price, path_the_img_file AS img, entry_date 
		FROM products, (
		SELECT product_id, SUM(quantity) AS sold
		FROM orders_contents
		GROUP BY product_id
		ORDER BY sold DESC
		LIMIT 5) AS p
		WHERE products.product_id=p.product_id
		ORDER BY sold DESC, entry_date ASC;
	";	
							
	$r = @mysqli_query ($dbc, $q); // Run the query.

	// Count the number of returned rows:
	$num = mysqli_num_rows($r);

	if ($num > 0) { // If it ran OK, display the records.
		
		$id = 'best_sellers';
		$title = 'Τα κορυφαία σε πωλήσεις';
			
		openChapterWithZoom($title, $id);

		// Fetch and print all the records:
		while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
			createOverlayBox($row['pid'], $row['price'], $row['name'], $row['img']);
		}

		closeChapterWithZoom();
		
		mysqli_free_result ($r); // Free up the resources.	
	}

	mysqli_close($dbc);

?>

		</main>
		<footer id="about" class="footer">
			<?php 
			require_once "site/html/map.html"; 
			require_once "site/html/footerForMainPage.html"; 
			?>
		</footer> 
	</body>
</html>