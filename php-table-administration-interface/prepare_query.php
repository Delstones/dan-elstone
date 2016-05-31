
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

 <?php

 $validationMessage = "";

	require_once("./dbinfo.php");
	
	//connect to the database
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	//check the connection
	if(mysqli_connect_errno() != 0) {
		die("aaaargh you're not connected properly");
}

//output the different forms	

	if(isset($_GET['add'])) {
			echo "<h2>Add a Student....</h2>";
			echo '<fieldset>';
			echo '<legend>Add a record</legend>';
			echo '<form method="post" action="process_query_add.php">';
					echo '<input type="hidden" name="add" value="add" />';
					echo '<input type="text" name="studentnumber" id="studentnumber" />';
					echo '<label for="studentnumber"> - Student #</label><br />';
					echo '<input type="text" name="firstname" id="firstname" />';
					echo '<label for="firstname"> - Firstname</label><br />';
					echo '<input type="text" name="lastname" id="lastname" />';
					echo '<label for="lastname"> - Lastname</label><br />';
					echo '<input type="submit" value="Submit" />';
			echo '</form>';
			echo '</fieldset>';	
}
// below if code for confirming a delete of a user.
//show the form and fetch the student to be deleted

if(isset($_GET['delete-id'])) {
		echo '<h2>Delete a student...</h2>';

		session_start();
		$idForDeletion = $_GET['delete-id'];
		$_SESSION['delete'] =	$idForDeletion;
		$query = "SELECT * FROM students WHERE id='$idForDeletion';";
		$result = $mysqli->query( $query );
				while( $record = $result->fetch_assoc()  ){
					//loop through the $record array
					echo "<p>Do you really want to delete: ".ucfirst(strtolower($record['firstname']))." ".ucfirst(strtolower($record['lastname']))."</p>";
		 			echo "<p>ID number: ".$record['id']."</p>";
					}	
		echo '<fieldset>';
		echo '<legend>Delete a record</legend>';
		echo '<form method="post" action="process_query.php">';
				echo '<input 	type="radio" 
							name="confirm" 
							id="yes" 
							value="yes"
							checked="checked" />';
				echo '<label for="yes">Yes</label><br />';
				echo '<input 	type="radio" 
							name="confirm" 
							id="no" 
							value="no" />';
				echo '<label for="no">No</label><br />';	
				echo '<input type="submit" value="Submit" />';
		echo '</form>';
		echo '</fieldset>';
}


$updateFirstname = "";
$updateLastname = "";
$updateStudentId = "";

if(isset($_GET['update-id'])) {

	echo '<h2>Update a student...</h2>	<fieldset>';

	  if( isset($_GET['update-id']) ){
	$id = $mysqli->real_escape_string($_GET['update-id']);
	$query = "SELECT id, firstname, lastname FROM students WHERE id='".$id."';";
	$result = $mysqli->query($query);
	while(   $record = $result->fetch_assoc() ){
		    $updateFirstname = $record['firstname'];
			$updateLastname =  $record['lastname'];
			$updateStudentId = $record['id'];
		}	
	}
	session_start();
	  $_SESSION['updateStudentId'] = $updateStudentId; 

				echo '<legend>Update a record</legend>';
				echo '<form method="post" action="process_query_update.php">';
				echo '<fieldset>';
							echo '<legend>New data</legend>';
								echo '<input 	type="text" 
										name="studentnumber" 
										id="studentnumber"
										value= " '.$updateStudentId.' "/>';

								echo '<label 	for="studentnumber"> - Student #</label><br />';
								echo '<input 	type="text" 
										name="firstname" 
										id="firstname"
										value=" '.$updateFirstname.' " />';
								echo '<label for="firstname"> - Firstname</label><br />';
								echo '<input 	type="text" 
										name="lastname" 
										id="lastname"
										value=" '.$updateLastname.' " />';
								echo '<label for="lastname"> - Lastname</label><br />';
				echo '</fieldset>';
				echo '<input type="submit" value="Submit" />';
			echo '</form>';
			echo '</fieldset>';
}

$mysqli->close();
?>

	</body>
</html>