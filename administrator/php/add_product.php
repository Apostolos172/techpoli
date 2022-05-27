
<?php // add_product.php

// Εδώ φαίνεται μια απλή φόρμα εισαγωγής νέου προϊόντος στο ηλεκτρονικό κατάστημα
// Φτάνεις εδώ από το μενού του περιβάλλοντος με την επιλογή Add product

	$page_title = 'Add a product'; 
	require_once "../html/header.html";
	require_once ('../libraries/php/createElements.php'); // library
?>
<main class="main">

<?php

require_once ('../../mysqli_connect.php');

if (isset($_POST['submitted'])) { // Handle the form.
	
	// Validate the incoming data...
	$errors = array();
	
	$name = (string)trim($_POST['nameOfProduct']);
	$OEM = (string)trim($_POST['OEM']);
	$price = (float)trim($_POST['price']);
	$img = (string)trim($_POST['img']);
	$category = (string)trim($_POST['category']);
	$description = (string)trim($_POST['description']);
	$date = date("Y-m-d H:i:s");
	
	if (empty($errors)) { // If everything's OK.
	
		// Add the print to the database:
		$q = '
		INSERT INTO products (name, OEM, price, path_the_img_file, entry_date, description, category) 
		VALUES (?, ?, ?, ?, ?, ?, ?);';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'ssdssss', $name, $OEM, $price, $img, $date, $description, $category);
		mysqli_stmt_execute($stmt);

		// Check the results...
		if (mysqli_stmt_affected_rows($stmt) == 1) {
		
			// Print a message:
			p('The product has been added.');
			
			// Clear $_POST:
			$_POST = array();
			
		} else { // Error!
			echo '<p style="font-weight: bold; color: #C00">Your submission could not be processed due to a system error.</p>'; 
		}
		
		mysqli_stmt_close($stmt);
		
	} // End of $errors IF.
	
} // End of the submission IF.

// Display the form...
?>
<h1>Add a Product</h1>
<form action="add_product.php" method="post">
	<fieldset>
		<legend>Fill out the form to add a product to the catalog:</legend>
		<label>Όνομα προϊόντος: <input type="text" name="nameOfProduct" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" required placeholder="Tablet Samsung Tab A T510 2019 10.1 32GB Μαύρο"></label> 
		<label>Κατασκευαστής προϊόντος: <input type="text" name="OEM" value="<?php if (isset($_POST['OEM'])) echo $_POST['OEM']; ?>" required placeholder="SAMSUNG" ></label> 
		<label>Τιμή προϊόντος: <input type="text" name="price" value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>" required placeholder="229.0" ></label> 
		<label>Διεύθυνση εικόνας προϊόντος: <input type="text" name="img" value="<?php if (isset($_POST['img'])) echo $_POST['img']; ?>" required placeholder="https://cmsassets.public.gr/mrk/202005/8801643898076.mainImage.png" ></label> 
		<label>Κατηγορία προϊόντος: 
		<select name="category" id="category" required>
			<option value="">--Επέλεξε κατηγορία--</option>
			<option value="laptop">laptop</option>
			<option value="pc">pc</option>
			<option value="peripheral">peripheral</option>
			<option value="HDD">HDD</option>
			<option value="external_HDD">external_HDD</option>
			<option value="usb_flash_memory">usb_flash_memory</option>
			<option value="smartphone">smartphone</option>
			<option value="tablet">tablet</option>
			<option value="accessories">accessories</option>
		</select>
		</label> 
		<label for="description">Περιγραφή:</label>
		<textarea id="description" name="description" rows="10" placeholder="To Samsung Tab A είναι ένα tablet 10.1’’ που πηγαίνει την multimedia εμπειρία σε  άλλο επίπεδο, χάρη στην μεγάλη οθόνη του με narrow bezel & τον 3D ήχο που οφείλει στο Dolby Atmos αλλά και την  μπαταρία των 6150mΑh που σου δίνει τη δυνατότητα να απολαμβάνεις την αγαπημένη σου σειρά/videos για ώρες! Είναι ιδανικό για να καλύψει κάθε ανάγκη της οικογένειας. Τα παιδιά μπορούν να απολαύσουν τα αγαπημένα τους videos χωρίς να ανησυχείτε,  αφού με το Kids Home Content προστατεύονται από κάθε επικίνδυνο περιεχόμενο. Ενώ με την εφαρμογή Family Sharing μπορείτε να μοιραστείτε με όλα τα μέλη της οικογένειας αρχεία, το πρόγραμμά σας, φωτογραφίες αλλά και να λαμβάνετε Notifications." required></textarea>
		<div align="center"><input type="submit" name="submit" value="Προσθήκη προϊόντος"></div>
		<input type="hidden" name="submitted" value="TRUE">
	</fieldset>
</form>

</main>
<?php
	require_once "../html/footer.html";
?>
