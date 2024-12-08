<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once 'core/dbConfig.php';


    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("INSERT INTO users (username, password, first_name, last_name, email, role) 
                           VALUES (?, ?, ?, ?, ?, 'Applicant')");
    $stmt->execute([$username, $password, $first_name, $last_name, $email]);


    header("Location: login_applicant.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body {
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 0;
            background: url('https://wallpapers.com/images/hd/characters-on-mountain-minecraft-hd-55sg7jzx74u7ya8g.jpg') no-repeat center center fixed;
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


    </style>
</head>
<body>

    <div class="container">
        <h1 class="my-5 text-center">Applicant Registration</h1>

        <form method="POST">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
