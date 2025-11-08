<?php
include "../koneksi.php"; 

$id_kategori = $_GET['id'];


$sql_check = "SELECT COUNT(*) AS total FROM produk WHERE kategori_id = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "i", $id_kategori);
mysqli_stmt_execute($stmt_check);
$result = mysqli_stmt_get_result($stmt_check);
$data = mysqli_fetch_assoc($result);

if ($data['total'] > 0) {
    
    echo "<script>
            alert('Gagal! Kategori ini masih digunakan oleh " . $data['total'] . " produk. Pindahkan produk ke kategori lain terlebih dahulu.');
            window.location.href = 'kelola.php';
          </script>";
    exit();

} else {
    
    $sql_delete = "DELETE FROM kategori WHERE id_kategori = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id_kategori);
    
    if (mysqli_stmt_execute($stmt_delete)) {
        header("Location: kelola.php");
        exit();
    } else {
        echo "Error saat menghapus kategori: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>