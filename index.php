<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container mt-4 mb-5">
    
    <h1 class="mb-3">Data Produk</h1>

    <a href="produk/tambah.php" class="btn btn-primary">+ Tambah Produk</a>
    <a href="kategori/kelola.php" class="btn btn-secondary">Kelola Kategori</a>

    <div class="row mt-3">
        <div class="col-md-6">
            <form action="index.php" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" 
                           placeholder="Cari nama produk..." 
                           name="search" 
                           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "koneksi.php"; 

                        
                        $search_sql = "";
                        $search_term = "";
                        if (isset($_GET['search']) && !empty($_GET['search'])) {
                            $search_term = mysqli_real_escape_string($conn, $_GET['search']);
                            $search_sql = "WHERE p.nama_produk LIKE '%$search_term%'";
                        }

                        
                        $per_halaman = 5; 
                        $halaman_sekarang = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                        $offset = ($halaman_sekarang - 1) * $per_halaman;

                        $query_total = "SELECT COUNT(*) AS total FROM produk p $search_sql";
                        $result_total = mysqli_query($conn, $query_total);
                        $total_data = mysqli_fetch_assoc($result_total)['total'];
                        $total_halaman = ceil($total_data / $per_halaman);

                        
                        $sql = "SELECT p.*, k.nama_kategori 
                                FROM produk p 
                                JOIN kategori k ON p.kategori_id = k.id_kategori
                                $search_sql
                                ORDER BY p.id_produk DESC
                                LIMIT $per_halaman OFFSET $offset";
                        
                        $query = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($query) > 0) {
                            while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                                <tr>
                                    <td>
                                        <img src="uploads/<?php echo htmlspecialchars($data['gambar']); ?>" 
                                             alt="<?php echo htmlspecialchars($data['nama_produk']); ?>" 
                                             class="product-img img-thumbnail">
                                    </td>
                                    <td><?php echo htmlspecialchars($data['nama_produk']); ?></td>
                                    <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                                    <td><?php echo htmlspecialchars($data['nama_kategori']); ?></td>
                                    <td>
                                        <a href="produk/edit.php?id=<?php echo $data['id_produk']; ?>" 
                                           class="btn btn-warning btn-sm">Edit</a>
                                        <a href="produk/hapus.php?id=<?php echo $data['id_produk']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                                    </td>
                                </tr>
                        <?php
                            } 
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>Tidak ada data produk.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <nav aria-label="Navigasi Halaman" class="mt-3">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($halaman_sekarang <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?halaman=<?php echo $halaman_sekarang - 1; ?>&search=<?php echo urlencode($search_term); ?>">Sebelumnya</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_halaman; $i++) : ?>
                    <li class="page-item <?php echo ($i == $halaman_sekarang) ? 'active' : ''; ?>">
                        <a class="page-link" href="?halaman=<?php echo $i; ?>&search=<?php echo urlencode($search_term); ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo ($halaman_sekarang >= $total_halaman) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?halaman=<?php echo $halaman_sekarang + 1; ?>&search=<?php echo urlencode($search_term); ?>">Berikutnya</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>