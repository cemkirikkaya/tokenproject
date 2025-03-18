<?php
session_start();

$remainingTimeText = "Token bulunamadı!";
$expired = false;

if (!isset($_COOKIE['token'])) {
    header("Location: index.php");
    exit();
}

$token = $_COOKIE['token'];
$tokenParts = explode(".", $token);
$payload = json_decode(base64_decode($tokenParts[1]), true);

if (isset($payload['exp'])) {
    $expireTime = $payload['exp'];
    $currentTime = time();
    $remainingTime = $expireTime - $currentTime;

    if ($remainingTime > 0) {
        $minutes = floor($remainingTime / 60);
        $seconds = $remainingTime % 60;
        $remainingTimeText = "Token süresi dolmasına: ";
        if ($minutes > 0) {
            $remainingTimeText .= "$minutes dakika ";
        }
        $remainingTimeText .= "$seconds saniye kaldı.";
    } else {
        $remainingTimeText = "Token süresi doldu!";
        $expired = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    setcookie("token", "", time() - 3600, "/");
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .token-time {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: <?php echo $expired ? 'red' : '#2E86C1'; ?>;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h1 {
            font-size: 24px;
            color: #333;
        }
        button {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>

    <div class="token-time"><?php echo $remainingTimeText; ?></div>

    <div class="container">
        <h1>Hoşgeldin, <?php echo htmlspecialchars($email); ?>!</h1>
        <p>Profil sayfası.</p>

        <form method="POST">
            <button type="submit" name="logout">Çıkış Yap</button>
        </form>
    </div>

</body>
</html>
