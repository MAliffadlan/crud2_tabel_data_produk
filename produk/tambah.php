<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Form Tambah Produk Baru</h3>
                </div>
                <div class="card-body">
                    <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori_id" required>
                                <option value="">- Pilih Kategori -</option>
                                <?php
                                include "../koneksi.php"; // Path '../' sekarang BENAR
                                $query_kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                                while ($kat = mysqli_fetch_assoc($query_kategori)) {
                                    echo "<option value='" . $kat['id_kategori'] . "'>" . htmlspecialchars($kat['nama_kategori']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga" placeholder="Contoh: 50000" required>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                            <div class="form-text">Maks. 2MB, format: JPG, JPEG, PNG, GIF</div>
                        </div>

                        <hr>
                        <div class="text-end">
                            <a href="../index.php" class="btn btn-secondary">Batal</a> <button type="submit" class="btn btn-primary">Simpan Produk</button>
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