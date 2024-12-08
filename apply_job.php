<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Applicant') {
    header("Location: login_applicant.php");
    exit();
}

require_once 'core/dbConfig.php';

if (!isset($_GET['job_id'])) {
    header("Location: applicant_dashboard.php");
    exit();
}

$job_id = $_GET['job_id'];

$stmt = $pdo->prepare("SELECT * FROM job_posts WHERE id = ?");
$stmt->execute([$job_id]);
$job = $stmt->fetch();

if (!$job) {
    header("Location: applicant_dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $applicant_name = $_POST['applicant_name'];

    if (!empty($applicant_name)) {
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['resume']['tmp_name'];
            $file_name = basename($_FILES['resume']['name']);
            $upload_dir = 'uploads/';

 
            if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {

                $stmt = $pdo->prepare("INSERT INTO applications (applicant_id, job_post_id, name, resume, status) VALUES (?, ?, ?, ?, 'PENDING')");
                $stmt->execute([$_SESSION['user_id'], $job_id, $applicant_name, $upload_dir . $file_name]);

                $success_message = "Your application has been submitted!";
            } else {
                $error_message = "Failed to upload your resume. Please try again.";
            }
        } else {
            $error_message = "Please upload your resume.";
        }
    } else {
        $error_message = "Please enter your name.";
    }
}

$stmt = $pdo->prepare("
    SELECT id, name, resume
    FROM applications
    WHERE applicant_id = ? AND job_post_id = ?
");
$stmt->execute([$_SESSION['user_id'], $job_id]);
$applications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
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

        .btn-link {
            color: #2ecc71;
            text-shadow: 0 0 10px #27ae60, 0 0 20px #2ecc71;
        }

        footer {
            background: rgba(0, 0, 0, 0.8);
            color: #2ecc71;
            text-shadow: 0 0 10px #27ae60, 0 0 20px #2ecc71;
            border-top: 3px solid #27ae60;
            padding: 20px 0;
            margin-top: 50px;
        }
        th {
            color: #f1c40f;
        }
        td {
            color: #2ecc71; /* Green color */
        }

        a {
            color: #2ecc71; /* Green color */
        }


    </style>
</head>
<body>

    <div class="container">

        <div class="d-flex justify-content-between align-items-center my-3">
            <h1>Apply for: <?php echo htmlspecialchars($job['title']); ?></h1>
            <a href="index.php" class="btn btn-secondary">Home</a>
        </div>


        <div class="mb-4">
            <p><strong>Job Description:</strong> <?php echo htmlspecialchars($job['description']); ?></p>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php elseif (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="applicant_name" class="form-label">Enter Your Name</label>
                <input type="text" class="form-control" name="applicant_name" required>
            </div>
            <div class="mb-3">
                <label for="resume" class="form-label">Upload Resume (PDF only)</label>
                <input type="file" class="form-control" name="resume" accept=".pdf" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Application</button>
            <a href="applicant_dashboard.php" class="btn btn-link">Back to Dashboard</a>
        </form>

        <div class="mt-5">
            <h2>Your Applications</h2>
            <?php if (count($applications) > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="color: #f1c40f;">Name</th>
                            <th style="color: #f1c40f;">Resume</th>
                            <th style="color: #f1c40f;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $application): ?>
                            <tr>
                                <td style="color: #2ecc71;"><?php echo htmlspecialchars($application['name']); ?></td>
                                <td><a href="<?php echo htmlspecialchars($application['resume']); ?>" target="_blank">View Resume</a></td>
                                <td>
                                    <a href="edit_application.php?id=<?php echo $application['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_application.php?id=<?php echo $application['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this application?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No applications yet.</p>
            <?php endif; ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>