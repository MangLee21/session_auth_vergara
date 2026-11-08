<?php

session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $error = 'Please fill in all fields.';
    } elseif (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $username)) {
        $error = 'Username must be 3-30 characters: letters, numbers, or underscore only.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);

        if ($stmt->fetch()) {
            $error = 'That username or email is already taken.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);

            $success = 'Account created successfully! You can now log in.';
            $username = $email = '';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - SessionAuthSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary d-flex align-items-center min-vh-100">
    <div class="container py-4" style="max-width: 440px;">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="rounded-circle text-white d-inline-flex align-items-center justify-content-center mb-3" style="width:56px;height:56px; background-color: #ef4444;">
                        <i class="bi bi-person-plus-fill fs-4"></i>
                    </div>
                    <h2 class="fw-bold mb-1" style="color: #ef4444;">Create Account</h2>
                    <p class="text-muted mb-0">Sign up to get started</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger py-2" role="alert"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success py-2" role="alert">
                        <?php echo htmlspecialchars($success); ?> <a href="index.php" class="alert-link">Login</a>
                    </div>
                <?php endif; ?>

                <form method="POST" action="register.php">
                    <label for="username" class="form-label fw-semibold">Username</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" value="<?php echo htmlspecialchars($username); ?>" required autofocus>
                    </div>

                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>

                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group mb-4">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Create a password" required>
                    </div>

                    <button type="submit" class="btn w-100 fw-semibold" style="background-color: #ef4444; border-color: #ef4444; color: #fff;">
                        <i class="bi bi-person-plus me-1"></i> Register
                    </button>
                </form>

                <p class="text-center text-muted small mt-4 mb-0">
                    Already have an account? <a href="index.php" class="text-decoration-none" style="color: #ef4444;">Login here</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>