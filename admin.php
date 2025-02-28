<?php
session_start();

include('db_connect.php');

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id, $db_password);
        $stmt->fetch();

        if ($input_password === $db_password) {
            $_SESSION['admin_id'] = $admin_id;
            header("Location: ./dairy_qr/adminaccess.php");
            exit();
        } else {
            $error_message = "Invalid username or password!";
        }
    } else {
        $error_message = "Invalid username or password!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="icon" type="image/jpeg" href="icon.jpeg">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #4CAF50, #2196F3);
            color: white;
            animation: bg-animation 5s infinite alternate;
        }
        @keyframes bg-animation {
            0% { background: linear-gradient(135deg, #4CAF50, #2196F3); }
            100% { background: linear-gradient(135deg, #2196F3, #4CAF50); }
        }
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 350px;
            transition: 0.3s;
        }
        .login-container:hover {
            transform: scale(1.02);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: 0.3s ease;
        }
        input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
        }
        button {
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        button:hover {
            background: #218838;
            transform: scale(1.05);
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(255, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
