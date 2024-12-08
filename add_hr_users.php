<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=santos", "username", "password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


$users = [
    ['first_name' => 'Jude', 'last_name' => 'Santos', 'username' => 'JudeSantos', 'email' => 'jude.santos@gmail.com', 'role' => 'HR'],
    ['first_name' => 'Ivan', 'last_name' => 'Dequito', 'username' => 'IvanDequito', 'email' => 'ivan.dequito@gmail.com', 'role' => 'HR'],
    ['first_name' => 'Jaysyon', 'last_name' => 'Garcia', 'username' => 'JaysyonGarcia', 'email' => 'jaysyon.garcia@gmail.com', 'role' => 'HR'],
    ['first_name' => 'Marko', 'last_name' => 'Pascual', 'username' => 'MarkoPascual', 'email' => 'marko.pascual@gmail.com', 'role' => 'HR'],
    ['first_name' => 'Steven', 'last_name' => 'Go', 'username' => 'StevenGo', 'email' => 'steven.go@gmail.com', 'role' => 'HR'],
];

$password = 'HR'; 


$stmtCheckUser = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");


$stmtInsertUser = $pdo->prepare("INSERT INTO users (first_name, last_name, username, email, password, role) 
                                VALUES (:first_name, :last_name, :username, :email, :password, :role)");

foreach ($users as $user) {
    
    $stmtCheckUser->bindParam(':username', $user['username']);
    $stmtCheckUser->execute();

    if ($stmtCheckUser->rowCount() > 0) {
        echo "Username '{$user['username']}' already exists, skipping insertion.\n";
        continue; 
    }


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    $stmtInsertUser->bindParam(':first_name', $user['first_name']);
    $stmtInsertUser->bindParam(':last_name', $user['last_name']);
    $stmtInsertUser->bindParam(':username', $user['username']);
    $stmtInsertUser->bindParam(':email', $user['email']);
    $stmtInsertUser->bindParam(':password', $hashedPassword);
    $stmtInsertUser->bindParam(':role', $user['role']);

    try {
        $stmtInsertUser->execute(); 
        echo "User '{$user['username']}' inserted successfully.\n";
    } catch (PDOException $e) {
        echo "Error inserting user '{$user['u
