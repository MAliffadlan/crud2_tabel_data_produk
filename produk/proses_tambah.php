<?php
include "../koneksi.php"; 


$nama_produk = $_POST['nama_produk'];
$kategori_id = $_POST['kategori_id'];
$harga       = $_POST['harga'];


$target_dir = "../uploads/"; 
$nama_file  = basename($_FILES["gambar"]["name"]);
$nama_file_unik = uniqid() . "-" . str_replace(' ', '-', $nama_file);
$target_file = $target_dir . $nama_file_unik;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


if ($_FILES["gambar"]["size"] > 2000000) {
    echo "Maaf, ukuran file terlalu besar (Maks 2MB).";
    $uploadOk = 0;
}


if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Maaf, hanya format JPG, JPEG, PNG & GIF yang diizinkan.";
    $uploadOk = 0;
}


if ($uploadOk == 0) {
    echo "Maaf, file kamu gagal di-upload.";

} else {
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        
        
        $sql = "INSERT INTO produk (kategori_id, nama_produk, harga, gambar) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isis", $kategori_id, $nama_produk, $harga, $nama_file_unik);
        
        if (mysqli_stmt_execute($stmt)) {
            
            header("Location: ../index.php"); 
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);

    } else {
        echo "Maaf, terjadi error saat meng-upload file gambar kamu.";
    }
}

mysqli_close($conn);
?>