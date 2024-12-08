<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Applicant') {
    header("Location: login_applicant.php");
    exit();
}


require_once 'core/dbConfig.php';

$stmt = $pdo->prepare("
    SELECT a.id AS application_id, j.title AS job_title, a.resume, a.status, a.date_submitted 
    FROM applications a
    INNER JOIN job_posts j ON a.job_post_id = j.id
    WHERE a.applicant_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
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
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body {
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 0;
            background: url('https://www.desktophut.com/images/thumb_1686482427_564928.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
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

        .btn-secondary {
            font-family: 'Press Start 2P', cursive;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            text-shadow: 0 0 10px #2980b9;
            transition: 0.3s ease-in-out;
        }

        .btn-secondary:hover {
            background-color: #2980b9;
            box-shadow: 0 0 10px #3498db, 0 0 20px #2980b9;
        }

        table {
            background-color: #34495e;
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            border: 2px solid #2ecc71;
            box-shadow: 0 0 15px #27ae60;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #2ecc71;
        }

        th {
            background-color: #2c3e50;
            color: #2ecc71;
        }

        tr:nth-child(even) {
            background-color: #2c3e50;
        }

        tr:hover {
            background-color: #27ae60;
            color: white;
        }

        a {
            color: #f1c40f;
            text-shadow: 0 0 10px #f39c12, 0 0 20px #f1c40f, 0 0 30px #f1c40f;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Profile</h1>
        <a href="applicant_dashboard.php" class="btn btn-secondary my-3">Back to Dashboard</a>

        <?php if (count($applications) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Resume</th>
                        <th>Status</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $application): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($application['job_title']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($application['resume']); ?>" target="_blank">View Resume</a></td>
                            <td><?php echo htmlspecialchars($application['status']); ?></td>
                            <td><?php echo htmlspecialchars($application['date_submitted']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have not applied for any jobs yet.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
