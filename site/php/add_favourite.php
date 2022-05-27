
	<?php // add_favourite.php
	
	// Σελίδα προσθήκης προϊόντος στα αγαπημένα του πελάτη
	// Δεν υπάρχει ακόμη υλοποίηση ουσιαστικά προσθήκης
	
		$page_title = "Προσθήκη στα αγαπημένα μου";
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
		if ( !(isset($_SESSION['customer_id']) ) )
		{
			openModal('Πρέπει πρώτα να συνδεθείς για να κάνεις προσθήκη του προϊόντος στα αγαπημένα σου.');
			echo "<script>redirectionTo_In('login_page.php',4000);</script>";
		}
		else
		{
			p('Δεν είναι ακόμη διαθέσιμη αυτή η λειτουργία.');
		}
		?>

		</main>
		<?php 
			require_once "../html/footer.html";
			endPage();
		?>
