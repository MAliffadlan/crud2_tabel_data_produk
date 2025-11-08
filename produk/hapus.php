<?php
include "../koneksi.php"; // Path '../' sekarang BENAR

$id_produk = $_GET['id'];
$target_dir = "../uploads/"; // Path '../' sekarang BENAR

// 1. Ambil nama file gambar sebelum data dihapus
$query_gambar = mysqli_query($conn, "SELECT gambar FROM produk WHERE id_produk = $id_produk");
$data = mysqli_fetch_assoc($query_gambar);
$nama_file_gambar = $data['gambar'];

// 2. Hapus data dari database
$sql = "DELETE FROM produk WHERE id_produk = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_produk);

if (mysqli_stmt_execute($stmt)) {
    // 3. Jika data di DB berhasil dihapus, hapus file gambar
    if (file_exists($target_dir . $nama_file_gambar) && !empty($nama_file_gambar)) {
        unlink($target_dir . $nama_file_gambar);
    }
    
    // Redirect kembali ke halaman utama
    header("Location: ../index.php"); // Path '../' sekarang BENAR
    exit();

} else {
    echo "Error saat menghapus data: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>