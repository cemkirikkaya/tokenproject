<?php
session_start();

$api_base_url = "deneme";

if (isset($_COOKIE['jwt_token'])) {
    $token = $_COOKIE['jwt_token'];
    
    $ch = curl_init("$api_base_url/verifyToken");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['statusCode']) && $result['statusCode'] == 202) {
        $_SESSION['jwt_token'] = $token;
        $_SESSION['email'] = $result['email'];
        header("Location: profil.php");
        exit();
    } else {
        setcookie("jwt_token", "", time() - 3600, "/");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $data = json_encode(["email" => $email, "password" => $password]);

    $ch = curl_init("$api_base_url/login");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['statusCode']) && $result['statusCode'] == 201) {
        $_SESSION['jwt_token'] = $result['token'];
        $_SESSION['email'] = $email;
        
        setcookie("jwt_token", $result['token'], time() + (3600), "/");

        header("Location: profil.php");
        exit();
    } else {
        echo "Giriş başarısız! Hatalı email veya şifre.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];

    $data = json_encode(["email" => $new_email, "password" => $new_password]);

    $ch = curl_init("$api_base_url/register");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['statusCode']) && $result['statusCode'] == 200) {
        echo "Kayıt başarılı! Giriş yapabilirsiniz.";
    } else {
        echo "Kayıt başarısız! Lütfen tekrar deneyin.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>JWT ile Authentication</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { margin: 50px auto; width: 300px; }
        input, button { width: 100%; padding: 10px; margin: 5px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Giriş Yap</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="E-posta" required><br>
            <input type="password" name="password" placeholder="Şifre" required><br>
            <button type="submit" name="login">Giriş Yap</button>
        </form>

        <h2>Kayıt Ol</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="E-posta" required><br>
            <input type="password" name="password" placeholder="Şifre" required><br>
            <button type="submit" name="register">Kayıt Ol</button>
        </form>
    </div>
</body>
</html>
