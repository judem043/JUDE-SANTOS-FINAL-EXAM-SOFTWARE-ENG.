<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Applicant') {
    header("Location: login_applicant.php");
    exit();
}

require_once 'core/dbConfig.php';


if (!isset($_GET['id'])) {
    header("Location: applicant_dashboard.php");
    exit();
}

$application_id = $_GET['id'];


$stmt = $pdo->prepare("SELECT * FROM applications WHERE id = ? AND applicant_id = ?");
$stmt->execute([$application_id, $_SESSION['user_id']]);
$application = $stmt->fetch();

if (!$application) {
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
                $stmt = $pdo->prepare("UPDATE applications SET name = ?, resume = ? WHERE id = ?");
                $stmt->execute([$applicant_name, $upload_dir . $file_name, $application_id]);

                $success_message = "Application updated successfully!";
            } else {
                $error_message = "Failed to upload your resume. Please try again.";
            }
        } else {
            $stmt = $pdo->prepare("UPDATE applications SET name = ? WHERE id = ?");
            $stmt->execute([$applicant_name, $application_id]);

            $success_message = "Application updated successfully!";
        }
    } else {
        $error_message = "Please enter your name.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 0;
            background: url('https://img2.wallspic.com/crops/8/8/1/6/6/166188/166188-minecraft_dungeons_creeping_winter-1920x1080.jpg') no-repeat center center fixed;
            background-size: cover;
            color: black;
        }

        .container {
            max-width: 900px;
            background: rgba(0, 0, 0, 0.8);
            border: 3px solid #2ecc71;
            box-shadow: 0 0 15px #27ae60, inset 0 0 15px #2ecc71;
            border-radius: 10px;
            padding: 40px;
            margin-top: 50px;
        }

        h1 {
            color: #f1c40f;
            text-shadow: 0 0 10px #f39c12, 0 0 20px #f1c40f, 0 0 30px #f39c12;
            text-align: center;
        }

        .alert {
            font-family: 'Press Start 2P', cursive;
            font-size: 1.2rem;
            text-align: center;
            padding: 15px;
        }

        .alert-success {
            background-color: #27ae60;
            color: white;
        }

        .alert-danger {
            background-color: #e74c3c;
            color: white;
        }

        .form-label {
            color: #f1c40f;
            font-weight: bold;
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

        .btn-secondary {
            background-color: #f39c12;
        }

        .btn:hover {
            box-shadow: 0 0 10px #27ae60;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Application</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="applicant_name" class="form-label">Name</label>
                <input type="text" class="form-control" name="applicant_name" value="<?php echo htmlspecialchars($application['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="resume" class="form-label">Upload New Resume (optional)</label>
                <input type="file" class="form-control" name="resume" accept=".pdf">
            </div>
            <button type="submit" class="btn btn-primary">Update Application</button>
            <a href="applicant_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
