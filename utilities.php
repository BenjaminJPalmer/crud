<?php
$dbUser = "user";
$dbPass = "password123";
$dbHost = "localhost";
$dbName = "tcg_crud";

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}