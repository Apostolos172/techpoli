
	<?php // faq.php
	
	// Σελίδα ενημερωτική για συχνές ερωτήσεις
	
		$page_title = "Συχνές ερωτήσεις";
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
			
			<h2>Συχνές ερωτήσεις</h2>
			
			<button class="accordion"><h3>1. Πληρωμή</h3></button>
			<div class="panel">
				<p>
					Ο τρόπος πληρωμής μιας παραγγελίας επιλέγεται από τον πελάτη κατα την διάρκεια της ολοκλήρωσης της παραγγελίας.
				</p>
				<p>
					Δείτε για τους διαθέσιμους τρόπους πληρωμής <a href="payment.php">εδώ</a>. 
				</p>
			</div>
			<button class="accordion"><h3>2. Παραλαβή</h3></button>
			<div class="panel">
				<p>
					Ο τρόπος παραλαβής μιας παραγγελίας επιλέγεται από τον πελάτη κατα την διάρκεια της ολοκλήρωσης της παραγγελίας.
				</p>
				<p>
					Δείτε για τους διαθέσιμους τρόπους παραλαβής <a href="shipping.php">εδώ</a>. 
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
