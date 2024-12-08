<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'HR') {
    header("Location: login_employee.php");
    exit();
}

require_once 'core/dbConfig.php';

if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];


    $stmt = $pdo->prepare("SELECT * FROM job_posts WHERE id = ?");
    $stmt->execute([$job_id]);
    $job = $stmt->fetch();

    if (!$job) {

        echo "Job not found!";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_job'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];


    $stmt = $pdo->prepare("UPDATE job_posts SET title = ?, description = ? WHERE id = ?");
    $stmt->execute([$title, $description, $job_id]);


    header("Location: employee_dashboard.php");
    exit();
}

echo "<h1>Edit Job: {$job['title']}</h1>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body {
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 0;
            background: url('https://i.pinimg.com/originals/7d/8a/ae/7d8aaece38d063c45f116aac5de55e1c.jpg') no-repeat center center fixed;
            background-size: cover;
            color: black;
        }

        .container {
            max-width: 1200px;
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

        .form-label {
            font-size: 1.1rem;
            color: #fff;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: 0 0 5px #27ae60;
            margin-bottom: 15px;
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

        .btn-outline-primary {
            color: #e74c3c;
            border-color: #e74c3c;
        }

        .btn-outline-primary:hover {
            background-color: #e74c3c;
            color: white;
        }

        .btn-secondary {
            background-color: #f39c12;
        }

        .btn-secondary:hover {
            background-color: #e67e22;
        }

        .btn-success {
            background-color: #27ae60;
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .btn:hover {
            box-shadow: 0 0 10px #27ae60;
        }
    </style>
</head>
<body>

    <div class="container my-5">
        <h1>Edit Job</h1>
        <form action="edit_job.php?job_id=<?php echo $job['id']; ?>" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Job Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($job['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Job Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($job['description']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="update_job">Update Job</button>
        </form>
    </div>

</body>
</html>
