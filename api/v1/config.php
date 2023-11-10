<?php

$servername = "localhost:3306";
$username = "root";
$password = "abcd1234";
$dbname = "loja";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    die("". $e->getMessage());
}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>