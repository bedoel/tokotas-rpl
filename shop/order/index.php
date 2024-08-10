<?php

session_start();
require '../../functions/functions.php';

if (!isset($_SESSION["login"])) {
    header("Location: ../../signin/index.php");
    exit;
}

if (!isset($_POST['kd_barang'])) {
    header("Location: ../index.php");
    exit;
}
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

$kd_barang = $_POST["kd_barang"];
$jml_barang = $_POST['jml_barang'];

$items = query("SELECT * FROM barang WHERE kd_barang = '$kd_barang'");

$id = $_SESSION["id"];
// Cek tombol submit sudah di tekan atau blm
if (isset($_POST["orderBarang"])) {
    // cek berhasil atau tidak menambah data
    if (createOrder($_POST) > 0) {

        echo "
                    <script>
                        alert('Data Berhasil Ditambahkan!');
                        document.location.href = '../../index.php';
                    </script>
                ";
    } else {
        echo "
                    <script>
                        alert('Data Gagal Ditambahkan!');
                    </script>
                ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
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
            <!-- MENAMBAH enctype UNTUK MENGELOLA FILE -->

            <div class="detail-container2">
                <div class="detail-img">
                    <img src="../../img/<?= $item['gambar_barang']; ?>" alt="">
                </div>
                <div class="detail">
                    <div class="header-detail2">
                        <h2><?= $item['nama_barang']; ?></h2>
                        <p>Rp<?= number_format($item['harga_barang']); ?></p>
                    </div>

                    <div class="footer-detail2">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                            <input type="hidden" name="kd_barang" id="kd_barang" value="<?= $item['kd_barang']; ?>">
                            <input type="hidden" name="tgl_transaksi" value="<?= tgltambah(); ?>">
                            <input type="hidden" name="stok_barang" value="<?= $item['stok_barang']; ?>">

                            <div class="stok">
                                <p>Stok: <?= $item['stok_barang']; ?></p>
                            </div>

                            <label for="alamat" class="labell"><span class="kurung">|> </span>Alamat Tujuan</label>
                            <div class="input">
                                <input type="text" name="alamat" id="alamat" placeholder="" class="textfield">
                            </div>

                            <label for="jml_barang" class="labell"><span class="kurung">|></span>Jumlah Barang</label>
                            <div class="input">
                                <select name='jml_barang' class='jml_barang' onchange="this.form.submit()">
                                    <?php
                                    for ($x = 1; $x <= 50; $x++) {
                                    ?>
                                        <option <?php if ($jml_barang == $x) echo "selected"; ?> value="<?= $x; ?>"><?= $x; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <?php $total_harga = $item['harga_barang'] * $jml_barang; ?>
                            <input type="hidden" name="total_harga" value="<?= $total_harga; ?>">


                            <div class="coba">
                                <label for="total_harga" class="totalharga"><span class="kurung">|> </span>Total Harga</label>
                                <p>Rp<?= number_format($total_harga); ?></p>
                            </div>
                            <div class="button">
                                <button type="submit" name="orderBarang" id="orderBarang" class="btn-order">Buat Pesanan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
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