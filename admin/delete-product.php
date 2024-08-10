<?php
// SYNTAKS SESSION
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../index.php");
    exit;
}
if ($_SESSION["role"] !== "Admin") {
    header("Location: ../index.php");
    exit;
}

require '../functions/functions.php';

$id = $_GET["id"];

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
