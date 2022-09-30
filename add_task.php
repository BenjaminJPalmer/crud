<?php
require_once("utilities.php");

// Validate input contents
if (
  !isset($_POST["title"]) ||
  !isset($_POST["description"]) ||
  !isset($_FILES["image"]) ||
  empty($_FILES["image"]["tmp_name"])
) {
  exit("You must submit a title, a description and an image");
}

if (strlen($_POST["title"]) < 5 || strlen($_POST["description"]) < 5) {
  exit('Title and description must be at least 5 characters');
}

// Sanitise text inputs
$title = htmlspecialchars($_POST["title"]);
$description = htmlspecialchars($_POST["description"]);

// Check the mime type
$finfo = new finfo(FILEINFO_MIME_TYPE);
$uploadedFile = $_FILES['image']['tmp_name'];
$fileMimeType = $finfo->file($uploadedFile);

$isAcceptedMimeType = in_array($fileMimeType, ['image/jpeg']);

if ($isAcceptedMimeType === false) {
  exit('You must upload an image in jpg format');
}

//Create the images directory if it doesn't already exist
$imagesDir = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;

if (!file_exists($imagesDir) && !mkdir($imagesDir, 0777, true)) {
  exit('Failed to create image directory');
}

if (!is_writable($imagesDir)) {
  exit('Cannot write to image directory');
}

// Insert inputs into database
$insertQuery = mysqli_query($conn, "INSERT INTO tasks (title, description) VALUES ('$title', '$description')");

if (!$insertQuery) {
  exit('There was an error when inserting your task');
}

$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
$taskId = mysqli_insert_id($conn);
$filepath = $imagesDir . $taskId . '.' . $ext;

// Move the file to the images directory
$success = move_uploaded_file($uploadedFile, $filepath);

if (!$success) {
  exit("Error moving image - task $taskId - file $uploadedFile");
}

header('Location: /crud/');
exit;
