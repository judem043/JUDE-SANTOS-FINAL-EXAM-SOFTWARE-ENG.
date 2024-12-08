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

$stmt = $pdo->prepare("DELETE FROM applications WHERE id = ? AND applicant_id = ?");
$stmt->execute([$application_id, $_SESSION['user_id']]);

if (file_exists($application['resume'])) {
    unlink($application['resume']);
}

header("Location: applicant_dashboard.php");
exit();
?>
