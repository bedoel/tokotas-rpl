<?php
// SYNTAKS SESSION
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../index.php");
    exit;
}
if ($_SESSION["role"] !== "Seller") {
    header("Location: ../index.php");
    exit;
}

require '../functions/functions.php';

$id = $_GET["id"];

$product = query("SELECT * FROM barang WHERE kd_barang = '$id'")[0];

$cek = $product['id_user'];
$user = $_SESSION['id'];

if ($cek == $user) {
    if (hapusProduct($id) > 0) {
        echo "
        <script>
            alert('Data Berhasil Dihapus!');
            document.location.href = 'products.php';
        </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Dihapus!');
                document.location.href = 'products.php';
            </script>
        ";
    }
} else {
    echo "
            <script>
                alert('Ini Bukan Content Anda! Anda Tidak Berhak Menghapus Content ini!');
                document.location.href = 'products.php';
            </script>
        ";
}
