<?php
require_once("utilities.php");

if (!isset($_GET['id']) || !intval($_GET['id'])) {
  exit("You must submit an integer task id to delete");
}

$taskId = intval($_GET['id']);

$deleteQuery = mysqli_query(
  $conn,
  "DELETE FROM tasks WHERE task_id = $taskId"
);

if (!$deleteQuery) {
  exit("There was an error when deleting your task");
}

// Check images directory with taskId and delete image if present
$imagesDir = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
$image = $taskId . ".jpg";
$imagePath = $imagesDir . $image;

echo $imagePath;

if (file_exists($imagePath)) {
  unlink($imagePath);
}

header('Location: /crud/');
exit;