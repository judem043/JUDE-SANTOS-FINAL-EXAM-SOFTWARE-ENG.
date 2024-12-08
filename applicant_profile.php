<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Applicant') {
    header("Location: login_applicant.php");
    exit();
}

require_once 'core/dbConfig.php';

$applicant_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT a.job_post_id, j.title, a.resume, a.status, a.date_submitted FROM applications a 
                        JOIN job_posts j ON a.job_post_id = j.id WHERE a.applicant_id = :applicant_id");
$stmt->bindParam(':applicant_id', $applicant_id);
$stmt->execute();
$applications = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>

        body {
            background-color: #f4f4f9;
            font-family: 'Arial', sans-serif;
        }
        
        .applicant-card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background-color: #fff;
        }
        
        .applicant-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .applicant-card .card-body {
            padding: 20px;
        }

        .applicant-card .card-title {
            font-size: 1.3rem;
            font-weight: bold;
        }

        .applicant-card .card-subtitle {
            font-size: 1.1rem;
            color: #555;
        }

        .applicant-card .card-text {
            margin-bottom: 15px;
        }

        .applicant-card .btn {
            font-size: 0.9rem;
            width: 100%;
            margin-top: 10px;
        }

        .badge {
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
        }

        .header {
            background-color: #007BFF;
            color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 2.5rem;
        }

        .employee-dashboard-btn {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            font-size: 1.2rem;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .employee-dashboard-btn:hover {
            background-color: #218838;
        }

        .applicant-card p {
            font-size: 1rem;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Your Profile</h1>
        <p>Below are the job applications you have submitted.</p>

        <ul class="list-group">
            <?php foreach ($applications as $application): ?>
                <li class="list-group-item">
                    <h5><?php echo htmlspecialchars($application['title']); ?></h5>
                    <p>Status: <?php echo htmlspecialchars($application['status']); ?></p>
                    <p>Submitted on: <?php echo htmlspecialchars($application['date_submitted']); ?></p>
                    <p>Resume: 
                        <?php if ($application['resume']): ?>
                            <a href="uploads/Name johnny yes papa.pdf" target="_blank">View PDF</a>
                        <?php else: ?>
                            No resume submitted
                        <?php endif; ?>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>

        <a href="applicant_dashboard.php" class="btn btn-secondary mt-4">Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
