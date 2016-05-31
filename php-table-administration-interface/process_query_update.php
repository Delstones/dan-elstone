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
$updateFirstname ="";
$updateLastname ="";
$updateStudentId ="";

$inputedLastname = "";
$inputedFirstname = "";
$inputedStudentnumber = "";

	
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
//if the form is valid continue to final steps
//user inputed data
$inputedStudentnumber = strtoupper(trim($_POST['studentnumber']));
$inputedFirstname = strtolower(trim($_POST['firstname']));
$inputedLastname = strtolower(trim($_POST['lastname']));

$escapedStudentNumber   = $mysqli->real_escape_string($inputedStudentnumber);
$escapedFirstName       = $mysqli->real_escape_string($inputedFirstname);
$escapedLastName        = $mysqli->real_escape_string($inputedLastname);

//grab the sesson from database values.
$updateStudentId = strtoupper($_SESSION['updateStudentId']); 


$query = "UPDATE students SET id='".$escapedStudentNumber."', firstname='".$escapedFirstName."', lastname='".$escapedLastName."' WHERE id='".$updateStudentId."';";

//capturing the results of the query wont be as useful this time...
$results = $mysqli->query($query);

//...instead, determine number of rows affected
$numRowsAffected = $mysqli->affected_rows;

if($numRowsAffected < 1) {
	$validationMessage .= "<p>No updates were made.</br></p>";
}else {
	$validationMessage .= "<p>Update was successful.</br></p>";
}

//store the messages in sessiosn and head out.

	session_start();
	$_SESSION['error_messages'] = $validationMessage;
	header("location: table.php");
	die();

	$mysqli->close();

?>