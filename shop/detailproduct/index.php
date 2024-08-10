<?php
session_start();
require '../../functions/functions.php';

if (!isset($_POST["kodebarang"])) {
    header("Location: ../index.php");
    exit;
}

$kd = $_POST["kodebarang"];
$jml_barang = 1;

$items = query("SELECT * FROM barang WHERE kd_barang = '$kd'");

if (isset($_SESSION["login"])) {
    if ($_SESSION['role'] == "Admin") {
        $name = $_SESSION['name'];
        $oke = '    
                    <div class="dropdown-content">
                        <a href="../../myorder/" class="droplink">Pesanan Saya</a>
                        <a href="../../admin/index.php" class="droplink">Dashboard Admin</a>
                        <a href="../../logout.php" class="droplink">Logout</a>
                    </div>
                ';
    } else {
        $name = $_SESSION['name'];
        $oke = '    
                <div class="dropdown-content">
                    <a href="../../myorder/" class="droplink">Pesanan Saya</a>
                    <a href="../../logout.php" class="droplink">Logout</a>
                </div>
            ';
    }
} else {
    $name = '';
    $oke = '<a href="../../signin/" class="login">login</a>
            <a href="../../signup/" class="signup">sign up</a>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Product</title>
    <!-- swiper link  -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- cdn icon link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- custom css file  -->
    <link rel="stylesheet" href="../../css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">
</head>

<body>
    <!-- header section start here  -->
    <header class="header">
        <div class="logoContent">
            <a href="../../../projekRPL/" class="logo">
                <img src="../../img/LOGOTT.svg" alt="">
                <!-- <h1 class="logoName"> TOKO TAS </h1> -->
            </a>

        </div>

        <nav class="navbar">
            <a href="../../../projekRPL/" class="navstyle">home</a>
            <a href="../../shop/" class="navstyle">shop</a>
            <!-- <div class="dropdown">
                <button class="dropbtn">Dropdown</button>
                <div class="dropdown-content">
                    <a href="#" class="droplink">Link 1</a>
                    <a href="#" class="droplink">Link 2</a>
                    <a href="#" class="droplink">Link 3</a>
                </div>
            </div> -->
            <a href="../../../projekRPL/#about" class="navstyle">about</a>
            <a href="#contact" class="navstyle">contact</a>
        </nav>

        <div class="icon">
            <i class="fas fa-bars" id="menu-bar"></i>
            <div class="dropdown">
                <button class="dropbtn"><?= $name; ?></button>
                <?= $oke; ?>
            </div>
        </div>
    </header>

    <div class="detail-container">
        <?php foreach ($items as $item) : ?>
            <div class="detail-container2">
                <div class="detail-img">
                    <img src="../../img/<?= $item['gambar_barang']; ?>" alt="">
                </div>
                <div class="detail">
                    <div class="header-detail">
                        <h2><?= $item['nama_barang']; ?></h2>
                        <p>Rp<?= number_format($item['harga_barang'], 0, '', '.') ?></p>
                    </div>
                    <div class="footer-detail">
                        <p>Stok: <?= $item['stok_barang']; ?></p>
                    </div>
                    <div class="form-order">
                        <form action="../order/" method="post">
                            <input type="hidden" name="kd_barang" id="kd_barang" value="<?= $item['kd_barang']; ?>">
                            <input type="hidden" name="jml_barang" id="jml_barang" value="<?= $jml_barang; ?>">
                            <button type=" submit" name="submit" class="btn-order">Order Now</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- header section end here  -->

    <footer class="footer" id="contact">
        <div class="blur">
            <div class="box-container">
                <div class="mainBox">
                    <h3>Contact Info</h3>
                    <a href="https://wa.me/089505699702?text=Bang%20beli%20bang" target="_blank"> <i class="fas fa-phone"></i>089505699702</a>
                    <a href="mailto:fadlurrahmanfaiq@gmail.com"> <i class="fas fa-envelope"></i>fadlurrahmanfaiq@gmail.com</a>
                </div>
                <div class="logo-box">
                    <a href="../../../projekRPL/" class="logo"><img src="../../img/LOGOTT.svg" alt=""></a>
                </div>
            </div>

            <div class="credit">
                <p class="copy">Copyright &copy; 2023 Fadlur Rahman Fa'iq</p>
            </div>
        </div>
    </footer>
</body>

</html>