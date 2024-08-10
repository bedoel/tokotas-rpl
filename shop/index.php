<?php

session_start();
require '../functions/functions.php';

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
                        <a href="../myorder/" class="droplink">Pesanan Saya</a>
                        <a href="../admin/index.php" class="droplink">Dashboard Admin</a>
                        <a href="../logout.php" class="droplink">Logout</a>
                    </div>
                ';
    } else {
        $name = $_SESSION['name'];
        $oke = '    
                <div class="dropdown-content">
                    <a href="../myorder/" class="droplink">Pesanan Saya</a>
                    <a href="../logout.php" class="droplink">Logout</a>
                </div>
            ';
    }
} else {
    $name = '';
    $oke = '<a href="../signin/" class="login">login</a>
            <a href="../signup/" class="signup">sign up</a>';
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
    <link rel="stylesheet" href="../css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">
</head>

<body>
    <!-- header section start here  -->
    <header class="header">
        <div class="logoContent">
            <a href="../../projekRPL/" class="logo">
                <img src="../img/LOGOTT.svg" alt="">
                <!-- <h1 class="logoName"> TOKO TAS </h1> -->
            </a>

        </div>

        <nav class="navbar">
            <a href="../../projekRPL/" class="navstyle">home</a>
            <a href="#" class="navstyle">shop</a>
            <!-- <div class="dropdown">
                <button class="dropbtn">Dropdown</button>
                <div class="dropdown-content">
                    <a href="#" class="droplink">Link 1</a>
                    <a href="#" class="droplink">Link 2</a>
                    <a href="#" class="droplink">Link 3</a>
                </div>
            </div> -->
            <a href="../../projekRPL/#about" class="navstyle">about</a>
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
    <!-- header section end here  -->

    <div class="container-shop">
        <div class="header-shop">
            <h1>SHOP</h1>
        </div>
    </div>
    <div class="container-shop-menu">
        <div class="shop-menus">
            <aside>
                <div class="garis-bawah">
                    <h3>Gender</h3>
                </div>
                <ul>
                    <li><a href="#">Pria</a></li>
                    <li><a href="#">Wanita</a></li>
                </ul>
            </aside>
            <div class="shop-menu">
                <?php foreach ($items as $item) : ?>
                    <form action="detailproduct/" method="post">
                        <input type="hidden" name="kodebarang" value="<?= $item['kd_barang']; ?>">
                        <button class="button-product">
                            <div class="box">
                                <div class="img">
                                    <img src="../img/<?= $item['gambar_barang']; ?>" alt="">
                                </div>
                                <div class="shop-content">
                                    <h3><?= $item['nama_barang']; ?></h3>
                                    <p>Rp. <?= number_format($item['harga_barang'], 0, '', '.') ?></p>
                                </div>
                            </div>
                        </button>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>



    <footer class="footer" id="contact">
        <div class="blur">
            <div class="box-container">
                <div class="mainBox">
                    <h3>Contact Info</h3>
                    <a href="https://wa.me/089505699702?text=Bang%20beli%20bang" target="_blank"> <i class="fas fa-phone"></i>089505699702</a>
                    <a href="mailto:fadlurrahmanfaiq@gmail.com"> <i class="fas fa-envelope"></i>fadlurrahmanfaiq@gmail.com</a>
                </div>
                <div class="logo-box">
                    <a href="../../projekRPL/" class="logo"><img src="../img/LOGOTT.svg" alt=""></a>
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