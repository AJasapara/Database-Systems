<!DOCTYPE html>
<html>
<head>
	<title>Actor Information</title>
</head>

<body>
	<h1>Actor Search</h1>
	<form action="" method="GET">

		<div class="label"><b>Name</b></div> 
		<input class="input-form text-field" type="text" name="name" maxlength="30">
		<br><br>

		<div class="button-container">
			<input class="submit-button" type="submit" value="Submit!" name="submit-button">
		</div>
	</form>

	<?php
		if(isset($_GET['submit-button']) && isset($_GET['name'])) {
			searchPerson();
		}

		function searchPerson() {
			// Establishing connection to database
			$db = new mysqli('localhost','cs143','','CS143');
			if($db->connect_errno > 0) {
				die('Unable to connect to database [' . $db->connect_error . ']');
			}

			echo "<h2>Matching Actors Are:</h2>";
			$name = $_GET['name'];
			$q = "SELECT id, CONCAT(Actor.first, ' ',Actor.last) AS 'Actor Name', dob AS 'Date of Birth' FROM Actor WHERE CONCAT(Actor.first, ' ',Actor.last)LIKE '%$name%'";

			
			if(!($rs = $db->query($q))) {
				$errmsg = $db->error;
				print "Query failed: $errmsg <br />";
				exit(1);
			}
			$columnInfo = mysqli_fetch_fields($rs);
			echo "<table border='1' cellspacing='1' cellpadding='2'>";
			echo "<tr>";

			// Print out first row of column names
			foreach($columnInfo as $attribute) {
				if($attribute->name !== "id"){
					echo "<th align='center'>";
					echo "$attribute->name";
					echo "</th>";
				}
			}

			echo "</tr>";

			//Print out query results
			while($row = $rs->fetch_assoc()) {
				echo "<tr>";
				echo "<td align='center'>";
				$id = $row['id'];
				$val = $row['Actor Name'];
				echo '<a href="actorInfo.php?id='.$id.'">'.$val.'</a>';
				echo "</td>";
				echo "<td align='center'>";
				$val = $row['Date of Birth'];
				echo '<a href="actorInfo.php?id='.$id.'">'.$val.'</a>';
				echo "</td>";
				echo "</tr>";
			}

			echo "</table>";
			$rs->free();

		}
	?>


</body>

</html>