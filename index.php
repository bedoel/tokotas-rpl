<?php
session_start();

require 'functions/functions.php';

$items = query("SELECT * FROM barang");

if (isset($_COOKIE['co']) && isset($_COOKIE['li'])) {
    $co = $_COOKIE['co'];
    $li = $_COOKIE['li'];

    // Ambil Username berdasarkan ID
    $result = mysqli_query($conn, "SELECT * FROM tbl_users WHERE id_user = '$co'");
    $row = mysqli_fetch_assoc($result);

    if ($li === hash("sha256", $row["username"])) {
        $_SESSION["login"] = true;
        $_SESSION["users"] = $row["username"];
        $_SESSION["name"] = $row["name"];
        $_SESSION["id"] = $row["id_user"];
        $_SESSION["role"] = $row["role"];
    }
}

if (isset($_SESSION["login"])) {
    if ($_SESSION['role'] == "Admin") {
        $name = $_SESSION['name'];
        $oke = '    
                    <div class="dropdown-content">
                        <a href="myorder/" class="droplink">Pesanan Saya</a>
                        <a href="admin/index.php" class="droplink">Dashboard Admin</a>
                        <a href="logout.php" class="droplink">Logout</a>
                    </div>
                ';
    } else if ($_SESSION['role'] == "Seller") {
        $name = $_SESSION['name'];
        $oke = '    
                    <div class="dropdown-content">
                        <a href="myorder/" class="droplink">Pesanan Saya</a>
                        <a href="seller/index.php" class="droplink">Dashboard Seller</a>
                        <a href="logout.php" class="droplink">Logout</a>
                    </div>
                ';
    } else {
        $name = $_SESSION['name'];
        $oke = '    
                <div class="dropdown-content">
                    <a href="myorder/" class="droplink">Pesanan Saya</a>
                    <a href="logout.php" class="droplink">Logout</a>
                </div>
            ';
    }
} else {
    $name = '';
    $oke = '<a href="signin/" class="login">login</a>
            <a href="signup/" class="signup">sign up</a>';
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Tas</title>
    <!-- swiper link  -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- cdn icon link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- custom css file  -->
    <link rel="stylesheet" href="css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">
</head>

<body>
    <!-- header section start here  -->
    <header class="header">
        <div class="logoContent">
            <a href="../projekRPL/" class="logo">
                <img src="img/LOGOTT.svg" alt="">
                <!-- <h1 class="logoName"> TOKO TAS </h1> -->
            </a>

        </div>

        <nav class="navbar">
            <a href="../projekRPL/" class="navstyle">home</a>
            <a href="shop/" class="navstyle">shop</a>
            <a href="#about" class="navstyle">about</a>
            <a href="#contact" class="navstyle">contact</a>
        </nav>

        <div class="icon">
            <i class="fas fa-bars" id="menu-bar"></i>
            <div class="dropdown">
                <button class="dropbtn"> <?= $name; ?> </button>
                <?= $oke; ?>
            </div>

        </div>
    </header>
    <!-- header section end here  -->

    <!-- home section start here  -->
    <section class="home" id="home">
        <div class="homecontainer">
            <div class="homeContent">
                <h2>Tas Trendi untuk Eksplorasi Tanpa Batas</h2>
            </div>
            <div class="home-btn">
                <a href="shop/"><button>Shop Now</button></a>
            </div>
        </div>
    </section>
    <!-- home section end here  -->

    <!-- product section start here  -->
    <section class="product" id="product">
        <div class="heading">
            <h2>Products</h2>
        </div>
        <div class="swiper product-row">
            <div class="swiper-wrapper">
                <?php foreach ($items as $item) : ?>
                    <div class="swiper-slide box">
                        <div class="img">
                            <img src="img/<?= $item['gambar_barang']; ?>" alt="">
                        </div>
                        <div class="product-content">
                            <h3><?= $item['nama_barang']; ?></h3>
                            <p>Rp<?= number_format($item['harga_barang']); ?></p>
                            <div class="readme">
                                <form action="shop/detailproduct/" method="post">
                                    <input type="hidden" name="kodebarang" value="<?= $item['kd_barang']; ?>">
                                    <button>Buy Now</button>
                                </form>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- product section end here  -->

    <!-- About Start -->
    <div class="container-about" id="about">
        <div class="heading">
            <h2>About Us</h2>
        </div>
        <div class="container-about-content">
            <div class="about-content">
                <p>Selamat datang di Aplikasi Toko Tas, destinasi terbaik Anda untuk menemukan berbagai macam tas trendy dan fungsional untuk gaya hidup Anda. Kami adalah platform yang didedikasikan untuk menyediakan pengalaman berbelanja online yang menyenangkan, praktis, dan memuaskan bagi para pengguna yang mencari tas dengan kualitas terbaik.</p>
                <p class="margintop">Terima kasih telah memilih Aplikasi Toko Tas sebagai destinasi belanja Anda. Kami berkomitmen untuk terus memberikan pengalaman belanja yang luar biasa dan menjadi mitra terpercaya dalam menemukan tas impian Anda.</p>
                <p class="margintop">Salam,</p>
                <p>Tim Aplikasi Toko Tas</p>
            </div>
        </div>
    </div>
    <!-- About End -->

    <footer class="footer" id="contact">
        <div class="blur">
            <div class="box-container">
                <div class="mainBox">
                    <h3>Contact Info</h3>
                    <a href="#" target="_blank"> <i class="fas fa-phone"></i>0123456789121</a>
                    <a href="mailto:#"> <i class="fas fa-envelope"></i>tokotasofficial@gmail.com</a>
                </div>
                <div class="logo-box">
                    <a href="../projekRPL/" class="logo"><img src="img/LOGOTT.svg" alt=""></a>
                </div>
            </div>

            <div class="credit">
                <p class="copy">Copyright &copy; 2023 Fadlur Rahman Fa'iq</p>
            </div>
        </div>
    </footer>

    <!-- swiper js link  -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- custom js file  -->
    <script src="js/bagian.js"></script>
</body>

</html>