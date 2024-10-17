<?php
include 'dbConfig.php';

$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="task.svg">
    <title>View Tasks</title>
    <link rel="stylesheet" href="styles.css"> 
    <link rel="stylesheet" href="viewTasks.css"> 
    
</head>
<body>

<div class="container container2">
    <h2>Tasks List</h2>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Due Date & Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $lineThrough = ($row['status'] == 'completed') ? 'line-through' : '';
                    $statusButtonText = ($row['status'] == 'completed') ? 'Mark as Pending' : 'Mark as Completed';
                    
                    echo "<tr style='text-decoration: $lineThrough;'>
                            <td>" . htmlspecialchars($row['title']) . "</td>
                            <td>" . htmlspecialchars($row['description']) . "</td>
                            <td>" . htmlspecialchars($row['due_date_time']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td>
                            <td>
                                <a href='completed.php?id=" . $row['id'] . "' class='action-button'>" . $statusButtonText . "</a> |
                                <a href='editTask.php?id=" . $row['id'] . "' class='action-button'>Edit</a> | 
                                <a href='deleteTask.php?id=" . $row['id'] . "' class='action-button'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No tasks found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="index.php" class="view-button">Add New Task</a>
</div>

</body>
</html>
