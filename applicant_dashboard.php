<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Applicant') {
    header("Location: login_applicant.php"); 
    exit();
}

require_once 'core/dbConfig.php';

$stmt = $pdo->prepare("SELECT * FROM job_posts");
$stmt->execute();
$job_posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body {
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 0;
            background: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/0c0be316-9a49-488b-a869-1449ee6ea7f5/d6pdq8v-615bce4b-5acc-4bb6-923f-91bf942f3123.jpg/v1/fill/w_1024,h_647,q_75,strp/minecraft_wallpapers_hd_by_gamer_otaku_musica_d6pdq8v-fullview.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9NjQ3IiwicGF0aCI6IlwvZlwvMGMwYmUzMTYtOWE0OS00ODhiLWE4NjktMTQ0OWVlNmVhN2Y1XC9kNnBkcTh2LTYxNWJjZTRiLTVhY2MtNGJiNi05MjNmLTkxYmY5NDJmMzEyMy5qcGciLCJ3aWR0aCI6Ijw9MTAyNCJ9XV0sImF1ZCI6WyJ1cm46c2VydmljZTppbWFnZS5vcGVyYXRpb25zIl19.m8HnjORRklm_kYV_KBmjlL1ft5yq2N9iFO4zjWggYK4') no-repeat center center fixed;
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

        .btn-secondary {
            background-color: #3498db;
        }

        .btn-secondary:hover {
            background-color: #2980b9;
            box-shadow: 0 0 10px #3498db, 0 0 20px #2980b9;
        }

        .btn-info {
            background-color: #9b59b6;
        }

        .btn-info:hover {
            background-color: #8e44ad;
            box-shadow: 0 0 10px #9b59b6, 0 0 20px #8e44ad;
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

        .btn-primary {
            background-color: #e74c3c;
        }

        .btn-primary:hover {
            background-color: #c0392b;
            box-shadow: 0 0 10px #e74c3c, 0 0 20px #c0392b;
        }

        h3 {
            color: #f1c40f; 
            text-shadow: 0 0 10px #f39c12, 0 0 20px #f1c40f, 0 0 30px #f1c40f;
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="d-flex justify-content-between align-items-center my-3">
            <h1>Applicant Dashboard</h1>
            <a href="index.php" class="btn btn-secondary">Home</a>
            <a href="profile.php" class="btn btn-info">Your Profile</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3>Available Job Posts</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Job Description</th>
                            <th>Apply</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($job_posts as $job): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($job['title']); ?></td>
                                <td><?php echo htmlspecialchars($job['description']); ?></td>
                                <td>
                                    <a href="apply_job.php?job_id=<?php echo $job['id']; ?>" class="btn btn-primary">Apply</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
