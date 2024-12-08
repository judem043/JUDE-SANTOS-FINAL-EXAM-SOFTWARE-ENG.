<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'HR') {
    header("Location: login_employee.php");
    exit();
}

require_once 'core/dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_job'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];


    $stmt = $pdo->prepare("INSERT INTO job_posts (title, description) VALUES (?, ?)");
    $stmt->execute([$title, $description]);

    header("Location: employee_dashboard.php");
    exit();
}

if (isset($_GET['delete_job_id'])) {
    $job_id = $_GET['delete_job_id'];

    $stmt = $pdo->prepare("DELETE FROM job_posts WHERE id = ?");
    $stmt->execute([$job_id]);

    header("Location: employee_dashboard.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM job_posts");
$stmt->execute();
$job_posts = $stmt->fetchAll();

echo "<h1>Welcome, {$_SESSION['username']}!</h1>";
echo "<p>You have successfully logged into the Employee Dashboard.</p>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body {
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 0;
            background: url('https://i.pinimg.com/originals/7d/8a/ae/7d8aaece38d063c45f116aac5de55e1c.jpg') no-repeat center center fixed;
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

    </style>
</head>
<body>
    <div class="mt-4 text-center">
        <a href="index.php" class="btn btn-success">Home</a>
        <a href="applications.php" class="btn btn-primary">Applications</a>
        <a href="co_workers.php" class="btn btn-secondary">Co-workers</a>
    </div>

    <div class="container">

        <h3 class="mt-4">Post a New Job</h3>
        <form action="employee_dashboard.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Job Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Job Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="post_job">Post Job</button>
        </form>

        <h3 class="mt-4">Posted Jobs</h3>
        <ul class="list-group">
            <?php foreach ($job_posts as $job): ?>
                <li class="list-group-item">
                    <h5><?php echo htmlspecialchars($job['title']); ?></h5>
                    <p><?php echo htmlspecialchars($job['description']); ?></p>
                    <a href="edit_job.php?job_id=<?php echo $job['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="employee_dashboard.php?delete_job_id=<?php echo $job['id']; ?>" class="btn btn-danger">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
