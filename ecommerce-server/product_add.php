<?php

// NEEDS TESTING

// NEEDS TESTING

// NEEDS TESTING

// Takes in: userName / name / category / description / price / photo
// Returns true on success. otherwise logs the error

include("connection.php");
include("image_handler.php");

// Init Variables

$sellerUserName = $_POST["userName"];
$name = $_POST["name"];
$category = $_POST["category"];
$description = $_POST["description"];
$price = $_POST["price"];
$photo = $_POST["photo"];
$orders = 0;
$times_favorited = 0;
$discount = 0;
$visited = 0;

// Functions

function addProduct($id, $name, $cat, $desc, $price, $ord, $fav, $disc, $visit, $mysql) {
    $query = $mysql -> prepare(
        "INSERT INTO products(seller_id, `name`, category, `description`,
        price, orders, times_favorited, discount, visited)
        VALUE ('$id', ?, ?, ?, ?, '$ord', '$fav', '$disc', '$visit')");

    if ($query === false) {
        die(json_encode("error: " . $mysql -> error));
    };

    $query -> bind_param("ssss", $name, $cat, $desc, $price);
    $query -> execute();

    $check = $mysql -> prepare(
        "SELECT LAST_INSERT_ID() AS id");
    
    $check -> execute();
    $array = $check -> get_result();

    $response = [];
    $response[] = $array -> fetch_assoc();

    return $response[0]["id"];
};

function getSellerId($user, $mysql) {
    $query = $mysql -> prepare(
        "SELECT id FROM sellers
        WHERE username = '$user'");

    $query -> execute();
    $array = $query -> get_result();

    $response = [];
    $response[] = $array -> fetch_assoc();

    return $response[0]["id"];
};

// Main

if (isset($photo)) {
    $decodedImage = imageDecode($photo);
    imageSave($decodedImage, $id, "product", $mysql);
};

$sellerId = getSellerId($sellerUserName, $mysql);

echo json_encode(addProduct($sellerId, $name, $category, $description,
$price, $orders, $times_favorited, $discount, $visited, $mysql));

?>
