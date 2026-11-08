<?php

session_start();


$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy();

header('Location: index.php');
exit;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out - Session Auth</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #a866ea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logout-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .logout-container h2 {
            color: #333;
            margin-bottom: 15px;
        }
        .logout-container p {
            color: #666;
            margin-bottom: 25px;
        }
        .btn-login {
            display: inline-block;
            padding: 12px 30px;
            background: #764ba2;
            color: #fff;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background: #5a3a75;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <h2>Logged Out</h2>
        <p>You have been successfully logged out. Your session has been destroyed.</p>
        <a href="index.php" class="btn-login">Log In Again</a>
    </div>
</body>
</html>