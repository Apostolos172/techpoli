
<?php // createElements.php

// εμφάνιση διαφόρων elements με php

	// \n in coding
	function n()
	{
		print "\n";
	}

	//Η συνάρτηση αυτή εμφανίζει ένα js script
	function js($script)
	{
		echo "<script>";
			echo $script;
		echo "</script>";
	}

	//Η συνάρτηση αυτή κλείνει body & html
	function endPage()
	{
			n();
			echo "</body>";
		n();
		echo "</html>";
	}
	
	//Η συνάρτηση αυτή αλλάζει σειρά στη σελίδα html 
	function lineBreak()
	{
		print "<br>";
	}
	
	//Η συνάρτηση αυτή εμφανίζει hr στη σελίδα html 
	function hr()
	{
		print "<hr>";
	}
	
	//Η συνάρτηση αυτή εμφανίζει ένα a element
	function a($href, $display)
	{
		echo "<a href=$href>";
		echo "$display";
		echo "</a>";
	}
	
	//Η συνάρτηση αυτή εμφανίζει img στη σελίδα html 
	function img($src, $widthPercent = '')
	{
		if($widthPercent!=null)
		{
			$width = ''.$widthPercent.'%';
			print "<img src='$src' width=$width>";
		}
		else
			print "<img src='$src'>";
	}
	
	//Η συνάρτηση αυτή εμφανίζει p στη σελίδα html 
	function p($txt)
	{
		print "<p>";
		print "$txt";
		print "</p>";
	}
	
	//Η συνάρτηση εμφανίζει div με class
	function opendiv($class='', $id='')
	{
		if($class!=null)
			print "<div class=$class>";
		else
			print "<div>";
	}

	//Η συνάρτηση αυτή κλείνει div
	function closediv()
	{
		print "</div>";
	}
	
	//Η συνάρτηση αυτή εμφανίζει στη σελίδα html έναν τίτλο ($title) με tag $H (h1-h5)
	function putH($title, $id='', $color="black", $H="h2")
	{
		if($id!=null)
			print "<$H id=$id >";
		else
			print "<$H>";
		print "$title";
		print "</$H>";
		if(strcmp($id,'')!=0)
			echo "<script>window.document.getElementById('$id').style.color='$color'</script>";
	}
	
	//----------------------------------------------------
	
	//Η συνάρτηση αυτή εμφανίζει την κάρτα ενός προϊόντος
	function createAProductCard($pid, $img, $name, $OEM, $price)
	{
		opendiv();
			img($img);
			lineBreak();
			$url = "product.php?pid=$pid";
			echo "<a href='$url'>$name</a>";
			putH($OEM);
			echo "<span>$price</span>";
		closediv();
		n();
	}
	
	//----------------------------------------------------
	
	//Η συνάρτηση αυτή εμφανίζει εικόνα με ιδιότητα περιστροφής σε κείμενο σε περίπτωση hover
	function createFlipBox($pid = 1, $price = 10, $title = 'Name of product', $img = 'https://external.webstorage.gr/Product-Images/1511691/iphonese-2nd-generation-red-400-1511691.jpg')
	{
		opendiv("flip-box");
			opendiv("flip-box-inner");
				opendiv("flip-box-front");
					echo "<img class='flip-image-with-text' src='$img'>";
				closediv();
				opendiv("flip-box-back");
					putH($title);
					putH($price);
				closediv();
			closediv();
			echo "<a href='site/php/product.php?pid=$pid'>Δες περισσότερα...</a>";
		closediv();
	}
	
	//Η συνάρτηση αυτή ανοίγει το τμήμα που περιέχει τα FlipBox
	function openChapterWithFlip($title, $id)
	{
		opendiv();
			putH($title, $id);
			opendiv('flips-container');
	}
	
	//Η συνάρτηση αυτή κλείνει το τμήμα που περιέχει τα FlipBox
	function closeChapterWithFlip()
	{
			closediv();
		closediv();
	}
	
	//----------------------------------------------------
	
	//Η συνάρτηση αυτή εμφανίζει εικόνα με ιδιότητα εμφάνισης κειμένου με zoom σε περίπτωση hover
	function createOverlayBox($pid = 1, $price = 10, $title = 'Name of product', $img = 'https://external.webstorage.gr/Product-Images/1511691/iphonese-2nd-generation-red-400-1511691.jpg')
	{
		opendiv("zoom-container");
			echo "<img class='image' src=$img>";
			opendiv("overlay");
				opendiv("text");
					putH($title);	
					putH($price);	
					echo "<a href='site/php/product.php?pid=$pid'>Δες περισσότερα...</a>";
				closediv();
			closediv();
		closediv();
	} 
	
	//Η συνάρτηση αυτή ανοίγει το τμήμα που περιέχει τα OverlayBox
	function openChapterWithZoom($title, $id)
	{
		opendiv();
			putH($title, $id);
			opendiv('zooms-container');
	}
	
	//Η συνάρτηση αυτή κλείνει το τμήμα που περιέχει τα OverlayBox
	function closeChapterWithZoom()
	{
			closediv();
		closediv();
	}
	
	//----------------------------------------------------
	
	//Η συνάρτηση αυτή εμφανίζει ένα modal box
	function openModal($message)
	{
		opendiv("modal","myModal");
			opendiv("modal-content");
				echo "<span class='close'>&times;</span>";
				echo "<p>$message</p>";
			closediv();
		closediv();
	}
	
?>