<!DOCTYPE html>
<html>
<body>
<a href="index.php">Back to Home</a><br><br>
<?php
echo "<h1>Insert Information into Database:</h1>";
?>

<h2>Insert Actor/Director</h2>

<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
First Name: <INPUT TYPE="text" NAME="AD_first"><br>
Last Name: <INPUT TYPE="text" NAME="AD_last"><br>
Type: Actor <INPUT TYPE="radio" NAME="AD" VALUE="Actor" CHECKED>
Director <INPUT TYPE="radio" NAME="AD" VALUE="Director"><br>
Sex: Male <INPUT TYPE="radio" NAME="sex" VALUE="Male" CHECKED>
Female <INPUT TYPE="radio" NAME="sex" VALUE="Female"><br>
Date of Birth: <INPUT TYPE="date" NAME="AD_DOB"><br>
Date of Death: <INPUT TYPE="date" NAME="AD_DOD"> (Leave Blank if still alive)<br>
<INPUT TYPE="submit" NAME="AddActor" VALUE="Add Actor/Director"><br>
</form><br>
 
<?php
	
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		if (isset($_GET['AddActor'])) {
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
			$first = $_REQUEST['AD_first']; 
			$last = $_REQUEST['AD_last']; 

			if($_REQUEST['AD'] == "Actor") 
			{
				$table = "Actor";
			}
			else if($_REQUEST['AD'] == "Director")
			{
				$table = "Director";
			}
			else
			{
				print "No Type Selected: Director or Actor <br />";
				mysql_close($db_connection);
			    exit(1);
			}

			if($_REQUEST['sex'] == "Male") 
			{
				$sex = "Male";
			}
			else if($_REQUEST['sex'] == "Female")
			{
				$sex = "Female";
			}

			$DOB = $_REQUEST['AD_DOB']; 
			if($DOB == NULL)
				$DOB = 'NULL';
			$DOD = $_REQUEST['AD_DOD']; 
			if($DOD == NULL)
				$DOD = 'NULL';

			#Get MaxPersonID
			$GetID = mysql_query("SELECT id FROM MaxPersonID", $db_connection);
			$row = mysql_fetch_row($GetID);
			$id = $row[0];

			if($table == "Actor")
				$query = "INSERT INTO " . $table . " VALUES(" . $id . ", \"" . $last . "\", \"" . $first . "\", '" . $sex . "', " . $DOB . ", " . $DOD . ")";
			else if($table == "Director")
				$query = "INSERT INTO " . $table . " VALUES(" . $id . ", '" . $last . "', '" . $first . "', " . $DOB . ", " . $DOD . ")";

			if (mysql_query($query, $db_connection) === TRUE) 
			{
				#update MaxPersonID
				if (mysql_query("UPDATE MaxPersonID SET id = id + 1", $db_connection) === FALSE) 
				{
					echo "Error updating MaxPersonID " . mysql_error($db_connection);
					mysql_close($db_connection);
					exit(1);

				}
    			echo "New Actor/Director Added successfully";
			} 
			else {
    			echo "Input Error: " . $query . "<br>" . mysql_error($db_connection);
			}

			#Close db

			mysql_close($db_connection);

		}
	}
?>

<h2>Insert Movie</h2>

<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
Movie Title: <INPUT TYPE="text" NAME="Movie_title"><br>
Year: <INPUT TYPE="number" NAME="Movie_year" MIN="1850" MAX="2100"><br>
Rating: <INPUT TYPE="text" NAME="Movie_rating"><br>
Company: <INPUT TYPE="text" NAME="Movie_company"><br>
<INPUT TYPE="submit" NAME="AddMovie" VALUE="Add Movie"><br>
</form><br>

<?php
	
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		if (isset($_GET['AddMovie'])) {
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
			$movie = $_REQUEST['Movie_title']; 
			$year = $_REQUEST['Movie_year'];
			$rating = $_REQUEST['Movie_rating']; 
			$company = $_REQUEST['Movie_company']; 

			#Get MaxMovieID
			$GetID = mysql_query("SELECT id FROM MaxMovieID", $db_connection);
			$row = mysql_fetch_row($GetID);
			$id = $row[0];

			$query = "INSERT INTO Movie VALUES(" . $id . ", \"" . $movie . "\", " . $year . ", '" . $rating . "', '" . $company.  "')";

			if (mysql_query($query, $db_connection) === TRUE) 
			{
				#update MaxMovieID
				if (mysql_query("UPDATE MaxMovieID SET id = id + 1", $db_connection) === FALSE) 
				{
					echo "Error updating MaxMovieID " . mysql_error($db_connection);
					mysql_close($db_connection);
					exit(1);

				}
    			echo "New Movie Added successfully";
			} 
			else {
    			echo "Input Error: " . $query . "<br>" . mysql_error($db_connection);
			}

			#Close db

			mysql_close($db_connection);

		}
	}
?>

<h2>Add Movie Genre</h2>

<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
Movie Title: <INPUT TYPE="text" NAME="genre_title"><br>
Genre: <br><SELECT NAME="genre[ ]" MULTIPLE="yes" REQUIRED>
<OPTION VALUE="Action">Action</OPTION>
<OPTION VALUE="Adult">Adult</OPTION>
<OPTION VALUE="Adventure">Adventure</OPTION>
<OPTION VALUE="Animation">Animation</OPTION>
<OPTION VALUE="Comedy">Comedy</OPTION>
<OPTION VALUE="Crime">Crime</OPTION>
<OPTION VALUE="Documentary">Documentary</OPTION>
<OPTION VALUE="Drama">Drama</OPTION>
<OPTION VALUE="Family">Family</OPTION>
<OPTION VALUE="Fantasy">Fantasy</OPTION>
<OPTION VALUE="Horror">Horror</OPTION>
<OPTION VALUE="Musical">Musical</OPTION>
<OPTION VALUE="Mystery">Mystery</OPTION>
<OPTION VALUE="Romance">Romance</OPTION>
<OPTION VALUE="Sci-Fi">Sci-Fi</OPTION>
<OPTION VALUE="Short">Short</OPTION>
<OPTION VALUE="Thriller">Thriller</OPTION>
<OPTION VALUE="War">War</OPTION>
<OPTION VALUE="Western">Western</OPTION>
</SELECT><br>
<INPUT TYPE="submit" NAME="AddGenre" VALUE="Add Genre"><br>
</form><br>

<?php
	
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		if (isset($_GET['AddGenre'])) {
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
			$movie = $_REQUEST['genre_title'];
			$genre = $_REQUEST['genre'];

			#Get Movie ID from title
			$GetMID = mysql_query("SELECT id FROM Movie WHERE title = \"" . $movie . "\"", $db_connection);
			if(mysql_num_rows($GetMID) != 0)
			{
				$row = mysql_fetch_row($GetMID);
				$mid = $row[0];
			}
			else
			{
				print "No Movie Found Called " . $movie . "<br />";
				mysql_close($db_connection);
			    exit(1);
			}

			for($i = 0; $i < count($genre); $i++)
			{
				$query = "INSERT INTO MovieGenre VALUES(" . $mid . ", \"" . $genre[$i] . "\")";

				if (mysql_query($query, $db_connection) === TRUE) 
				{
	    			echo "New Genre: " . $genre[$i] . " Added successfully <br/>";
				} 
				else 
				{
	    			echo "Input Error: " . $query . "<br>" . mysql_error($db_connection);
				}
			}
			#Close db

			mysql_close($db_connection);

		}
	}
?>

<!--
<h2>Insert Movie Comment</h2>

<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
Your Name: <INPUT TYPE="text" NAME="Reviewer_name"><br>
Movie: <INPUT TYPE="text" NAME="Review_movie" VALUE="<?php echo $_REQUEST['Review_movie'];?>"><br>
Rating: <INPUT TYPE="number" NAME="Review_rating" MIN="0" MAX="10"><br>
Comment: <TEXTAREA NAME="Review_comment" ROWS=5 COLS=50></TEXTAREA><br>
<INPUT TYPE="submit" NAME="AddComment" VALUE="Add Movie Comment"><br>
</form><br>
-->
<?php
/*	
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		if (isset($_GET['AddComment'])) {
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
			$name = $_REQUEST['Reviewer_name']; 
			$movie = $_REQUEST['Review_movie'];
			$rating = $_REQUEST['Review_rating']; 
			$comment = $_REQUEST['Review_comment']; 

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
*/
?>

<h2>Insert Actor/Director to Movie Relationship</h2>

<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
Director <INPUT TYPE="radio" NAME="role" VALUE="Director" CHECKED>
Actor <INPUT TYPE="radio" NAME="role" VALUE="Actor"><br>
If Actor, What Role?: <INPUT TYPE="text" NAME="Role_des"><br>
Actor/Director Name: First <INPUT TYPE="text" NAME="Relate_firstname"> Last <INPUT TYPE="text" NAME="Relate_lastname"> was involved with<br>
Movie: <INPUT TYPE="text" NAME="Relate_movie"><br>
<INPUT TYPE="submit" NAME="AddRelation" VALUE="Add Relation"><br>
</form><br>

<?php
	
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		if (isset($_GET['AddRelation'])) {
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
			if($_REQUEST['role'] == "Director")
				$role = "Director"; 
			else if($_REQUEST['role'] == "Actor")
				$role = "Actor";
			else
			{
				print "No Role Selected: Director or Actor <br />";
				mysql_close($db_connection);
			    exit(1);
			}
			$fname = $_REQUEST['Relate_firstname'];
			$lname = $_REQUEST['Relate_lastname'];
			$movie = $_REQUEST['Relate_movie']; 
			$roledes = $_REQUEST['Role_des']; 

			#Get Movie ID from title
			$GetMID = mysql_query("SELECT id FROM Movie WHERE title = \"" . $movie . "\"", $db_connection);
			if(mysql_num_rows($GetMID) != 0)
			{
				$row = mysql_fetch_row($GetMID);
				$mid = $row[0];
			}
			else
			{
				print "No Movie Found Called " . $movie . "<br />";
				mysql_close($db_connection);
			    exit(1);
			}

			#Get Actor/Director ID from title
			$GetID = mysql_query("SELECT id FROM " . $role . " WHERE last = \"" . $lname . "\" AND first = \"" . $fname . "\"", $db_connection);
			if(mysql_num_rows($GetID) != 0)
			{
				$row = mysql_fetch_row($GetID);
				$id = $row[0];
			}
			else
			{
				print "No Actor/Director Found Named " . $fname . " " . $lname . "<br />";
				mysql_close($db_connection);
			    exit(1);
			}

			if($role == "Director")
				$query = "INSERT INTO MovieDirector VALUES(" . $mid . ", " . $id . ")";
			if($role == "Actor")
				$query = "INSERT INTO MovieActor VALUES(" . $mid . ", " . $id . ", \"" . $roledes . "\")";
			if (mysql_query($query, $db_connection) === TRUE) 
			{
    			echo "New Relationship Added successfully";
			} 
			else 
			{
    			echo "Input Error: " . $query . "<br>" . mysql_error($db_connection);
			}

			#Close db

			mysql_close($db_connection);

		}
	}
?>

<a href="index.php">Back to Home</a><br><br>

</body>
</html>
