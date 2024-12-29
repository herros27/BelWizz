<?php
// Menghubungkan ke database
include('koneksi.php');
session_start();
// Ambil parameter pencarian dari URL (GET query)
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Jika ada input pencarian
if ($query) {
    // Query pencarian untuk destinasi berdasarkan nama
    $searchQuery = "SELECT * FROM destinasi WHERE nama_destinasi LIKE '%$query%'";
} else {
    // Jika tidak ada pencarian, tampilkan semua destinasi
    $searchQuery = "SELECT * FROM destinasi";
}

// Menjalankan query
$result = mysqli_query($con, $searchQuery);
?>

<div class="row">
    <?php
    // Loop melalui setiap baris data
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <!-- Tampilkan gambar dari database -->
                <img src="<?php echo htmlspecialchars($row['gambar']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nama_destinasi']); ?>">
                <div class="card-body">
                    <!-- Tampilkan nama destinasi -->
                    <h3 class="card-title"><?php echo htmlspecialchars($row['nama_destinasi']); ?></h3>
                    <!-- Tampilkan deskripsi -->

                    <!-- Link menuju detail destinasi -->
                    <a href="detail_destinasi.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Lihat Destinasi</a>
                    <!-- Tombol hapus hanya untuk admin -->
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <form action="backend/hapus_destinasi.php" method="POST" class="mt-2">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>