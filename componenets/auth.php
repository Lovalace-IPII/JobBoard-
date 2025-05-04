<?php
session_start();
include 'connectUsersDb.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        handleLogin();
    } elseif (isset($_POST['register'])) {
        handleRegistration();
    }
}

function handleLogin() {
    global $conn;
    
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        echo json_encode(['type' => 'error', 'text' => 'Please enter credentials!']);
        exit;
    }
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['type' => 'error', 'text' => 'Please enter a valid email!']);
        exit;
    }
    
    // Check admin
    $stmt = $conn->prepare("SELECT id, name FROM admin WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["aid"] = $row["id"];
        $_SESSION["login_admin"] = $row["name"];
        echo json_encode(['type' => 'success', 'text' => 'Admin login successful']);
        exit;
    }
    
    // Check employer
    $stmt = $conn->prepare("SELECT id, name FROM employer WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["eid"] = $row["id"];
        $_SESSION["login_employer"] = $row["name"];
        echo json_encode(['type' => 'success', 'text' => 'Employer login successful']);
        exit;
    }
    
    // Check job seeker
    $stmt = $conn->prepare("SELECT id, name FROM seeker WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["sid"] = $row["id"];
        $_SESSION["login_user"] = $row["name"];
        echo json_encode(['type' => 'success', 'text' => 'Job seeker login successful']);
        exit;
    }
    
    echo json_encode(['type' => 'error', 'text' => 'Invalid credentials!']);
    exit;
}

function handleRegistration() {
    global $conn;
    
    if (!isset($_POST['role'])){
        echo json_encode(['type' => 'error', 'text' => 'Please select a role!']);
        exit;
    }
    
    $role = $_POST['role'];
    $requiredFields = ['name', 'email', 'password'];
    
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            echo json_encode(['type' => 'error', 'text' => "Please fill all required fields!"]);
            exit;
        }
    }
    
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['type' => 'error', 'text' => 'Please enter a valid email!']);
        exit;
    }
    
    // Check if email already exists
    $tables = $role === 'employer' ? ['employer', 'seeker', 'admin'] : ['seeker', 'employer', 'admin'];
    foreach ($tables as $table) {
        $stmt = $conn->prepare("SELECT id FROM $table WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo json_encode(['type' => 'error', 'text' => 'Email already registered!']);
            exit;
        }
    }
    
    if ($role === 'employer') {
        // Register employer
        $stmt = $conn->prepare("INSERT INTO employer (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
    } else {
        // Register job seeker
        if (!isset($_POST['qlf']) || !isset($_POST['dob']) || !isset($_POST['skills'])) {
            echo json_encode(['type' => 'error', 'text' => 'Please fill all required fields!']);
            exit;
        }
        
        $qlf = trim($_POST['qlf']);
        $dob = trim($_POST['dob']);
        $skills = trim($_POST['skills']);
        
        $stmt = $conn->prepare("INSERT INTO seeker (name, email, password, qualification, dob, skills) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $password, $qlf, $dob, $skills);
    }
    
    if ($stmt->execute()) {
        echo json_encode(['type' => 'success', 'text' => 'Registration successful! Please login.']);
    } else {
        echo json_encode(['type' => 'error', 'text' => 'Registration failed. Please try again.']);
    }
}
?>
