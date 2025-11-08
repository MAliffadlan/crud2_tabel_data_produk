<?php
include "../koneksi.php"; // Path '../' sekarang BENAR

// Ambil ID dari URL
$id_produk = $_GET['id'];

// Query untuk ambil data produk yang spesifik
$query_data = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id_produk");
$data = mysqli_fetch_assoc($query_data);

if (!$data) {
    die("Data produk tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0">Form Edit Produk</h3>
                </div>
                <div class="card-body">
                    <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                        
                        <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>">
                        <input type="hidden" name="gambar_lama" value="<?php echo $data['gambar']; ?>">

                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" 
                                   value="<?php echo htmlspecialchars($data['nama_produk']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori_id" required>
                                <option value="">- Pilih Kategori -</option>
                                <?php
                                $query_kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                                while ($kat = mysqli_fetch_assoc($query_kategori)) {
                                    $selected = ($kat['id_kategori'] == $data['kategori_id']) ? 'selected' : '';
                                    echo "<option value='" . $kat['id_kategori'] . "' $selected>" . htmlspecialchars($kat['nama_kategori']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga" 
                                   value="<?php echo $data['harga']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Produk</label><br>
                            <img src="../uploads/<?php echo htmlspecialchars($data['gambar']); ?>" width="150" class="img-thumbnail mb-2"> <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            <div class="form-text">Kosongkan jika tidak ingin mengubah gambar.</div>
                        </div>

                        <hr>
                        <div class="text-end">
                            <a href="../index.php" class="btn btn-secondary">Batal</a> <button type="submit" class="btn btn-warning">Update Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>