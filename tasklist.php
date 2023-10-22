<?php
include 'koneksi.php';

if (isset($_POST['new-task-input'])) {
    $taskText = $_POST['new-task-input'];
    $taskStatus = 'Not Yet';
    $id_user = $_POST['user_id'];

    $sql = "INSERT INTO listudu (id_user, task_name, task_status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $id_user, $taskText, $taskStatus);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->error;
    }
}

$conn->close(); 
?>
