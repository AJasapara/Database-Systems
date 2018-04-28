<!-- name varchar(20), time timestamp, mid int, rating int, comment varchar(500) -->

<!DOCTYPE html>
<html>
<head>
	<title>Add Actor to Movie</title>
</head>

<body>
	<h1>Add Actor to Movie</h1>
	<form action="" method="GET">

		<div class="label"><b>Movie title</b></div> 
		<?php
			$db = new mysqli('localhost','cs143','','CS143');
			if($db->connect_errno > 0) {
				die('Unable to connect to database [' . $db->connect_error . ']');
			}

			$movieQuery = "SELECT id, title, year from Movie";
			$movieRes = $db->query($movieQuery);

			// Show movies in dropdown
			echo '<select class"dropdown text-field" name="movie-list"> 
			<option disabled selected value></option>';

			while($row = $movieRes->fetch_assoc()) {
				echo '<option value="' . $row[id] . '">' . $row[title] . ' (' . $row[year] . ')</option>';
			}

			echo '</select>';

		?>

		<br><br>

		<div class="label"><b>Actor name</b></div> 
		<?php
			

			$actorQuery = "SELECT id, first, last from Actor";
			$actorRes = $db->query($actorQuery);

			// Show movies in dropdown
			echo '<select class"dropdown text-field" name="actor-list"> 
			<option disabled selected value></option>';

			while($row = $actorRes->fetch_assoc()) {
				echo '<option value="' . $row[id] . '">' . $row[first] . " ".  $row[last] . '</option>';
			}

			echo '</select>';

		?>


		<br><br>
		<div class="label"><b>Role</b></div> 
		<input class="input-form text-field" type="text" name="role" maxlength="30">
		
		<br><br>

		<div class="button-container">
			<input class="submit-button" type="submit" value="Add!" name="submit-button">
		</div>
	</form>

	<?php
		if(isset($_GET['submit-button'])) {
			if(inputValid() == true) {
				// echo "<br>input valid!";
				addActorToMovie($db);
			}
		}

		function inputValid() {
			// Name, rating cannot be null. Review can be empty. 
			$roleNotEmpty =  $validActor = $validMovie = false;
			
		

			if(!empty($_GET['role'])) 
				$roleNotEmpty = true;
				
			if(isset($_GET['movie-list']))  
				$validMovie = true;

			if(isset($_GET['actor-list']))  
				$validActor = true;
				
	
			// Check if everything is valid
			if($validActor  == true  && $roleNotEmpty  == true  && $validMovie  == true) 
				return true; // everything is valid
			

			// not everything is valid :-( So print errors
			$errMsg = "<br>Error: <br>";
			
			if($validActor == false) 
				$errMsg = $errMsg . "No actor chosen<br>";

			if($validMovie == false) 
				$errMsg = $errMsg . "No movie chosen<br>";

			if($roleNotEmpty == false) 
				$errMsg = $errMsg . "Role not entered<br>";

			
			// display error message
			echo $errMsg;

			return false;
		}

	

		function addActorToMovie($db) {
			$mid = $_GET['movie-list'];
			$aid =  $_GET['actor-list'];
			$role = $_GET['role'];

			// echo $mid . " " . $aid . " " . $role;

			// create query
			$addActorToMovieQuery = "INSERT INTO MovieActor(mid, aid, role) VALUES('$mid','$aid','$role')";
			//MovieActor(mid int, aid int, role varchar(50)
			
			// Check if both queries were successful
			if($db->query($addActorToMovieQuery) === true ) {
				// success
				$successMsg = "<br>Added actor to movie successfully!<br>";
				echo $successMsg;
			}

			else { // Insert failed :-()
				$err = $db->error;
				echo "FAIL";
				echo $err;
			}
			
		}
	?>



</body>

</html>