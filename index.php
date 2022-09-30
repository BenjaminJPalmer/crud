<?php
require_once("utilities.php");

$allTasksQuery = mysqli_query($conn, "SELECT * FROM tasks");
$rowCount = mysqli_num_rows($allTasksQuery);
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>TCG - TODO List</title>
</head>

<body>
	<h1>My TODO List</h1>
	<p>There are <?= $rowCount; ?> items in my list</p>
	<ol>
		<?php while ($rowData = mysqli_fetch_array($allTasksQuery)) { ?>
			<li>
				<strong><?php echo $rowData['title']; ?></strong>
				<a href="delete_task.php?id=<?= $rowData['task_id'] ?>">delete</a>
				<p><?php echo $rowData['description']; ?></p>
				<?php
				$imagePath = "/images/{$rowData['task_id']}.jpg";
				if (file_exists(__DIR__ . $imagePath)) {
				?>
					<img src="/crud<?= $imagePath ?>" alt="Image for <?= $rowData['title'] ?>" height="400" width="300"/>
				<?php } ?>
			</li>
		<?php } ?>
	</ol>

	<form action='add_task.php' method='post' enctype="multipart/form-data">
		<fieldset>
			<label for='title'>Title</label>
			<input type='text' name='title' id='title' />
			<br />
			<label for='description'>Description</label>
			<textarea name='description' id='description'></textarea>
			<br />
			<label for="image">Image</label>
			<input type="file" name="image" id="image" accept="image/jpeg">
			<br />
			<button type="submit">Add Task</button>
		</fieldset>
	</form>

</html>