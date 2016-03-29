<!DOCTYPE html>
<html>
<head>	
	<style>

		.container {
			background-color: #6A306F;
			padding-bottom: 20px;
		}
		#button {
			-webkit-transition-duration: 0.4s; /* Safari */
		    transition-duration: 0.4s;
		    background-color: white; /* Green */
		    border: 2px solid #4CAF50;
		    color: black;
		    text-align: center;
		    text-decoration: none;
		    font-size: 16px;
		    cursor: pointer;
		    border-radius: 7px;
		  	box-shadow: 0 3px #999;
		}
		#button:hover {
		    background-color: #4CAF50; /* Green */
		    color: white;
		}
		#formContainer {
			padding-top: 20px;
		}
		body {
			background-color: #939393;
		}
		textarea {
			resize:none;
		}
		table, th, td {

		     border: 1px solid white;
		     margin-left:auto; 
		     margin-right:auto;
		     color: white;
		}
		table th {
			background-color: #B158B0;
		}
		table td {
			background-color: #CC93C3;
		}
		::-webkit-input-placeholder {
   		padding-top: 20px;
   		text-align: center;
   		font-size: 15px;
}

	</style>
</head>

<body style="text-align:center;">

	<div class="container">

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="formContainer">
		<textarea name="when" rows="15" columns="30" placeholder="When/Where"></textarea>
		<textarea name="event" rows="15" columns="30" placeholder="Event"></textarea>
		<textarea name="emotion" rows="15" columns="30" placeholder="Emotion"></textarea>
		<textarea name="autoThoughts" rows="15" columns="30" placeholder="Automatic Thoughts"></textarea>
		<textarea name="ratResp" rows="15" columns="30" placeholder="Rational Response"></textarea>
		<br>
		<input type="submit" name="Submit" id="button">
		<br>
		<input type="submit" name="showDiary" value="Show Diary Entries" id="button">
		<br>
		<input type="submit" name="showLast" value="Show last Diary Entry" id="button">
	</form>
	<br>

<?php

	$servername = "localhost";
	$username = "username";
	$password = "CS230";
	$dbname = "MyDB";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	if(isset($_POST['Submit'])){
		$when = test_input($_POST['when']);	
		$event = test_input($_POST['event']);
		$emotion = test_input($_POST['emotion']);
		$automaticthoughts = test_input($_POST['autoThoughts']);
		$rationalresponse = test_input($_POST['ratResp']);

		if(empty($when) || empty($event) || empty($emotion) || empty($automaticthoughts) || empty($rationalresponse)){
			echo "You must ensure you have entered entered information in each field before clicking submit";
		}
		else{
			$sqlIns = "INSERT INTO MyDiary (whenwhere, event, emotion, automaticThoughts, rationalResponse) VALUES ('$when', '$event', '$emotion', '$automaticthoughts', '$rationalresponse')";
			if ($conn->query($sqlIns) === TRUE) {
			    echo "New record created successfully";
			} else {
			    echo "Error: " . $sqlIns . "<br>" . $conn->error;
			}
		}
	}

	function test_input($data) {
	   $data = trim($data);
	   $data = stripslashes($data);
	   return $data;
	}

	if(isset($_POST['showDiary'])){

		$sqlRet = "SELECT * FROM MyDiary";
		//$sqlRet = "SELECT id, whenwhere, event, emotion, automaticThoughts, rationalResponse, reg_date FROM MyDiary";
		$result = $conn->query($sqlRet);
		

		if ($result->num_rows > 0) {
		    echo "<table><tr><th>Entry Number</th><th>When/Where</th><th>Event</th><th>Emotion</th><th>Automatic Thoughts</th><th>Rational Response</th><th>Date/Time</th></tr>";
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        echo "<tr><td>".$row["id"]."</td><td>".$row["whenwhere"]."</td><td>".$row["event"]."</td><td>".$row["emotion"]."</td><td>".$row["automaticThoughts"]."</td><td>".$row["rationalResponse"]."</td><td>".$row["reg_date"]."</td></tr>";
		    }
		    echo "</table>";
		} else {
		    echo "No diary entries to view";
		}	
		$conn->close();
	}

	if(isset($_POST['showLast'])){

		$sqlRet = "SELECT * FROM MyDiary ORDER BY id DESC LIMIT 1";
		//$sqlRet = "SELECT id, whenwhere, event, emotion, automaticThoughts, rationalResponse, reg_date FROM MyDiary";
		$result = $conn->query($sqlRet);
		

		if ($result->num_rows > 0) {
		    echo "<table><tr><th>Entry Number</th><th>When/Where</th><th>Event</th><th>Emotion</th><th>Automatic Thoughts</th><th>Rational Response</th><th>Date/Time</th></tr>";
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        echo "<tr><td>".$row["id"]."</td><td>".$row["whenwhere"]."</td><td>".$row["event"]."</td><td>".$row["emotion"]."</td><td>".$row["automaticThoughts"]."</td><td>".$row["rationalResponse"]."</td><td>".$row["reg_date"]."</td></tr>";
		    }
		    echo "</table>";
		} else {
		    echo "No diary entries to view";
		}	
		$conn->close();
	}

	//if(isset($_POST['remTable'])){

?>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<input type="submit" name="remTable" value="Collapse table" id="button">
	</form>

	</div>
</body>
</html>

