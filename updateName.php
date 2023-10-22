<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id']) && isset($_POST['new_name'])) {
    $taskName = $_POST['new_name'];
    $taskId = $_POST['task_id'];

    $stmt = $conn->prepare("UPDATE listudu SET task_name = ? WHERE id_task = ?");
    $stmt->bind_param("si", $taskName, $taskId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'Error: ' . $stmt->error;
    }
    // header("Location: index.php");
} else {
    header("Location: index.php");
}
?>
