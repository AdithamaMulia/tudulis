<?php
    session_start();
    include 'koneksi.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $login_sql = "SELECT id_user, username, password FROM userdata WHERE username = ?";
        $stmt = $conn->prepare($login_sql);

        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($user_id, $db_username, $db_password);
                $stmt->fetch();

                if (password_verify($password, $db_password)) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $db_username;
                    header("Location: index.php");
                } else {
                    echo "Invalid password or username.";
                }
            } else {
                echo "Invalid password or username.";
            }

            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - tudulis</title>
    <link rel="stylesheet" type="text/css" href="loginstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="path-to-sweetalert/sweetalert2.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background-color: #1a202c;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        h2 {
            margin: 0;
        }
        .rounded-buttons {
            background-color: #374151;
            color: black;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            cursor: pointer;
            width: 100%;
            max-width: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            font-family: 'Tenor Sans', sans-serif;
        }
    </style>
</head>
<body style="background-color: #374151;">
    <div class="card custom-card">
        <h2 style="color:white;">Login</h2>
        <br />
        <form id="login-form" action="login.php" method="post">
            <label for="username" style="color:white;">Username:</label>
            <input type="text" name="username" required><br><br>

            <label for="password" style="color:white;">Password:</label>
            <input type="password" name= "password" required><br><br>
            <br />

            <input type="submit" style="color:white;" value="Log In" class="login rounded-buttons">
        </form>
        <br />
        <a href="signup.php" style="color:blue;">Don't have an account? Click to Sign Up Now!</a>
    </div>
</body>
</html>