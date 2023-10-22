<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id']) && isset($_POST['new_status'])) {
    $taskStatus = $_POST['new_status'];
    $taskId = $_POST['task_id'];

    $stmt = $conn->prepare("UPDATE listudu SET task_status = ? WHERE id_task = ?");
    $stmt->bind_param("si", $taskStatus, $taskId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    echo 'sucess';
    // header("Location: index.php");
} else {
    header("Location: index.php");
}
?>
