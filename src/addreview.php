<!DOCTYPE html>
<html>
<body>

<h2>Insert Movie Comment</h2>

<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
Movie: <INPUT TYPE="text" NAME="movie"><br>
<INPUT TYPE="submit" NAME="AddComment" VALUE="Add Movie Comment"><br>
</form><br>

<?php
	if ($_SERVER['REQUEST_METHOD'] === 'GET') 
	{
		if (isset($_GET['AddComment'])) 
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
			$movie = $_REQUEST['Review_movie'];
			
			#Get Movie ID from title
			$GetID = mysql_query("SELECT id FROM Movie WHERE title = \"" . $movie . "\"", $db_connection);

			if(mysql_num_rows($GetID) == 1)
			{
				$row = mysql_fetch_row($GetID);
				$id = $row[0];

				$query = "INSERT INTO Review VALUES(\"" . $name . "\", CURRENT_TIMESTAMP," . $id . ", " . $rating . ", \"" . $comment . "\")";

				if (mysql_query($query, $db_connection) === TRUE) 
				{
					
	    			echo "New Review Added successfully";
				} 
				else 
				{
	    			echo "Input Error: " . $query . "<br>" . mysql_error($db_connection);
				}

				#Close db

				mysql_close($db_connection);

			}
			else if(mysql_num_rows($GetID) == 0)
			{
				print "No Movie Found Called " . $movie . "<br />";
				mysql_close($db_connection);
			    exit(1);
			}
			else
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
				    		echo "<td><a href=\http://192.168.56.20/~cs143/Lab1C/src/review.php?Review_movie=$movie&id=$row[4]&GetMovie=Add+Comment+to+Movie\">$field</a></td>";
				    	else
				    		echo "<td>$field</td>";
				    }
				    echo "</tr>";
				}
				
				echo "</table></br>";
			}
			
		}
	}
?>

</body>
</html>
