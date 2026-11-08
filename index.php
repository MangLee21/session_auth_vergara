<?php

session_start();
require_once 'db.php';


if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($login === '' || $password === '') {
        $error = 'Please enter your username or email and your password.';
    } else {
        $stmt = $pdo->prepare("SELECT id, username, email, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->execute([$login, $login]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();

            header('Location: dashboard.php');
            exit;
        }
        $error = 'Invalid username/email or password.';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SessionAuthSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary d-flex align-items-center min-vh-100">
    <div class="container py-4" style="max-width: 440px;">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="rounded-circle text-white d-inline-flex align-items-center justify-content-center mb-3" style="width:56px;height:56px; background-color: #8b5cf6;">
                        <i class="bi bi-person-fill fs-4"></i>
                    </div>
                    <h2 class="fw-bold mb-1" style="color: #8b5cf6;">Welcome Back</h2>
                    <p class="text-muted mb-0">Sign in to your account</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger py-2" role="alert"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php">
                    <label for="login" class="form-label fw-semibold">Username or Email</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" name="login" id="login" placeholder="Enter username or email" value="<?php echo htmlspecialchars($login); ?>" required autofocus>
                    </div>

                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group mb-4">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
                    </div>

                    <button type="submit" class="btn w-100 fw-semibold" style="background-color: #8b5cf6; border-color: #8b5cf6; color: #fff;">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </button>
                </form>

                <p class="text-center text-muted small mt-4 mb-0">
                    Don't have an account? <a href="register.php" class="text-decoration-none" style="color: #8b5cf6;">Register here</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>