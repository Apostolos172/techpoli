
	<?php // register.php
	
	// Σελίδα δημιουργίας λογαριασμού
	
		$page_title = "Δημιουργία λογαριασμού";
		require_once "../html/head.html";
		require_once "../libraries/php/createElements.php"; 
	?>
	<body>
		<header class="header">
		<?php
			include "../html/navigation.html";
		?>
		</header>
		<main class="main">
<?php
// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

	require_once ('../../mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.

	// Check for a first name:
	if (empty($_POST['name'])) {
		$errors[] = 'Ξεχάσατε να εισάγετε το όνομά σας.';
	}else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['name']));
	}
	
	// Check for a last name:
	if (empty($_POST['surname'])) {
		$errors[] = 'Ξεχάσατε να εισάγετε το επώνυμό σας.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['surname']));
	}
	
	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'Ξεχάσατε να εισάγετε το email σας.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	
	// Check for a password and match against the confirmed password:
	if (!empty($_POST['psw'])) {
		if ($_POST['psw'] != $_POST['psw-repeat']) {
			$errors[] = 'Ο κωδικός σας δε ταιριάζει με τον επιβεβαιωμένο κωδικό.';
		} else {
			$p = mysqli_real_escape_string($dbc, trim($_POST['psw']));
		}
	} else {
		$errors[] = 'Ξεχάσατε να εισάγετε τον κωδικό σας.';
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		$email = $_POST['email'];
		$pass = $_POST['psw'];
		
		//query
		$q = "
			SELECT customer_id, customers.email, customers.pass
			FROM customers
			WHERE customers.email = '$email' OR customers.pass = SHA1('$pass');
		";	

		//Εκτέλεσε query
		$r = @mysqli_query ($dbc, $q); // Run the query.

		// Count the number of returned rows:
		$num = mysqli_num_rows($r);

		if ($num == 1) { // If it ran OK, δεν μπορεί να γραφτεί με αυτά τα στοιχεία.

			// Fetch and print all the records:
			while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
				$mail = $row['email'];
				$password = $row['pass'];
			}
			
			if((strcmp($email,$mail)==0)&&(strcmp($password,sha1($pass))==0))
			{
				putH('Κάτι πήγε στραβά!');
				p('Το email καθώς και ο κωδικός υπάρχουν. Άλλαξέ τα και ξαναδοκίμασε.');
			}
			else
			{
				putH('Κάτι πήγε στραβά!');
				if(strcmp($email,$mail)==0)
					p('Το email υπάρχει. Άλλαξέ το και ξαναπροσπάθησε.');
				else
					p('Ο κωδικός υπάρχει. Άλλαξέ τον και ξαναδοκίμασε.');
			}

			mysqli_free_result ($r); // Free up the resources.

		} else if ($num ==2) {
			putH('Κάτι πήγε στραβά!');
			p('Το email καθώς και ο κωδικός υπάρχουν. Άλλαξέ τα και ξαναδοκίμασε.');
		} else if ($num == 0){ // If no records were returned.
		
			// Make the query:
			$q = "	INSERT INTO customers (first_name, last_name, email, pass, registration_date) 
					VALUES ('$fn', '$ln', '$e', SHA1('$p'), NOW() );";		
			$r = @mysqli_query ($dbc, $q); // Run the query.
			if ($r) { // If it ran OK.
			
				// Print a message:
				opendiv("message");
				lineBreak();
				putH('Ευχαριστούμε που επιλέξατε την TechPoli.','','black','h1');
				p('Εγγράφηκες επιτυχώς σαν πελάτης του καταστήματός μας! Δες τις δυνατότητες που σου παρέχονται αφού συνδεθείς.');
				p('Καλό ταξίδι στον κόσμο της τεχνολογίας.');
				lineBreak();
				hr();
				closediv();
				
			} else { // If it did not run OK.
				
				// Public message:
				echo '<h1>System Error</h1>
				<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
				
				// Debugging message:
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
							
			} // End of if ($r) IF.
			
			mysqli_close($dbc); // Close the database connection.

			// Include the footer and quit the script:
			require_once "../html/footer.html"; 
			endPage();
			exit();
		}
		else {
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
				
		}
		
	} else { // Report the errors.
	
		putH('Κάτι πήγε στραβά!');
		echo '<p class="error">Τα ακόλουθα λάθη προέκυψαν:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Ξαναπροσπαθήστε.</p><p><br></p>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
		
			<form class="signup"  action="register.php" method="post">
				<div class="container">
					<h1>Sign Up</h1>
					<p>Συμπληρώστε τα πεδία της φόρμας για να δημιουργήσετε ένα λογαριασμό στο κατάστημά μας.</p>
					<hr>

					<label for="name"><b>Όνομα</b></label>
					<input value = "<?php if(isset($_POST['name'])){echo "{$_POST['name']}";}?>" type="text" name="name" placeholder="Συμπληρώστε το όνομά σας με ελληνικούς ή λατινικούς χαρακτήρες" >

					<label for="surname"><b>Επώνυμο</b></label>
					<input value = "<?php if(isset($_POST['surname'])){echo "{$_POST['surname']}";}?>" type="text" name="surname" placeholder="Συμπληρώστε το όνομά σας με ελληνικούς ή λατινικούς χαρακτήρες" >

					<label for="email"><b>Email</b></label>
					<input value = "<?php if(isset($_POST['email'])){echo "{$_POST['email']}";}?>"  type="email" name="email" placeholder="Συμπληρώστε το email σας" >

					<label for="psw"><b>Κωδικός</b></label>
					<input type="password" placeholder="Συμπληρώστε το κωδικό σας" name="psw" >

					<label for="psw-repeat"><b>Επιβεβαίωση κωδικού</b></label>
					<input type="password" placeholder="Επιβεβαιώστε το κωδικό σας" name="psw-repeat" >
    
					<p>Δημιουργώντας λογαριασμό αποδέχεσαι <a href="../php/faq.php">την Πολιτική Απορρήτου και τους Όρους Χρήσης</a> του ηλεκτρονικού μας καταστήματος.</p>

					<div class="clearfix">
						<button type="submit" class="signupbtn">Sign Up</button>
					</div>
					
					<input type="hidden" name="submitted" value="TRUE">
				</div>
			</form>

		</main>

		<?php 
			require_once "../html/footer.html";
			endPage();
		?>
