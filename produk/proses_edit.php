<?php
include "../koneksi.php"; // Path '../' sekarang BENAR

// 1. Ambil data dari POST
$id_produk   = $_POST['id_produk'];
$nama_produk = $_POST['nama_produk'];
$kategori_id = $_POST['kategori_id'];
$harga       = $_POST['harga'];
$gambar_lama = $_POST['gambar_lama'];
$nama_file_baru = $gambar_lama; // Default adalah nama file lama

// 2. Cek apakah user upload gambar BARU
if (!empty($_FILES['gambar']['name'])) {
    // Logika upload file baru
    $target_dir = "../uploads/"; // Path '../' sekarang BENAR
    $nama_file  = basename($_FILES["gambar"]["name"]);
    $nama_file_baru = uniqid() . "-" . str_replace(' ', '-', $nama_file); // Nama file baru yang unik
    $target_file = $target_dir . $nama_file_baru;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($_FILES["gambar"]["size"] > 2000000) {
        die("Maaf, ukuran file baru terlalu besar (Maks 2MB).");
        $uploadOk = 0;
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        die("Maaf, hanya format JPG, JPEG, PNG & GIF yang diizinkan.");
        $uploadOk = 0;
    }
    
    // Jika upload file baru berhasil
    if ($uploadOk == 1 && move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        // Hapus file gambar LAMA
        if (file_exists($target_dir . $gambar_lama)) {
            unlink($target_dir . $gambar_lama);
        }
    } else {
        die("Maaf, terjadi error saat meng-upload file gambar baru.");
    }
}

// 3. Update data ke Database
$sql = "UPDATE produk SET 
            kategori_id = ?, 
            nama_produk = ?, 
            harga = ?, 
            gambar = ? 
        WHERE id_produk = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "isssi", $kategori_id, $nama_produk, $harga, $nama_file_baru, $id_produk);

if (mysqli_stmt_execute($stmt)) {
    // Jika berhasil, redirect ke halaman utama
    header("Location: ../index.php"); // Path '../' sekarang BENAR
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>