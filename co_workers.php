<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'HR') {
    header("Location: login_employee.php");
    exit();
}

require_once 'core/dbConfig.php';

$stmt = $pdo->prepare("SELECT id, first_name, last_name, username, role FROM users WHERE role = 'HR'");
$stmt->execute();
$employees = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Co-workers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body {
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 0;
            background: url('https://wallpapers.com/images/hd/cool-minecraft-background-alromqj7ibx90pm9.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .container {
            background: rgba(0, 0, 0, 0.8);
            border: 3px solid #2ecc71;
            box-shadow: 0 0 15px #27ae60, inset 0 0 15px #2ecc71;
            border-radius: 10px;
            padding: 40px;
            margin-top: 50px;
        }

        h1 {
            color: #2ecc71;
            text-shadow: 0 0 10px #27ae60, 0 0 20px #2ecc71, 0 0 30px #1abc9c;
            text-align: center;
        }

        h3 {
            color: #2ecc71;
            text-shadow: 0 0 10px #27ae60, 0 0 20px #2ecc71, 0 0 30px #1abc9c;
        }

        .welcome-text {
            color: yellow;
            text-shadow: 0 0 10px #f1c40f, 0 0 20px #f1c40f, 0 0 30px #f39c12;
            font-size: 24px;
            text-align: center;
            margin-top: 20px;
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

        .btn-success {
            background-color: #27ae60;
        }

        .btn-primary {
            background-color: #e74c3c;
        }

        .btn-secondary {
            background-color: #f39c12;
        }

        .btn-warning {
            background-color: #f39c12;
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .btn:hover {
            box-shadow: 0 0 10px #27ae60;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: 0 0 5px #27ae60;
            margin-bottom: 15px;
        }

        .alert {
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            border: 2px solid #ff0000;
            text-shadow: 0 0 10px #ff6347;
        }

        .list-group-item {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border: 1px solid #2ecc71;
            box-shadow: 0 0 10px #27ae60;
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5rem;
        }

        .badge.bg-success {
            background-color: #27ae60;
        }

        .badge.bg-secondary {
            background-color: #f39c12;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-text">
            Co-Workers:
        </div>
        <p>Below is a list of all employees.</p>


        <ul class="list-group">
            <?php foreach ($employees as $employee): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?>
                    <?php if ($employee['id'] == $_SESSION['user_id']): ?>

                        <span class="badge bg-success">Online</span>
                    <?php else: ?>

                        <span class="badge bg-secondary">Offline</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <a href="employee_dashboard.php" class="btn btn-secondary mt-4">Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

