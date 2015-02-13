<!DOCTYPE html>
<html>
<body>
<a href="index.php">Back to Home</a><br><br>
<?php
echo "<h1>Display Actor Page</h1>";
?>

<h2>What Actor Would You Like To View</h2>

<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
Actor Name: First <INPUT TYPE="text" NAME="first"> Last <INPUT TYPE="text" NAME="last">
<INPUT TYPE="number" NAME="id" VALUE="-1" HIDDEN>
<INPUT TYPE="submit" NAME="browse" VALUE="Display"><br>
</form><br>
 
<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
	if (isset($_GET['browse'])) 
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
		$first = $_REQUEST['first']; 
		$last = $_REQUEST['last'];
		$id = $_REQUEST['id'];

		if($id < 0)
		{
			$query = "SELECT CONCAT(first,' ',last), sex, dob, dod, id FROM Actor WHERE first = '{$first}' AND last = '{$last}'";
			$results = mysql_query($query, $db_connection);

			if(mysql_num_rows($results) > 1)
			{
				echo "<h3>More than one actor of the same name, which one did you mean?</h3>";
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
				    		echo "<td><a href=\"browseA.php?first=&last=&id={$row[4]}&browse=Display\">$field</a></td>";
				    	else
				    		echo "<td>$field</td>";
				    }
				    echo "</tr>";
				}
				
				echo "</table></br>";
			}
			else if(mysql_num_rows($results) == 0)
			{
				echo "Error No Actor Exists Named $first $last";
				mysql_close($db_connection);
				exit(1);
			}
			else
			{
				echo "<h3>Actor Information: $first $last</h3>";

				#Form table and output results from query

				echo "<table border=1 cellspacing=1 cellpadding=2><tr align=center>";

				echo "<td><b>Full Name</b></td><td><b>Sex</b></td><td><b>Date of Birth</b></td><td><b>Date of Death</b></td>";

				echo "</tr>";

				$row = mysql_fetch_row($results);
				
			    echo "<tr align=center>";

			    for($i = 0; $i < mysql_num_fields($results) - 1; $i++)
			    {
			    	if($row[$i] != NULL)
			    		$field = $row[$i];
			    	else
			    		$field = "N/A";
			    	echo "<td>$field</td>";
			    }
			    echo "</tr>";
				
				echo "</table></br>";

				echo "<h3>{$first} {$last} has been in the following Movies:</h3>";

				$query2 = "SELECT title, year, rating, company, M.id FROM Movie M, Actor A, MovieActor MA WHERE M.id = MA.mid AND MA.aid = A.id AND A.id = {$row[4]}";
				
				$results2 = mysql_query($query2, $db_connection);

				echo "<table border=1 cellspacing=1 cellpadding=2><tr align=center>";

				echo "<td><b>Title</b></td><td><b>Year</b></td><td><b>Rating</b></td><td><b>Company</b></td>";

				echo "</tr>";

				while($row = mysql_fetch_row($results2)) 
				{
				    echo "<tr align=center>";
				    for($i = 0; $i < mysql_num_fields($results2) - 1; $i++)
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
				
				echo "</table></br>";
			}
		}
		else
		{

			$query = "SELECT CONCAT(first,' ',last), sex, dob, dod, id FROM Actor WHERE id = {$id}";
			
			$results = mysql_query($query, $db_connection);

			$row = mysql_fetch_row($results);

			echo "<h3>Actor Information: $row[0]</h3>";

			#Form table and output results from query

			echo "<table border=1 cellspacing=1 cellpadding=2><tr align=center>";

			echo "<td><b>Full Name</b></td><td><b>Sex</b></td><td><b>Date of Birth</b></td><td><b>Date of Death</b></td>";

			echo "</tr>";
			
		    echo "<tr align=center>";

		    for($i = 0; $i < mysql_num_fields($results) - 1; $i++)
		    {
		    	if($row[$i] != NULL)
		    		$field = $row[$i];
		    	else
		    		$field = "N/A";
		    	echo "<td>$field</td>";
		    }
		    echo "</tr>";
			
			echo "</table></br>";

			echo "<h3>$row[0] has been in the following Movies:</h3>";

			$query2 = "SELECT role, title, year, rating, company, M.id FROM Movie M, Actor A, MovieActor MA WHERE M.id = MA.mid AND MA.aid = A.id AND A.id = {$row[4]}";
			
			$results2 = mysql_query($query2, $db_connection);

			echo "<table border=1 cellspacing=1 cellpadding=2><tr align=center>";

			echo "<td><b>Role</b></td><td><b>Title</b></td><td><b>Year</b></td><td><b>Rating</b></td><td><b>Company</b></td>";

			echo "</tr>";

			while($row = mysql_fetch_row($results2)) 
			{
			    echo "<tr align=center>";
			    for($i = 0; $i < mysql_num_fields($results2) - 1; $i++)
			    {
			    	if($row[$i] != NULL)
			    		$field = $row[$i];
			    	else
			    		$field = "N/A";
			    	if($i == 1)
				    	echo "<td><a href=\"browseM.php?title=&id={$row[5]}&browse=Display\">$field</a></td>";
				    else
				    	echo "<td>$field</td>";
			    }
			    echo "</tr>";
			}
			
			echo "</table></br>";
		}

		mysql_close($db_connection);
	}
}

?>
<a href="index.php">Back to Home</a><br><br>
</body>
</html>