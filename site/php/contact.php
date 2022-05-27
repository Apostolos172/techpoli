
	<?php // contact.php
	
	// Σελίδα επικοινωνίας με το κατάστημα
	// Σε πραγματικό σενάριο θα μπορούσε η ερώτηση να αποστέλλεται με email στην επιχείρηση, 
	// 	 εδώ απλά εμφανίζεται για λίγο η υποβληθείσα ερώτηση στη σελίδα
	
	$page_title="Επικοινωνήστε μαζί μας";
	require_once "../html/head.html"; 
	require_once "../libraries/php/createElements.php";
?>
	<body>
		<header class="header">
			<?php require_once "../html/navigation.html"; ?>
		</header>
		<main class="main">
		
<?php
	if(isset($_POST['submit']))
	{
		$errors = array(); // Initialize an error array.
	
		//Τα ακόλουθα τα αποτρέπει η html (required)
		// Check for a name:
		if (empty($_POST['name'])) {
			$errors[] = 'Ξεχάσατε να εισάγετε το ονοματεπώνυμό σας.';
		} 
		else {
			$name = trim($_POST['name']);
		}
	
		// Check for an email address:
		if (empty($_POST['mail'])) {
			$errors[] = 'Ξεχάσατε να εισάγετε το email σας.';
		} 
		else {
			$email = trim($_POST['mail']);
		}
		
		// Check for comments:
		if (empty($_POST['comments'])) {
			$errors[] = 'Ξεχάσατε να επισημάνετε τι ακριβώς θέλετε.';
		} 
		else {
			$comments = trim($_POST['comments']);
		}
		
		if(empty($errors)) // όλα καλά, στείλε mail
		{
			$subject = $_POST['questions'];
			
			//Θα μπορούσε να αποστέλεται ένα email προς την επιχείρηση μέσω της php
			
			// the message
			$msg = "The question of the customer $name with email address $email. $comments";
			
			lineBreak();
			echo $msg;
			
			openModal('Η ερώτησή σου καταχωρήθηκε. Θα επικοινωνήσουμε μαζί σου εντός δύο ημερών το αργότερο.');
			js('setTimeout(function(){closeModal();},4500);');
			js("redirectionTo_In('contact.php',6000);");
			
			// Finish the page and quit the script:
			echo "	<aside class='aside'>
						<h2>Πού θα μας βρείτε</h2>";
						require_once "../html/map.html"; 
			echo "	</aside>";
			require_once "../html/footer.html"; 
			endPage();
			exit();
		}
		else { // Report the errors.
	
			putH('Κάτι ξέχασες!');
			echo "<p class='error'>Τα ακόλουθα λάθη προέκυψαν:<br>";
			foreach ($errors as $msg) { // Print each error.
				echo " - $msg<br>\n";
			}
			echo '</p><p>Ξαναπροσπαθήστε.</p><p><br></p>';	
		}
	}
?>
		
			<div id="contact_form">
				<form method="post" action="contact.php">
					<fieldset>
						<legend> <b><i>Επικοινωνήστε μαζί μας</i></b> </legend>
						<br>
						<label for="name" > Ονοματεπώνυμο (5 έως 50 χαρακτήρες): </label>
						<input value = "<?php if(isset($_POST['name'])){echo "{$_POST['name']}";}?>"  type="text" name="name" id="name" minlength="5" maxlength="50" size="50" placeholder="Απόστολος Βαδραχάνης" required>
						<br>
						<br>
						<label for="mail" > Email: </label>
						<input value = "<?php if(isset($_POST['mail'])){echo "{$_POST['mail']}";}?>" type="email" name="mail" id="mail" size="40" placeholder="dai19172@uom.edu.gr" required>
						<br>
						<br>
						<label for="choise_of_question" > Διάλεξε το θέμα που σας απασχολεί </label>
						<select name="questions" id="choise_of_question" > 
							<option value=" "> Διάλεξε από τη λίστα </option>
							<option value="technical_question"> Τεχνική ερώτηση </option>
							<option value="other"> Άλλο </option>
						</select>
						<br>
						<br>
						<label for="comments" > Περιγράψτε τι ακριβώς θέλετε: </label>
						<textarea value = "<?php if(isset($_POST['comments'])){echo "{$_POST['comments']}";}?>" id="comments" name="comments" rows="4" cols="60" placeholder="Υπάρχουν όλα τα προϊόντα ετοιμοπάραδοτα;" ></textarea>
						<br>
						<br>
						<input type="submit" name="submit" value="Αποστολή" >
					</fieldset>
				</form>
			</div>
		</main>
		<aside class="aside">
			<h2>Πού θα μας βρείτε</h2>
			<?php require_once "../html/map.html"; ?>
		</aside>
		<?php 
			require_once "../html/footer.html"; 
			endPage();
		?>