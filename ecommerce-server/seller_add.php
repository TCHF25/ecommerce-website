<?php

//Takes in: userName / name / password /description 
//Returns true if success
//otherwise returns username already exist

// include the headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

//include the connection to the database
include("connection.php");

//decalre the input varaibales
$username = $_POST["userName"];
$name = $_POST["name"];
$date_joined = date("d M Y @ " . "H" . ":i");
$password = hash("sha256", $_POST["password"] . $date_joined . "thcaj5445");
$description = $_POST["description"];
$money = 0;

//select the username from the database to check if exist
$check_seller = $mysql -> prepare("SELECT username FROM sellers WHERE username = '$username'");

//execute the select query
$check_seller -> execute();
$array = $check_seller -> get_result();
$response = [];

//put the data in the array
while($info  = $array -> fetch_assoc()){
    $response[] = $info;
};

// check if response have data, if true send an error message
if ($response) {
    die(json_encode("error: username already in use."));
};

//if false prepare the query insert
$query = $mysql -> prepare(
    "INSERT INTO sellers(username, name,password, description, money,date_joined) VALUE (?, ?,'$password', ?, ?, ?)");

if ($query === false) {
    die(json_encode("error: " . $mysql -> error));
};
//execute the query
$query -> bind_param("sssss", $username, $name, $description, $money,$date_joined);
$query -> execute();

// send the resposne with succces message
echo json_encode("success");

?>
