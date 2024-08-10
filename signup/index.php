<?php
session_start();
require '../functions/functions.php';

if (isset($_SESSION["login"])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_POST["signup"])) {

    //code for captach verification
    if ($_POST["vercode"] != $_SESSION["vercode"] or $_SESSION["vercode"] == '') {
        echo "<script>alert('Verifikasi Code Salah!');</script>";
    } else {
        if (registrasi($_POST) > 0) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $result = mysqli_query($conn, "SELECT * FROM tbl_users WHERE
                    username = '$username'");

            // Cek Username
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION["login"] = true;
                $_SESSION["users"] = $row["username"];
                $_SESSION["name"] = $row["name"];
                $_SESSION["id"] = $row["id_user"];
            }
            echo "<script>
                        alert('Sign Up berhasil!');
                        document.location.href = '../index.php'
                    </script>";
        } else {
            echo mysqli_error($conn);
        }
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- swiper link  -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- cdn icon link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- custom css file  -->
    <link rel="stylesheet" href="../css/styleinputup.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">
</head>

<body>
    <div class="pracontainer">
        <div class="container">
            <div class="header">
                <h1>Registrasi</h1>
            </div>

            <div class="main">
                <form action="" method="POST">
                    <div class="content">
                        <input type="hidden" name="role" id="role" value="User">
                        <label for="name"><span class="kurung">--> </span>Name</label>
                        <div class="input">
                            <input type="text" name="name" id="name" class="textfield" required>
                        </div>

                        <label for="username"><span class="kurung">--> </span>Username</label>
                        <div class="input">
                            <input type="text" name="username" id="username" class="textfield" required>
                        </div>

                        <label for="email"><span class="kurung">--> </span>Email</label>
                        <div class="input">
                            <input type="email" name="email" id="email" class="textfield" required>
                        </div>

                        <label for="tgl_lahir"><span class="kurung">--> </span>Tanggal Lahir</label>
                        <div class="input">
                            <input type="date" name="tgl_lahir" id="tgl_lahir" class="textfield" required>
                        </div>

                        <label for="no_telp"><span class="kurung">--> </span>Phone Number</label>
                        <div class="input">
                            <input type="number" name="no_telp" id="no_telp" class="textfield" required>
                        </div>

                        <label for="password"><span class="kurung">--> </span>Password</label>
                        <div class="input">
                            <input type="password" name="password" id="password" class="textfield" required>
                        </div>

                        <label for="password2"><span class="kurung">--> </span>Konfirmasi Password</label>
                        <div class="input">
                            <input type="password" name="password2" id="password2" class="textfield" required>
                        </div>

                        <div class="input">
                            <img src="../functions/captcha.php">
                            <input class="textfield" type="text" name="vercode" placeholder="Verification Code" maxlength="6" autocomplete="off" required />&nbsp;
                        </div>
                    </div>

                    <div class="button">
                        <!-- BUTTON REGISTRASI -->
                        <button type="submit" name="signup">Sign up</button>
                    </div>

                    <div class="login">
                        <p>
                            Sudah memiliki akun?
                            <a href="../signin/">Login Disini!</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="footer">
        <p class="copy">Copyright &copy; 2023 fadlurrahmanfaiq</p>
    </div>
</body>

</html>