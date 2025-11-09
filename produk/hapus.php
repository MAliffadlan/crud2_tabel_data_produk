<?php
include "../koneksi.php"; 

$id_produk = $_GET['id'];
$target_dir = "../uploads/"; 


$query_gambar = mysqli_query($conn, "SELECT gambar FROM produk WHERE id_produk = $id_produk");
$data = mysqli_fetch_assoc($query_gambar);
$nama_file_gambar = $data['gambar'];


$sql = "DELETE FROM produk WHERE id_produk = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_produk);

if (mysqli_stmt_execute($stmt)) {
    
    if (file_exists($target_dir . $nama_file_gambar) && !empty($nama_file_gambar)) {
        unlink($target_dir . $nama_file_gambar);
    }
    
    
    header("Location: ../index.php"); 
    exit();

} else {
    echo "Error saat menghapus data: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>