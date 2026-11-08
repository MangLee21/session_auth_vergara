<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$session_id = session_id();

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - SessionAuthSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">Session_Auth_System</a>
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
            </ul>
            <span class="navbar-text text-white me-3">
                <i class="bi bi-person-circle me-1"></i><?php echo e($username); ?>
            </span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="bg-white border rounded-3 p-4 p-md-5 mb-4">
            <h1 class="fw-bold mb-3" style="color: #8b5cf6;">Welcome, <?php echo e($username); ?>!</h1>
            <p class="text-muted mb-4">This page is protected and only visible to logged-in users.</p>
            <a href="dashboard.php" class="btn" style="background-color: #8b5cf6; border-color: #8b5cf6; color: #ffffff;">Explore Dashboard</a>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="text-success"><i class="bi bi-shield-check me-2"></i>Account Status</h5>
                <p class="text-muted small mb-0">
                    Your session is active and protected against Session Fixation using
                    <code>session_regenerate_id(true)</code>.
                </p>
            </div>
            <div class="col-md-4">
                <h5 class="text-info"><i class="bi bi-person-badge me-2"></i>User Details</h5>
                <p class="small mb-1"><strong>User ID:</strong> <?php echo e($user_id); ?></p>
                <p class="small mb-0"><strong>Username:</strong> <?php echo e($username); ?></p>
            </div>
            <div class="col-md-4">
                <h5 class="text-warning"><i class="bi bi-code-slash me-2"></i>Active Session ID</h5>
                <p class="small fw-bold mb-1">Current Session ID:</p>
                <code class="text-danger small d-block mb-2" style="word-break: break-all;"><?php echo e($session_id); ?></code>
                <p class="text-muted small mb-0">
                    Generated after login call to <code>session_regenerate_id(true)</code>.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
