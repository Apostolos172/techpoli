
<?php

	//Η συνάρτηση αυτή ανοίγει πίνακα
	function openTable()
	{
		echo "<table>";
	}
	
	//Η συνάρτηση αυτή κλείνει πίνακα
	function closeTable()
	{
		echo "</table>";
	}
	
	//Η συνάρτηση αυτή ανοίγει γραμμή
	function openRow()
	{
		echo "<tr>";
	}
	
	//Η συνάρτηση αυτή κλείνει γραμμή
	function closeRow()
	{
		echo "</tr>";
	}
	
	//Η συνάρτηση αυτή εμφανίζει ένα th element
	function th($txt = '', $width = '')
	{
		if($width!=null)
			echo "<th width=$width>";
		else
			echo "<th>";
		echo "$txt";
		echo "</th>";
		echo "\n";
	}
	
	//Η συνάρτηση αυτή εμφανίζει ένα td element
	function td($txt = '', $width = '')
	{
		if($width!=null)
			echo "<td width=$width>";
		else
			echo "<td>";
		echo "$txt";
		echo "</td>";
		echo "\n";
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
	function img($src, $widthPercent = '100')
	{
		$width = ''.$widthPercent.'%';
		print "<img src=$src width=$width>";
	}
	
	//Η συνάρτηση αυτή εμφανίζει p στη σελίδα html 
	function p($txt)
	{
		print "<p>";
		print "$txt";
		print "</p>";
	}
	
	//Η συνάρτηση εμφανίζει div με class
	function opendiv($class='')
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

?>
