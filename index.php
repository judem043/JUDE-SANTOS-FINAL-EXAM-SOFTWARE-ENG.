<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body {
            font-family: 'Press Start 2P', cursive;
            margin: 0;
            padding: 0;
            background: url('https://wallpapers.com/images/featured/minecraft-hd-f0k9haimutvt21n8.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .hero-section {
            background: rgba(0, 0, 0, 0.8);
            padding: 60px 0;
            border: 3px solid #2ecc71;
            box-shadow: 0 0 15px #27ae60, inset 0 0 15px #2ecc71;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            color: #2ecc71;
            text-shadow: 0 0 10px #27ae60, 0 0 20px #2ecc71, 0 0 30px #1abc9c;
        }

        .hero-section p {
            font-size: 1.2rem;
            color: #f1c40f;
            text-shadow: 0 0 10px #f39c12, 0 0 20px #f1c40f, 0 0 30px #f1c40f;
        }

        .category-buttons a {
            font-family: 'Press Start 2P', cursive;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            border-radius: 10px;
            box-shadow: 0 0 10px #34495e;
        }

        .category-buttons a:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px #2ecc71;
        }

        .btn-success {
            background-color: #27ae60;
            border: none;
        }

        .btn-success:hover {
            background-color: #229954;
        }

        .btn-warning {
            background-color: #f39c12;
            border: none;
        }

        .btn-warning:hover {
            background-color: #d68910;
        }

        footer {
            background: rgba(0, 0, 0, 0.8);
            color: #2ecc71;
            text-shadow: 0 0 10px #27ae60, 0 0 20px #2ecc71;
            border-top: 3px solid #27ae60;
            padding: 20px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <div class="hero-section text-center">
        <div class="container">
            <h1>Welcome to FindHire!</h1>
            <p class="lead">Explore opportunities and resources designed just for you.</p>
        </div>
    </div>


    <div class="container text-center mt-5">
        <div class="category-buttons d-flex justify-content-center gap-3">
            <a href="login_employee.php" class="btn btn-success btn-lg px-4">Employee Login</a>
            <a href="login_applicant.php" class="btn btn-warning btn-lg px-4">Applicant Login</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
