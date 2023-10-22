<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'koneksi.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashpass = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO userdata (username, password) 
            VALUES (?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $username, $hashpass);

        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: login.php");
        } else {
            echo "Error: " . $stmt->error;
            header("Location: signup.php");
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
        header("Location: signup.php");
    }

    $conn->close();
}
?>