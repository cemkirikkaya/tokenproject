<?php
session_start();

if (!isset($_COOKIE['token'])) {
    header("Location: index.php");
    exit();
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
    <title>Profil</title>
</head>
<body>
    <h2>Hoşgeldin, <?php echo htmlspecialchars($email); ?>!</h2>
    <p>Profil sayfası.</p>
    
    <!-- Çıkış yap butonu -->
    <form method="POST">
        <button type="submit" name="logout">Çıkış Yap</button>
    </form>
</body>
</html>
