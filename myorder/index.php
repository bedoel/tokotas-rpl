<?php
session_start();
require '../functions/functions.php';

if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}
if (!isset($_SESSION["login"])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_SESSION["id"])) {
    $id_user = $_SESSION["id"];

    $items = query("SELECT transaksi.*, tbl_users.*, barang.*
    FROM transaksi
    INNER JOIN barang ON transaksi.kd_barang = barang.kd_barang
    INNER JOIN tbl_users ON transaksi.id_user = tbl_users.id_user
    WHERE transaksi.id_user = '$id_user'");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
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
            <a href="../index.php" class="logo">
                <img src="../img/LOGOTT.svg" alt="">
                <!-- <h1 class="logoName"> TOKO TAS </h1> -->
            </a>

        </div>

        <nav class="navbar">
            <a href="../../projekRPL/" class="navstyle">home</a>
            <a href="../shop/" class="navstyle">shop</a>
            <!-- <div class="dropdown">
                <button class="dropbtn">Dropdown</button>
                <div class="dropdown-content">
                    <a href="#" class="droplink">Link 1</a>
                    <a href="#" class="droplink">Link 2</a>
                    <a href="#" class="droplink">Link 3</a>
                </div>
            </div> -->
            <a href="../projekRPL/#about" class="navstyle">about</a>
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

    <div class="container-myorder">
        <div class="container-pasca-myorder">
            <div class="header-judul">
                <h1>Pesanan Saya</h1>
            </div>

            <div class="main-myorder">
                <?php foreach ($items as $item) : ?>
                    <div class="order-card">
                        <div class="tampung-card1">
                            <h2><?= $item['nama_barang']; ?><br></h2>
                            <img src="../img/<?= $item['gambar_barang']; ?>" alt="Produk 1" class="produk-gambar">
                            <div class="deskripsi-myorder">
                                <p>Date: <?= $item['tgl_transaksi']; ?></p>
                                <p>Harga: Rp<?= number_format($item['harga_barang']); ?></p>
                                <p>Quantity: <?= $item['jml_barang']; ?></p>
                                <p>Tujuan: <?= $item['tujuan']; ?></p>
                                <p>Status: Sedang diantar</p>
                            </div>
                        </div>
                        <div class="total-order">
                            <p>Total : Rp<?= number_format($item['total_harga']); ?></p>
                        </div>
                        <a href="delete.php?id=<?= $item['id_transaksi']; ?>" onclick="
                                    return confirm('Apakah Anda yakin ingin menghapus?')" class="batal-btn">Batal</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <footer class="footer" id="contact">
        <div class="blur">
            <div class="credit">
                <p class="copy">Copyright &copy; 2023 Fadlur Rahman Fa'iq</p>
            </div>
        </div>
    </footer>

</body>

</html>