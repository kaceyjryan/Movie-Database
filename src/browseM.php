<!DOCTYPE html>
<html>
<body>
<a href="index.php">Back to Home</a><br><br>
<?php
echo "<h1>Display Movie Page</h1>";
?>

<h2>What Movie Would You Like To View</h2>

<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
Movie Title <INPUT TYPE="text" NAME="title">
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
		if(!$db_connection) 
		{
		    $errmsg = mysql_error($db_connection);
		    print "Connection failed: $errmsg <br />";
		    exit(1);
		}

		#Select db
		mysql_select_db("CS143", $db_connection);

		#Take input from form
		$title = $_REQUEST['title']; 
		$id = $_REQUEST['id'];

		if($id < 0 || $id == '')
		{
			$query = "SELECT title, year, rating, company, id FROM Movie WHERE title = '{$title}'";
			$results = mysql_query($query, $db_connection);

			if(mysql_num_rows($results) > 1)
			{
				echo "<h3>More than one movie of the same name, which one did you mean?</h3>";
				
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
				
				echo "</table></br>";
			}
			else if(mysql_num_rows($results) == 0)
			{
				echo "Error No Movie Exists Called $title";
				mysql_close($db_connection);
				exit(1);
			}
			else
			{
				echo "<h3>Movie Information: $title</h3>";

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

				echo "<h3>$title has the following actors and actresses:</h3>";

				$id = $row[4];

				$query2 = "SELECT CONCAT(first, ' ', last), sex, dob, dod, A.id FROM Movie M, Actor A, MovieActor MA WHERE M.id = MA.mid AND MA.aid = A.id AND M.id = {$row[4]}";
				
				$results2 = mysql_query($query2, $db_connection);

				echo "<table border=1 cellspacing=1 cellpadding=2><tr align=center>";

				echo "<td><b>Full Name</b></td><td><b>Sex</b></td><td><b>Date of Birth</b></td><td><b>Date of Death</b></td>";

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
				    		echo "<td><a href=\"browseA.php?first=&last=&id={$row[4]}&browse=Display\">$field</a></td>";
				    	else
				    		echo "<td>$field</td>";
				    }
				    echo "</tr>";
				}
				
				echo "</table></br>";

				echo "<h3>Movie Reviews for $title</h3>";

				$avg_rating_query = "SELECT AVG(rating) FROM Review WHERE mid = {$id}";
				$avg_rating_results = mysql_query($avg_rating_query, $db_connection);
				$avg_rating_row = mysql_fetch_row($avg_rating_results);
				$avg_rating = $avg_rating_row[0];

				echo "<button onclick=\"location.href='review.php?movie={$title}'\">
     				Add a Review for $title</button><br>";
				
				if($avg_rating)
				{
					echo "<h4>Average Rating for $title: $avg_rating</h4>";

					$query3 = "SELECT rating, comment, name, time, mid FROM Review WHERE mid = {$id}";
					
					$results3 = mysql_query($query3, $db_connection);

					echo "<table border=1 cellspacing=1 cellpadding=2><tr align=center>";

					echo "<td><b>Rating</b></td><td><b>Comment</b></td><td><b>Name</b></td><td><b>Date</b></td>";

					echo "</tr>";

					while($row = mysql_fetch_row($results3)) 
					{
					    echo "<tr align=center>";
					    for($i = 0; $i < mysql_num_fields($results3) - 1; $i++)
					    {
					    	if($row[$i] != NULL)
					    		$field = $row[$i];
					    	else
					    		$field = "N/A";
						    echo "<td>$field</td>";
					    }
					    echo "</tr>";
					}
					echo "</table></br>";
				}
				else
					echo "There have not been any reviews yet. Post one of your own!";
			}
		}
		else
		{

			$query = "SELECT title, year, rating, company, id FROM Movie WHERE id = {$id}";
			
			$results = mysql_query($query, $db_connection);

			$row = mysql_fetch_row($results);

			$title = $row[0];

			echo "<h3>Movie Information: $row[0]</h3>";

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

			echo "<h3>$row[0] has the following actors and actresses:</h3>";

			$query2 = "SELECT CONCAT(first,' ',last), role, sex, dob, dod, A.id FROM Movie M, Actor A, MovieActor MA WHERE M.id = MA.mid AND MA.aid = A.id AND M.id = {$row[4]}";
			
			$results2 = mysql_query($query2, $db_connection);

			echo "<table border=1 cellspacing=1 cellpadding=2><tr align=center>";

			echo "<td><b>Full Name</b></td><td><b>Role</b></td><td><b>Sex</b></td><td><b>Date of Birth</b></td><td><b>Date of Death</b></td>";

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
				    	echo "<td><a href=\"browseA.php?first&last=&id={$row[5]}&browse=Display\">$field</a></td>";
				    else
				    	echo "<td>$field</td>";
			    }
			    echo "</tr>";
			}
			
			echo "</table></br>";

			echo "<h3>Movie Reviews for $title</h3>";

			$avg_rating_query = "SELECT AVG(rating) FROM Review WHERE mid = {$id}";
			$avg_rating_results = mysql_query($avg_rating_query, $db_connection);
			$avg_rating_row = mysql_fetch_row($avg_rating_results);
			$avg_rating = $avg_rating_row[0];

			echo "<button onclick=\"location.href='review.php?movie={$title}'\">
     			Add a Review for $title</button><br>";

			if($avg_rating)
			{
				echo "<h4>Average Rating for $title: $avg_rating</h4>";

				$query3 = "SELECT rating, comment, name, time, mid FROM Review WHERE mid = {$id}";
				
				$results3 = mysql_query($query3, $db_connection);

				echo "<table border=1 cellspacing=1 cellpadding=2><tr align=center>";

				echo "<td><b>Rating</b></td><td><b>Comment</b></td><td><b>Name</b></td><td><b>Date</b></td>";

				echo "</tr>";

				while($row = mysql_fetch_row($results3)) 
				{
				    echo "<tr align=center>";
				    for($i = 0; $i < mysql_num_fields($results3) - 1; $i++)
				    {
				    	if($row[$i] != NULL)
				    		$field = $row[$i];
				    	else
				    		$field = "N/A";
					    echo "<td>$field</td>";
				    }
				    echo "</tr>";
				}
				echo "</table></br>";
			}
			else
				echo "There have not been any reviews yet. Post one of your own!";
		}
		mysql_close($db_connection);
	}
}

?>
<a href="index.php">Back to Home</a><br><br>
</body>
</html>