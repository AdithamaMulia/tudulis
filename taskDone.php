<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['taskId'])) {
    $task_id = $_POST['taskId'];

    $sql = "UPDATE listudu SET task_status = 'Done' WHERE id_task = $task_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("Location: index.php");
}
?>