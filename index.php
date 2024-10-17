<?php

include 'dbConfig.php';


$title = $description = $due_date_time = "";
$errors = [];


if (isset($_POST['submit'])) {
    
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
        $sql = "INSERT INTO tasks (title, description, due_date_time) VALUES ('$title', '$description', '$due_date_time')";
        if ($conn->query($sql) === TRUE) {
            $success_message = "New task added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
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
    <title>Task</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<div class="container">
    <h2>Task Manager</h2>

    
    <?php
    if (!empty($errors)) {
        echo '<div class="error">';
        for ($i = 0; $i < count($errors); $i++) {
            echo '<li>' . $errors[$i] . '</li>';
        }
        echo '</div>';
    }
    ?>

    
    <?php
    if (isset($success_message)) {
        echo '<div class="success">' . $success_message . '</div>';
    }
    ?>

    
    <form action="" method="POST">
        <label for="title">Task Title</label>
        <input type="text" name="title" id="title" value="<?php echo $title; ?>">

        <label for="description">Task Description</label>
        <textarea name="description" id="description" rows="4"><?php echo $description; ?></textarea>

        <label for="due_date_time">Due Date & Time</label>
        <input type="datetime-local" name="due_date_time" id="due_date_time" value="<?php echo $due_date_time; ?>">

        <input type="submit" name="submit" value="Add Task">
    </form>
    <div class="view-tasks">
        <a href="viewTasks.php" class="view-button">View Tasks</a>
    </div>
</div>

</body>
</html>
