<?php
session_start();



if (!isset($_SESSION["login"])) {
    header("Location: landing_page.php?message=Silakan login terlebih dahulu!");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="src/style/index-styles.css ">
    <style>

    </style>
</head>

<body>
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cetak_destinasi.php">Cetak Data Destinasi</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="paket.php">Paket Wisata</a>
            </li> -->
            <?php if ($role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="tambah.php">Tambah Destinasi</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm bg-primary">
        <div class="container">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cetak_destinasi.php">Destinasi Wisata</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="paket.php">Paket Wisata</a>
                    </li> -->
                    <?php if ($role === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="tambah.php">Tambah Destinasi</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>




            <a class="navbar-brand" href="index.php">BelWizz</a>

            <form class="d-flex me-3" id="search-form">
                <input class="form-control me-2 w-100" type="search" id="search-input" placeholder="Search" aria-label="Search">
            </form>

            <a href="edit.php" class="profile d-flex align-items-center">
                <svg width="30" height="30" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 0.875C5.49797 0.875 3.875 2.49797 3.875 4.5C3.875 6.15288 4.98124 7.54738 6.49373 7.98351C5.2997 8.12901 4.27557 8.55134 3.50407 9.31167C2.52216 10.2794 2.02502 11.72 2.02502 13.5999C2.02502 13.8623 2.23769 14.0749 2.50002 14.0749C2.76236 14.0749 2.97502 13.8623 2.97502 13.5999C2.97502 11.8799 3.42786 10.7206 4.17091 9.9883C4.91536 9.25463 6.02674 8.87499 7.49995 8.87499C8.97317 8.87499 10.0846 9.25463 10.8291 9.98831C11.5721 10.7206 12.025 11.8799 12.025 13.5999C12.025 13.8623 12.2376 14.0749 12.5 14.0749C12.7623 14.075 12.975 13.8623 12.975 13.6C12.975 11.72 12.4778 10.2794 11.4959 9.31166C10.7244 8.55135 9.70025 8.12903 8.50625 7.98352C10.0187 7.5474 11.125 6.15289 11.125 4.5C11.125 2.49797 9.50203 0.875 7.5 0.875ZM4.825 4.5C4.825 3.02264 6.02264 1.825 7.5 1.825C8.97736 1.825 10.175 3.02264 10.175 4.5C10.175 5.97736 8.97736 7.175 7.5 7.175C6.02264 7.175 4.825 5.97736 4.825 4.5Z" fill="#FFFFFFFF" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
                <span class="ms-2 text-white"><?= $_SESSION['iduser'] ?></span>
            </a>

        </div>
    </nav>


    <div class="content mt-10">



        <div id="main-content">
            <!-- Konten halaman akan dimuat di sini -->
        </div>

    </div>


    <footer class="footer">
        <p>&copy; 2023 BelWizz. Kemas Khairunsyah.</p>
    </footer>

    <script src="src/script/index-script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>