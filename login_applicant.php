<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once 'core/dbConfig.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = 'Applicant'");
    $stmt->execute([$username]);
    $user = $stmt->fetch();


    if ($user && password_verify($password, $user['password'])) {
        session_start(); 
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = 'Applicant'; 
        header("Location: applicant_dashboard.php");
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
    <title>Applicant Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body {
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 0;
            background: url('https://png.pngtree.com/background/20230528/original/pngtree-landscape-minecraft-picture-image_2773439.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .container {
            background: rgba(0, 0, 0, 0.8);
            border: 3px solid #2ecc71;
            box-shadow: 0 0 15px #27ae60, inset 0 0 15px #2ecc71;
            border-radius: 10px;
            padding: 40px;
            margin-top: 100px;
        }

        h1 {
            color: #2ecc71;
            text-shadow: 0 0 10px #27ae60, 0 0 20px #2ecc71, 0 0 30px #1abc9c;
        }

        .alert {
            background-color: #e74c3c;
            color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px #e74c3c;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: 0 0 5px #27ae60;
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #e74c3c;
            border: none;
            font-family: 'Press Start 2P', cursive;
            text-shadow: 0 0 10px #34495e;
            box-shadow: 0 0 10px #e74c3c;
        }

        .btn-primary:hover {
            background-color: #c0392b;
            box-shadow: 0 0 20px #e74c3c;
        }

        .btn-secondary {
            background-color: #f39c12;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #d68910;
        }

        .mt-3 p {
            color: #f1c40f;
            text-shadow: 0 0 10px #f39c12, 0 0 20px #f1c40f, 0 0 30px #f1c40f;
        }

        footer {
            background: rgba(0, 0, 0, 0.8);
            color: #2ecc71;
            text-shadow: 0 0 10px #27ae60, 0 0 20px #2ecc71;
            border-top: 3px solid #27ae60;
            padding: 20px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="my-5 text-center">Applicant Login</h1>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="mt-3 text-center">
            <p>Don't have an account? <a href="register_applicant.php" class="btn btn-secondary btn-lg px-4">Register here</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
