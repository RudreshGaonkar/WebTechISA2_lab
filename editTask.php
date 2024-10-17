<?php
include 'dbConfig.php';

$title = $description = $due_date_time = $status = "";
$errors = [];


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

   
    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $description = $row['description'];
        $due_date_time = $row['due_date_time'];
        $status = $row['status'];
    } else {
        die("Task not found.");
    }
}


if (isset($_POST['update'])) {

    if (empty($_POST['title'])) {
        $errors[] = "Title is required";
    } else {
        $title = htmlspecialchars($_POST['title']);
    }

    if (empty($_POST['description'])) {
        $errors[] = "Description is required";
    } else {
        $description = htmlspecialchars($_POST['description']);
    }

    if (empty($_POST['due_date_time'])) {
        $errors[] = "Due date and time are required";
    } else {
        $due_date_time = $_POST['due_date_time'];
    }

    
    if (empty($errors)) {
        $sql = "UPDATE tasks SET title='$title', description='$description', due_date_time='$due_date_time' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            header("Location: viewTasks.php"); 
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="task.svg">
    <title>Edit Task</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<div class="container">
    <h2>Edit Task</h2>

   
    <?php
    if (!empty($errors)) {
        echo '<div class="error">';
        for ($i = 0; $i < count($errors); $i++) {
            echo '<li>' . $errors[$i] . '</li>';
        }
        echo '</div>';
    }
    ?>

    <form action="" method="POST">
        <label for="title">Task Title</label>
        <input type="text" name="title" id="title" value="<?php echo $title; ?>">

        <label for="description">Task Description</label>
        <textarea name="description" id="description" rows="4"><?php echo $description; ?></textarea>

        <label for="due_date_time">Due Date & Time</label>
        <input type="datetime-local" name="due_date_time" id="due_date_time" value="<?php echo $due_date_time; ?>">

        <input type="submit" name="update" value="Update Task">
    </form>
    <a href="viewTasks.php" class="view-button"><b>Back to view Tasks</b></a>
</div>

</body>
</html>
