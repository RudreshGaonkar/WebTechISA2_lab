<?php
include 'dbConfig.php';

if (isset($_GET['id'])) {
    $taskId = intval($_GET['id']);

    $sql = "SELECT status FROM tasks WHERE id = $taskId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $newStatus = ($row['status'] == 'pending') ? 'completed' : 'pending';

        $sqlUpdate = "UPDATE tasks SET status = '$newStatus' WHERE id = $taskId";

        if ($conn->query($sqlUpdate) === TRUE) {
            
            header("Location: viewTasks.php");
            exit();
        } else {
            echo "Error updating status: " . $conn->error;
        }
    } else {
        echo "Task not found.";
    }
} else {
    echo "No task ID provided.";
}
?>
