<?php
session_start();
require '../functions/functions.php';

// Cek Cookie
if (isset($_COOKIE['co']) && isset($_COOKIE['kie'])) {
    $co = $_COOKIE['co'];
    $kie = $_COOKIE['kie'];

    // Ambil Username berdasarkan ID
    $result = mysqli_query($conn, "SELECT * FROM tbl_users WHERE id_user = '$co'");
    $row = mysqli_fetch_assoc($result);

    if ($kie === hash("sha256", $row["username"])) {
        $_SESSION["login"] = true;
        $_SESSION["users"] = $row["username"];
        $_SESSION["name"] = $row["name"];
        $_SESSION["id"] = $row["id_user"];
    }
}

if (isset($_SESSION["login"])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_POST["signin"])) {
    // Captcha
    if ($_POST["vercode"] != $_SESSION["vercode"] or $_SESSION["vercode"] == '') {
        echo "<script>alert('Verifikasi Code Salah!');</script>";
    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $result = mysqli_query($conn, "SELECT * FROM tbl_users WHERE
                    username = '$username'");

        // Cek Username
        if (mysqli_num_rows($result) === 1) {

            // Cek Password
            $row = mysqli_fetch_assoc($result);
            if ($password == $row["password"]) {
                // Cek Session
                $_SESSION["login"] = true;
                $_SESSION["users"] = $row["username"];
                $_SESSION["name"] = $row["name"];
                $_SESSION["id"] = $row["id_user"];
                $_SESSION["role"] = $row["role"];

                // Cek Remember me
                if (isset($_POST["remember"])) {
                    setcookie('co', $row['id_user'], time() + 86400, '/');
                    setcookie('kie', hash('sha256', $row['username']), time() + 86400, '/');
                }

                header("Location: ../../projekRPL/");
                exit;
            }
        }

        $error = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <!-- swiper link  -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- cdn icon link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- custom css file  -->
    <link rel="stylesheet" href="../css/styleinput.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Sign In</h1>
        </div>

        <div class="salah">
            <?php if (isset($error)) : ?>
                <p>Username / password salah!</p>
            <?php endif; ?>
        </div>

        <div class="main">
            <form action="" method="POST">
                <div class="content">
                    <label for="username"><span class="kurung">> </span>Username
                    </label>
                    <div class="input">
                        <input type="text" name="username" id="username" class="textfield">
                    </div>
                    <label for="password"><span class="kurung">> </span>Password</label>
                    <div class="input">
                        <input type="password" name="password" id="password" class="textfield">
                    </div>

                    <div class="input">
                        <img src="../functions/captcha.php">
                        <input class="textfield" type="text" name="vercode" placeholder="Verification Code" maxlength="6" autocomplete="off" />
                    </div>
                </div>

                <div class="rememberme">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" class="me">Remember me</label>
                </div>

                <div class="button">
                    <button type="submit" name="signin">Sign in</button>
                </div>

                <div class="register">
                    <p>
                        Masih belum memiliki akun?
                        <a href="../signup/">Daftar Disini!</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <div class="footer">
        <p class="copy">Copyright &copy; 2023 fadlurrahmanfaiq</p>
    </div>
</body>

</html>