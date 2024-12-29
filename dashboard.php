<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: landing_page.php");
    exit;
}

include_once("koneksi.php");


// $result = mysqli_query($con, "select * from mahasiswa");
$role = $_SESSION['role'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="src/style/index-styles.css ">
    <style>

    </style>
</head>

<body>

    <div class="container mt-10">

        <div class="row" id="destinasi-list">
            <?php
            // Query untuk mengambil data dari tabel 'destinasi'
            $query = "SELECT * FROM destinasi";
            $result = mysqli_query($con, $query);

            // Loop melalui setiap baris data
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="col-md-4 mt-10">
                    <div class="card mb-4 shadow-sm">
                        <div class="image-container">
                            <img src="<?php echo htmlspecialchars($row['gambar']); ?>"
                                class="card-img-top"
                                alt="<?php echo htmlspecialchars($row['nama_destinasi']); ?>">
                            <div class="alt-text"><?php echo htmlspecialchars($row['nama_destinasi']); ?></div>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title"><?php echo htmlspecialchars($row['nama_destinasi']); ?></h3>

                            <a href="detail_destinasi.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Lihat Destinasi</a>

                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <!-- Menambahkan d-flex untuk menjadikan tombol sejajar -->
                                <div class="d-flex justify-content-end mt-2">
                                    <form action="backend/hapus_destinasi.php" method="POST" class="mr-2">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                    <a href="tambah.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <script src="src/script/index-script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>