
<!DOCTYPE html>
<html>
	<head>
		<title></title>
	<link 	type="text/css" 
			rel="stylesheet" 
			href="styles/style.css" />
	</head>
	<body>
		<h1>Administering DB From a Form</h1>
	
	<div id = "table-wrapper">
	<h2>Students:</h2>

	<?php

	require_once("./dbinfo.php");
	
	//connect to the database
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	//check the connection
	if(mysqli_connect_errno() != 0) {
		die("aaaargh you're not connected properly");
}

	//error messages
	session_start();


	if(isset($_SESSION['error_messages'])) {
		$validationMessages = $_SESSION['error_messages'];
		echo $validationMessages;
		unset($_SESSION['error_messages']);
}

	//get the query and the result
	$query 	= "SELECT * FROM students;";
	$result = $mysqli->query( $query );

	// add a student
	echo "<a href ='prepare_query.php?add'>Add a Student</a>";

	echo "<table>";
	while( $record = $result->fetch_assoc()  ){
	//loop through the $record array
	echo "<tr>";
	echo "<td>" . $record['primary_key'] . "</td>";
	echo "<td>" . $record['id'] . "</td>";
	echo "<td>" . ucfirst(strtolower($record['firstname'])) . "</td>";
	echo "<td>" . ucfirst(strtolower($record['lastname'])) . "</td>";
	echo "<td><a href='prepare_query.php?delete-id=".$record["id"]."'>Delete</a></td>";
	echo "<td><a href='prepare_query.php?update-id=".$record["id"]."'>Update</a></td>";
	echo "</tr>";	
}
	echo "</table>";
	echo	"</div>";


$mysqli->close();

?>

	</body>
</html>