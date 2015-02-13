<!DOCTYPE html>
<html>
<body>
<a href="index.php">Back to Home</a><br><br>
<?php
echo "<h1>Search for Information in Database:</h1>";
?>

<h2>Search for Actors and Movies</h2>

<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
Search Movies and Actors: <INPUT TYPE="search" NAME="search" SIZE=40><br>
Treat Spaces as: AND <INPUT TYPE="radio" NAME="space" VALUE="and" CHECKED> OR <INPUT TYPE="radio" NAME="space" VALUE="or"><br>
<INPUT TYPE="submit" NAME="submitsearch" VALUE="Search"><br>
</form><br>
 
<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
	if (isset($_GET['submitsearch'])) 
	{
		#Connect to db
		$db_connection = mysql_connect("localhost", "cs143", "");

		#Error check
		if(!$db_connection) {
		    $errmsg = mysql_error($db_connection);
		    print "Connection failed: $errmsg <br />";
		    exit(1);
		}

		#Select db
		mysql_select_db("CS143", $db_connection);

		#Take input from form
		$search_string = $_REQUEST['search']; 
		$strings = explode(" ", $search_string);
		$space = $_REQUEST['space']; 

		#Build queries
		if($space == "or")
		{
			$actorquery = "SELECT CONCAT(first,' ',last), sex, dob, dod, id FROM Actor WHERE ";
			for ($i=0; $i < count($strings); $i++) 
			{ 
				//$strings[$i] = mysql_real_escape_string($strings[$i]);
				if($i == 0)
					$actorquery = $actorquery . "CONCAT(first,' ',last) LIKE '%{$strings[$i]}%'";
				else
					$actorquery = $actorquery . " OR CONCAT(first,' ',last) LIKE '%{$strings[$i]}%'";
			}

			$moviequery = "SELECT title, year, rating, company, id FROM Movie WHERE ";
			for ($i=0; $i < count($strings); $i++) 
			{ 
				if($i == 0)
					$moviequery = $moviequery . "title LIKE '%{$strings[$i]}%'";
				else
					$moviequery = $moviequery . " OR title LIKE '%{$strings[$i]}%'";
			}
		}
		if($space == "and")
		{
			$actorquery = "SELECT CONCAT(first,' ',last), sex, dob, dod, id FROM Actor WHERE ";
			for ($i=0; $i < count($strings); $i++) 
			{ 
				//$strings[$i] = mysql_real_escape_string($strings[$i]);
				if($i == 0)
					$actorquery = $actorquery . "CONCAT(first,' ',last) LIKE '%{$strings[$i]}%'";
				else
					$actorquery = $actorquery . " AND CONCAT(first,' ',last) LIKE '%{$strings[$i]}%'";
			}

			$moviequery = "SELECT title, year, rating, company, id FROM Movie WHERE ";
			for ($i=0; $i < count($strings); $i++) 
			{ 
				if($i == 0)
					$moviequery = $moviequery . "title LIKE '%{$strings[$i]}%'";
				else
					$moviequery = $moviequery . " AND title LIKE '%{$strings[$i]}%'";
			}
		}
		#RUN QUERIES

		$results = mysql_query($actorquery, $db_connection);

		if ($results) 
		{
		 	#output query

			echo "<h3>Results from Search for Actors</h3>";

			#Form table and output results from query

			echo "<table border=1 cellspacing=1 cellpadding=2><tr align=center>";

			echo "<td><b>Full Name</b></td><td><b>Sex</b></td><td><b>Date of Birth</b></td><td><b>Date of Death</b></td>";

			echo "</tr>";

			while($row = mysql_fetch_row($results)) 
			{
			    echo "<tr align=center>";
			    for($i = 0; $i < mysql_num_fields($results) - 1; $i++)
			    {
			    	if($row[$i] != NULL)
			    		$field = $row[$i];
			    	else
			    		$field = "N/A";
			    	if($i == 0)
				    	echo "<td><a href=\"browseA.php?first&last=&id={$row[4]}&browse=Display\">$field</a></td>";
				    else
				    	echo "<td>$field</td>";
			    }
			    echo "</tr>";
			}
			
			echo "</table></br>";
		} 
		else 
		{
	    	echo "Input Error: " . $actorquery . "<br>" . mysql_error($db_connection) . "</br>";
		}

		$results = mysql_query($moviequery, $db_connection);

		if ($results) 
		{
		    #output query

			echo "<h3>Results from Search for Movies</h3>";

			#Form table and output results from query

			echo "<table border=1 cellspacing=1 cellpadding=2><tr align=center>";

			echo "<td><b>Title</b></td><td><b>Year</b></td><td><b>Rating</b></td><td><b>Company</b></td>";

			echo "</tr>";

			while($row = mysql_fetch_row($results)) 
			{
			    echo "<tr align=center>";
			    for($i = 0; $i < mysql_num_fields($results) - 1; $i++)
			    {
			    	if($row[$i] != NULL)
			    		$field = $row[$i];
			    	else
			    		$field = "N/A";
			    	if($i == 0)
				    	echo "<td><a href=\"browseM.php?title=&id={$row[4]}&browse=Display\">$field</a></td>";
				    else
				    	echo "<td>$field</td>";
			    }
			    echo "</tr>";
			}
			echo "</table>";
		} 
		else 
		{
	    	echo "Input Error: " . $moviequery . "<br>" . mysql_error($db_connection) . "</br>";
		}

		#Close db

		mysql_close($db_connection);
	}
}
?>
<a href="index.php">Back to Home</a><br><br>
</body>
</html>
