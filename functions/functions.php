<?php
$conn = mysqli_connect('localhost', 'root', '', 'penjualan_tas');

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function registrasi($data)
{
    global $conn;
    $name = $data["name"];
    $username = strtolower(stripslashes($data["username"]));
    $tgl_lahir = $data["tgl_lahir"];
    $no_telp = $data["no_telp"];
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    $email = $data["email"];
    $role = $data["role"];

    $result = mysqli_query($conn, "SELECT username FROM tbl_users
                WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                    alert('Username yang Anda gunakan sudah terdaftar Mohon coba lagi!');
                </script>";
        return false;
    }

    $cekemail = mysqli_query($conn, "SELECT email FROM tbl_users
                WHERE email = '$email'");

    if (mysqli_fetch_assoc($cekemail)) {
        echo "<script>
                    alert('Email sudah terdaftar!');
                </script>";
        return false;
    }

    if ($password !== $password2) {
        echo "<script>
                    alert('Konfirmasi password tidak sesuai!');
                </script>";
        return false;
    }

    $query = "INSERT INTO tbl_users VALUES
                    ('', '$name', '$username', '$email', '$no_telp', '$tgl_lahir', '$password', '$role')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function createOrder($data)
{
    global $conn;
    $id_user = htmlspecialchars($data['id']);
    $kd_barang = htmlspecialchars($data['kd_barang']);
    $tgl_transaksi = htmlspecialchars($data['tgl_transaksi']);
    $jml_barang = htmlspecialchars($data['jml_barang']);
    $total_harga = htmlspecialchars($data['total_harga']);
    $alamat = htmlspecialchars($data['alamat']);
    $stok_barang = htmlspecialchars($data['stok_barang']);

    if ($jml_barang > $stok_barang) {
        echo "<script>
            alert('Jumlah Barang Tidak Cukup!');
            </script>";
        return false;
    }

    $stok_baru = $stok_barang - $jml_barang;

    $query2 = "UPDATE barang SET stok_barang='$stok_baru' WHERE kd_barang='$kd_barang'";
    mysqli_query($conn, $query2);

    $query = "INSERT INTO transaksi
                    VALUES
                    ('', '$jml_barang', '$total_harga', '$tgl_transaksi',
                    '$alamat', '$id_user', '$kd_barang')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function tgltambah()
{
    date_default_timezone_set('Asia/Jakarta');
    $tgl_transaksi = mktime(date("m"), date("d"), date("Y"));
    echo "" . date("d M Y", $tgl_transaksi) . "";
}

// function cekRole()
// {
//     $users = query("SELECT * FROM tbl_users");
//     $admins = query("SELECT admin.*, tbl_users.*
//     FROM tbl_users
//     INNER JOIN admin ON tbl_users.id_user = admin.id_user");
//     foreach ($users as $user) {
//         $is_admin = false;

//         foreach ($admins as $admin) {
//             if ($admin['id_user'] == $user['id_user']) {
//                 $is_admin = true;
//                 break;
//             }
//         }
//     }
//     // Mencetak peran berdasarkan hasil pengecekan
//     if ($is_admin) {
//         echo "Admin"; // Menampilkan nama pengguna dengan htmlspecialchars untuk keamanan
//     } else {
//         echo "User"; // Menampilkan nama pengguna dengan htmlspecialchars untuk keamanan
//     }
// }

function edit($data)
{
    global $conn;
    $id = $data["id_user"];
    $name = $data["name"];
    $username = strtolower(stripslashes($data["username"]));
    $tgl_lahir = $data["tgl_lahir"];
    $no_telp = $data["no_telp"];
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $email = $data["email"];
    $role = $data["role"];

    // CEK APAKAH USER PILIH GAMBAR BARU ATAU TIDAK


    // query update data
    $query = "UPDATE tbl_users SET
                    name = '$name',
                    username = '$username',
                    tgl_lahir = '$tgl_lahir',
                    no_telp = '$no_telp',
                    password = '$password',
                    email = '$email',
                    role = '$role'
                 WHERE id_user = $id
                    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM tbl_users WHERE id_user = $id");

    return mysqli_affected_rows($conn);
}

function tambahAccount($data)
{
    global $conn;
    $name = $data["name"];
    $username = strtolower(stripslashes($data["username"]));
    $tgl_lahir = $data["tgl_lahir"];
    $no_telp = $data["no_telp"];
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $email = $data["email"];
    $role = $data["role"];


    $query = "INSERT INTO tbl_users VALUES
    ('', '$name', '$username', '$email', '$no_telp', '$tgl_lahir', '$password', '$role')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function editProduct($data)
{
    global $conn;
    $kd_barang = $data["kd_barang"];
    $nama_barang = $data["nama_barang"];
    $harga_barang = $data["harga_barang"];
    $stok_barang = $data["stok_barang"];
    $kategori = $data["kategori"];

    $gambarlama = htmlspecialchars($data["gambarlama"]);

    // CEK APAKAH USER PILIH GAMBAR BARU ATAU TIDAK
    if ($_FILES["gambar_barang"]["error"] === 4) {
        $gambar_barang = $gambarlama;
    } else {
        $gambar_barang = upload();
    }

    // query update data
    $query = "UPDATE barang SET
                    nama_barang = '$nama_barang',
                    harga_barang = '$harga_barang',
                    stok_barang = '$stok_barang',
                    gambar_barang = '$gambar_barang',
                    kategori = '$kategori'
                 WHERE kd_barang = '$kd_barang'
                    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function tambahProduct($data)
{
    global $conn;
    $kd_barang = $data["kd_barang"];
    $nama_barang = $data["nama_barang"];
    $harga_barang = $data["harga_barang"];
    $stok_barang = $data["stok_barang"];
    $kategori = $data["kategori"];
    $id_user = $data["id_user"];

    $gambar_barang = upload();
    if (!$gambar_barang) {
        return false;
    }

    $query = "INSERT INTO barang VALUES
    ('$kd_barang', '$nama_barang', '$harga_barang', '$stok_barang', '$gambar_barang', '$kategori', '$id_user')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
{
    $namafile = $_FILES["gambar_barang"]["name"];
    // $ukuranfile = $_FILES["gambar_barang"]["size"];
    $error = $_FILES["gambar_barang"]["error"];
    $tmpName = $_FILES["gambar_barang"]["tmp_name"];

    // CEK ADA GAMBAR YG DI UPLOAD ATAU TIDAK
    if ($error === 4) {
        echo "<script>
            alert('PILIH GAMBAR TERLEBIH DAHULU!');
            </script>";
        return false;
    }

    // CEK APAKAH YANG DI UPLOAD ADALAH GAMBAR
    $ekstensigambarfix = ["png", "jpg", "jpeg"];
    $ekstensigambar = explode(".", $namafile);
    // strtolower UNTUK MEMAKSI TULIAS (JPG) MENJADI HURUF KECIL SEMUA!
    $ekstensigambar = strtolower(end($ekstensigambar));

    // MENGECEK APAKAH FILE INI (JPG) ATAU BUKAN
    if (!in_array($ekstensigambar, $ekstensigambarfix)) {
        echo "<script>
            alert('FILE YANG ANDA UPLOAD BUKAN GAMBAR!');
            </script>";
        return false;
    }

    // CEK UKURAN GAMBAR TERLALU BESAR
    // if ($ukuranfile > 1048576) {
    //     echo "<script>
    //         alert('UKURAN GAMBAR TERLALU BESAR!');
    //         </script>";
    //     return false;
    // }

    // LOLOS PENGECEKAN, SIAP DIUPLOAD
    // MEMBUAT NAMA FILE BARU
    $namafilebaru = uniqid();
    // HARUS ADA TITIK SEBELOM SAMA DENGAN(=)
    $namafilebaru .= ".";
    $namafilebaru .= "$ekstensigambar";
    move_uploaded_file($tmpName, "../img/" . $namafilebaru);

    return $namafilebaru;
}

function hapusProduct($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM barang WHERE kd_barang = '$id'");

    return mysqli_affected_rows($conn);
}

function editOrder($data)
{
    global $conn;
    $id_transaksi = $data["id_transaksi"];
    $nama_barang = $data["nama_barang"];
    $name = $data["name"];
    $username = $data["username"];
    $email = $data["email"];
    $no_telp = $data["no_telp"];
    $jml_barang = $data["jml_barang"];
    $total_harga = $data["total_harga"];
    $tujuan = $data["tujuan"];




    // query update data
    $query = "UPDATE transaksi SET
                    nama_barang = '$nama_barang',
                    name = '$name',
                    username = '$username',
                    email = '$email',
                    no_telp = '$no_telp',
                    jml_barang = '$jml_barang',
                    total_harga = '$total_harga',
                    tujuan = '$tujuan'
                 WHERE id_transaksi = '$id_transaksi'
                    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusTransaksi($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi = '$id'");

    return mysqli_affected_rows($conn);
}
