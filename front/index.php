<?php
session_start();

// Veritabanı bağlantısı yapılmadığı için şu an boş bıraktım

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // login
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Burada veritabanı sorgusu olacak. Şu an statik değer koydum

        if ($username == 'kullanici1' && $password == 'sifre123') {
            $_SESSION['username'] = $username;
            header("Location: profil.php");
            exit();
        } elseif ($username == 'kullanici2' && $password == 'parola456') {
            $_SESSION['username'] = $username;
            header("Location: profil.php");
            exit();
        } else {
            echo "Hatalı kullanıcı adı veya şifre!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş ve Kayıt Ol</title>
    <style>
        /* Sayfanın tamamına etki eden stil */
        body {
            font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        /* Form alanları için stil */
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .form-container h2 {
            text-align: center;
            color: blue;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: darkblue;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 10px;
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Giriş Yap</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Kullanıcı Adı" required><br>
            <input type="password" name="password" placeholder="Şifre" required><br>
            <button type="submit" name="login">Giriş Yap</button>
        </form>

        <p>Henüz kaydınız yok mu? <a href="#" onclick="document.getElementById('register-form').style.display='block'; document.getElementById('login-form').style.display='none';">Kayıt Ol</a></p>
    </div>

    <div class="form-container" id="register-form" style="display:none;">
        <h2>Kayıt Ol</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Kullanıcı Adı" required><br>
            <input type="password" name="password" placeholder="Şifre" required><br>
            <button type="submit" name="register">Kayıt Ol</button>
        </form>

        <p>Zaten kaydınız var mı? <a href="#" onclick="document.getElementById('register-form').style.display='none'; document.getElementById('login-form').style.display='block';">Giriş Yap</a></p>
    </div>
</body>
</html>
