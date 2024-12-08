<?php
require_once 'core/dbConfig.php';

session_start();
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = 'HR'");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password === 'HR') {
 
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
        header("Location: employee_dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body {
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 0;
            background: url('https://www.desktophut.com/images/thumb_1686482427_564928.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        h1 {
            text-align: center;
            color: #2ecc71;
            text-shadow: 0 0 10px #27ae60, 0 0 20px #2ecc71, 0 0 30px #1abc9c;
            margin-bottom: 20px;
        }

        .container {
            margin-top: 50px;
            background: rgba(0, 0, 0, 0.8);
            border: 3px solid #27ae60;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 15px #27ae60, inset 0 0 15px #2ecc71;
        }

        .btn {
            font-family: 'Press Start 2P', cursive;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: white;
            text-shadow: 0 0 10px #34495e;
            transition: 0.3s ease-in-out;
        }

        .btn-primary {
            background-color: #e74c3c;
        }

        .btn-primary:hover {
            background-color: #c0392b;
            box-shadow: 0 0 10px #e74c3c, 0 0 20px #c0392b;
        }

        .alert {
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            border: 2px solid #ff0000;
            text-shadow: 0 0 10px #ff6347;
        }

        label {
            color: #2ecc71;
            text-shadow: 0 0 10px #27ae60, 0 0 20px #2ecc71;
        }

        

    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-5 text-center">Employee Login</h1>
        
        <?php if (!empty($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
