<?php

require_once("./dbinfo.php");
	
//connect to the database
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//check the connection
if(mysqli_connect_errno() != 0) {
	die("aaaargh you're not connected properly");
}

//if a selection is not set produce error message else.....
session_start();

$formIsValid = true;
$validationMessage = "";
	

if(!isset($_POST['studentnumber']) || trim($_POST['studentnumber']) == "") {
		$formIsValid = false;
		$validationMessage .= "<p>Please enter a valid student number </p></ br>";
}

if(!isset($_POST['firstname']) || trim($_POST['firstname']) == "") {
			$formIsValid = false;
			$validationMessage .= "<p>Please enter a valid name </p></ br>";
}

if(!isset($_POST['lastname']) || trim($_POST['lastname']) == "") {
			$formIsValid = false;
			$validationMessage .= "<p>Please enter a valid lastname </p></ br>";			
}

//make sudre the student number is valid
if($formIsValid){
$pattern = "/^a00[0-9]{6}$/i";
	if( preg_match($pattern, trim($_POST['studentnumber'])) != 1){
		$validationMessage .= "An invalid studentnumber.<br />";
		$formIsValid = false;
	}
}

if(!$formIsValid) {
	session_start();
	$_SESSION['error_messages'] = $validationMessage;
	header("location: table.php");
	die();
}

//store the inputed data
if($formIsValid) {

		$studentnumber = strtoupper(trim($_POST['studentnumber']));
		$firstname     = ucfirst(strtolower(trim($_POST['firstname'])));
		$lastname      = ucfirst(strtolower(trim($_POST['lastname'])));
  //put the user data into escaped strings
		$escapedStudentNumber   = $mysqli->real_escape_string($studentnumber);
		$escapedFirstName       = $mysqli->real_escape_string($firstname);
		$escapedLastName        = $mysqli->real_escape_string($lastname);

		$query = "INSERT INTO students (firstname, lastname, id) VALUES ('".$escapedFirstName."','".$escapedLastName."','".$escapedStudentNumber."');";

		$results = $mysqli->query($query);

		if($results == true){
			$validationMessage .= "<p>The new student was added to the database.</p></ br>";	
		}else{
			$validationMessage .= "<p>That student number is already in use.</p></ br>";
	}

}

	session_start();
	$_SESSION['error_messages'] = $validationMessage;
	header("location: table.php");
	die();

	$mysqli->close();

?>