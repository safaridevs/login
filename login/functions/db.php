<?php 
$conn = mysqli_connect("localhost","root", "seguton", "login");	

//escape the string. Avoid code injection
function escape($string){
	global $conn;
	
	return mysqli_real_escape_string($conn, $string);
}
//This function queries any select statement
function query($query){
	global $conn;	
	return mysqli_query($conn, $query);
}
function confirm($result){
	global $conn;	
	if(!$result){
		echo die("QUERY FAILED". mysqli_error($conn));
	}
}

function fetch_array($result){
	return mysqli_fetch_array($result);
}

function row_count($results){	
	return mysqli_num_rows($results);
}

function redirect($location){
	return header("Location: {$location}");
}


?>