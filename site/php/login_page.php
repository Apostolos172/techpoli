
	<?php // login_page.php
	
	// This page prints any errors associated with logging in
	// and it creates the entire login page, including the form.
	
		$page_title = "Σύνδεση στο λογαριασμό μου";
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
// Print any error messages, if they exist:
if (!empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">Τα ακόλουθα λάθη προέκυψαν:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Ξαναπροσπάθησε.</p>';
}
?>

		<main class="main">
			<h2>Log in</h2>
			<form class="login" action="login.php" method="post">
				<div class="imgcontainer">	
					<img src="../images/avatar.png" alt="Avatar" class="avatar">
				</div>

				<div class="container">
					<label for="email"><b>Email</b></label>
					<input type="text" placeholder="Συμπλήρωσε το email σου" name="email" required>

					<label for="psw"><b>Password</b></label>
					<input type="password" placeholder="Συμπλήρωσε τον κωδικό σου" name="psw" required>
        
					<button type="submit">Login</button>
					<input type="hidden" name="submitted" value="TRUE">
				</div>
			</form>
		</main>
		<?php 
			require_once "../html/footer.html";
		?>
	</body>
</html>
