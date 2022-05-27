
	<?php // shipping.php
	
	// Σελίδα ενημερωτική για τρόπους μεταφοράς
	
		$page_title = "Τρόποι παραλαβής";
		require_once "../html/head.html";
	?>
	<body>
		<header class="header bgimg-1">
		<?php
			include "../html/navigation.html";
		?>
		<h1>Terms and Conditions</h1>
		</header>
		<article class="main">
			
			<h2>Παραλαβή Παραγγελιών</h2>
			<p>
				Ο τρόπος παραλαβής μιας παραγγελίας επιλέγεται από τον πελάτη κατα την διάρκεια της ολοκλήρωσης της παραγγελίας.
			</p>
			<button class="accordion"><h3>1. Παραλαβή από το κατάστημα</h3></button>
			<div class="panel">
				<p>
					Υπάρχει η δυνατότητα παραλαβής της παραγγελίας σας από το κατάστημά μας.
				</p>
			</div>

			<button class="accordion"><h3>2. Αποστολή μέσω ταχυμεταφορικής</h3></button>
			<div class="panel">
				<p>
					Μπορείτε να επιλέξετε η παραγγελία σας να σταλεί σε εσάς μέσω ταχυμεταφορικής.
				</p>
			</div>
		
		</article>
		<?php 
			require_once "../html/footer.html";
		?>
		<script>
			accordion();
		</script>
	</body>
</html>
