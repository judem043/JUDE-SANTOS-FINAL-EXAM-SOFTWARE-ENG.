<?php
session_start();

require_once 'core/dbConfig.php';


if (isset($_GET['action']) && isset($_GET['applicant_id'])) {
    $applicant_id = $_GET['applicant_id'];
    $action = $_GET['action'];

    $stmt = $pdo->prepare("SELECT status FROM applications WHERE applicant_id = :applicant_id");
    $stmt->execute(['applicant_id' => $applicant_id]);
    $applicant = $stmt->fetch();

    if ($applicant && ($applicant['status'] == 'Pending')) {
        $new_status = $action == 'accept' ? 'Accepted' : 'Rejected';
        $updateStmt = $pdo->prepare("UPDATE applications SET status = :status WHERE applicant_id = :applicant_id");
        $updateStmt->execute(['status' => $new_status, 'applicant_id' => $applicant_id]);
    }
}

$stmt = $pdo->prepare("SELECT * FROM applications WHERE status = 'Pending'"); 
$stmt->execute();
$applicants = $stmt->fetchAll();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'HR') {
    header("Location: login_employee.php");
    exit();
}

require_once 'core/dbConfig.php';

if (isset($_GET['action']) && isset($_GET['applicant_id'])) {
    $action = $_GET['action'];
    $applicant_id = $_GET['applicant_id'];
    $status = $action == 'accept' ? 'Accepted' : 'Rejected';

    $stmt = $pdo->prepare("UPDATE applications SET status = :status WHERE applicant_id = :applicant_id");
    $stmt->execute(['status' => $status, 'applicant_id' => $applicant_id]);

    header("Location: applications.php");
    exit();
}

$stmt = $pdo->prepare("SELECT u.first_name, u.last_name, j.title, a.resume, a.date_submitted, a.status, a.applicant_id 
                        FROM applications a 
                        JOIN users u ON a.applicant_id = u.id
                        JOIN job_posts j ON a.job_post_id = j.id");
$stmt->execute();
$applicants = $stmt->fetchAll();

echo "<h1 class='text-center my-4'>Applicants List</h1>";
echo "<h5 class='text-center mb-4'>Below is a list of applicants and their job applications.</h5>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body {
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 0;
            background: url('https://img2.wallspic.com/crops/8/8/1/6/6/166188/166188-minecraft_dungeons_creeping_winter-1920x1080.jpg') no-repeat center center fixed;
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
            color: black;
        }

        .badge {
            font-weight: bold;
            color: black;
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

        .btn-secondary {
            background-color: #f39c12;
        }

        .btn:hover {
            box-shadow: 0 0 10px #27ae60;
        }

        .badge.bg-success {
            background-color: #27ae60;
        }

        .badge.bg-danger {
            background-color: #e74c3c;
        }

        .badge.bg-warning {
            background-color: #f39c12;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: 0 0 5px #27ae60;
            margin-bottom: 15px;
        }
        h5 {
            color: #f1c40f;
            text-shadow: 0 0 10px #f39c12, 0 0 20px #f1c40f, 0 0 30px #f39c12; 
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container my-5">

        <div class="mt-3 mb-4">
            <a href="employee_dashboard.php" class="btn btn-secondary">Back to Job List</a>
        </div>

        <div class="row">
            <?php foreach ($applicants as $applicant): ?>
                <div class="col-md-4 mb-4">
                    <div class="card applicant-card border-primary">
                        <div class="card-body">

                            <h5 class="card-title"><?php echo htmlspecialchars($applicant['first_name'] . ' ' . $applicant['last_name']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($applicant['title']); ?></h6>
                            
                            <p class="card-text">
                                <strong>Status:</strong>
                                <span class="badge 
                                    <?php echo $applicant['status'] == 'Accepted' ? 'bg-success' : ($applicant['status'] == 'Rejected' ? 'bg-danger' : 'bg-warning'); ?>">
                                    <?php echo htmlspecialchars($applicant['status']); ?>
                                </span>
                            </p>
                            
                            <p class="card-text"><strong>Submitted on:</strong> <?php echo htmlspecialchars($applicant['date_submitted']); ?></p>

                            <a href="accept.php?applicant_id=<?php echo $applicant['applicant_id']; ?>" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb6htJY2W5jmRBVYxrb5S5lGz8l9doCpFmDYj6l5rM7n7IW6gD" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0bP9l5cVZf3FXp6ayr5uyR1FhDPf9j0H7/sffGvREe3X9T9k" crossorigin="anonymous"></script>
</body>
</html>
