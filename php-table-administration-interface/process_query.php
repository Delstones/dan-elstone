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

//store the variables
$validationMessage = "";
$idToDelete     = $_SESSION['delete'];
$deleteThisUser = "DELETE FROM students WHERE id='".$idToDelete."';";
$checkboxes = $_POST['confirm'];
$formIsValid = true;


if(!isset($_SESSION['delete'])) {
		$validationMessage .= "<p>There was no student selected</p> </br>";
		$formIsValid = false;
} 

if(isset($_POST['confirm']) ){

	if($checkboxes == 'yes') {
		$results = $mysqli->query($deleteThisUser);
		$validationMessage .= "<p>The student has been deleted</p></br>";
		$formIsValid = false;
		
	}else {
		$validationMessage .= "<p>Deletion cancelled<p></br>";
		$formIsValid = false;
	}

}

//all the forms route back to table so I declared them all to false.

if(!$formIsValid) {
session_start();
$_SESSION['error_messages'] = $validationMessage;
header("location: table.php");
die();

}

$mysqli->close();


?>