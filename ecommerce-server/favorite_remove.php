<?php

// include the headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

//include the connection to the database
include("connection.php");

//decalre the input varaibales
$user_id = $_POST["user_id"];
$product_id = $_POST["product_id"];


//select the username from the database to check if exist
$delete_favorite = $mysql -> prepare("DELETE from favorited_products where user_id=$user_id and product_id=$product_id");

if ($delete_favorite=== false) {
    die(json_encode("error: " . $mysql -> error));
};

?>
