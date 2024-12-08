<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'HR') {
    header("Location: login_employee.php");
    exit();
}

require_once 'core/dbConfig.php';

$applicant_id = isset($_GET['applicant_id']) ? $_GET['applicant_id'] : null;

if ($applicant_id) {

    $stmt = $pdo->prepare("SELECT u.first_name, u.last_name, j.title, a.resume, a.date_submitted, a.status, a.applicant_id 
                            FROM applications a 
                            JOIN users u ON a.applicant_id = u.id
                            JOIN job_posts j ON a.job_post_id = j.id
                            WHERE a.applicant_id = :applicant_id");
    $stmt->execute(['applicant_id' => $applicant_id]);
    $applicant = $stmt->fetch();
}

if (!$applicant) {
    echo "<p>Applicant not found.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Details</title>
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
    color: #f1c40f;
    text-shadow: 0 0 10px #f39c12, 0 0 20px #f1c40f, 0 0 30px #f39c12;
    text-align: center;
}

.applicant-card .card-subtitle {
    font-size: 1.1rem;
    color: #ecf0f1;
    text-align: center;
}

.applicant-card .card-text {
    margin-bottom: 15px;
    color: black;
}

.badge {
    font-family: 'Press Start 2P', cursive;
    font-size: 1rem;
    padding: 5px 10px;
    border-radius: 5px;
    color: black;
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

.btn-outline-primary {
    border-color: #f39c12;
    color: #f39c12;
}

.btn-outline-primary:hover {
    background-color: #f39c12;
    color: black;
}

.btn:hover {
    box-shadow: 0 0 10px #27ae60;
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
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($applicant['first_name'] . ' ' . $applicant['last_name']); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($applicant['title']); ?></h6>
                
                <p><strong>Status:</strong> 
                    <span class="badge 
                        <?php echo $applicant['status'] == 'Accepted' ? 'bg-success' : ($applicant['status'] == 'Rejected' ? 'bg-danger' : 'bg-warning'); ?>">
                        <?php echo htmlspecialchars($applicant['status']); ?>
                    </span>
                </p>
                
                <p><strong>Submitted on:</strong> <?php echo htmlspecialchars($applicant['date_submitted']); ?></p>

                <p><strong>Resume:</strong> 
                    <?php if ($applicant['resume']): ?>
                        <a href="uploads/<?php echo htmlspecialchars($applicant['resume']); ?>" target="_blank" class="btn btn-outline-primary btn-sm" style="color: black;">View PDF</a>
                    <?php else: ?>
                        <span class="text-muted">No resume submitted</span>
                    <?php endif; ?>
                </p>

                <div class="mt-3">
                    <a href="applications.php?action=accept&applicant_id=<?php echo $applicant['applicant_id']; ?>" class="btn btn-success">Accept</a>
                    <a href="applications.php?action=reject&applicant_id=<?php echo $applicant['applicant_id']; ?>" class="btn btn-danger">Reject</a>
                </div>
                <div class="mt-3">
                    <a href="applications.php" class="btn btn-secondary">Back to Job List</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
