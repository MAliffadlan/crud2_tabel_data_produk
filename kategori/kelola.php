<?php
include "../koneksi.php"; // Path '../' sekarang BENAR

// Logika untuk TAMBAH kategori
if (isset($_POST['submit_kategori'])) {
    $nama_kategori = $_POST['nama_kategori'];
    
    if (!empty($nama_kategori)) {
        $sql = "INSERT INTO kategori (nama_kategori) VALUES (?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $nama_kategori);
        
        if (mysqli_stmt_execute($stmt)) {
            // Refresh halaman agar data baru muncul
            header("Location: kelola.php");
            exit();
        } else {
            $error = "Gagal menambahkan kategori: " . mysqli_error($conn);
        }
    } else {
        $error = "Nama kategori tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <h1 class="mb-3">Kelola Kategori</h1>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Tambah Kategori Baru</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form action="kelola.php" method="POST">
                        <div class="input-group">
                            <input type="text" class="form-control" 
                                   name="nama_kategori" 
                                   placeholder="Contoh: Aksesoris Komputer" required>
                            <button class="btn btn-success" type="submit" name="submit_kategori">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query_kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                                if (mysqli_num_rows($query_kategori) > 0) {
                                    while ($kat = mysqli_fetch_assoc($query_kategori)) {
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($kat['nama_kategori']); ?></td>
                                        <td>
                                            <a href="hapus.php?id=<?php echo $kat['id_kategori']; ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='2' class='text-center'>Belum ada kategori.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="../index.php" class="btn btn-primary">&laquo; Kembali ke Data Produk</a> </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>