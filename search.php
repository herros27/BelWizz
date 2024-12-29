<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/style/index-styles.css ">
    <style>

    </style>
</head>

<body>

    <?php
    // Mulai sesi
    session_start();
    include('koneksi.php');

    // Ambil parameter query dari URL
    $query = isset($_GET['query']) ? $_GET['query'] : '';

    // Pastikan query tidak kosong
    if ($query) {
        // Query pencarian untuk destinasi berdasarkan nama
        $searchQuery = "SELECT * FROM destinasi WHERE nama_destinasi LIKE '%$query%'";
    } else {
        // Jika tidak ada pencarian, tampilkan semua destinasi
        $searchQuery = "SELECT * FROM destinasi";
    }

    // Menjalankan query
    $result = mysqli_query($con, $searchQuery);

    // Memulai output HTML untuk hasil pencarian
    $output = '';

    if (mysqli_num_rows($result) > 0) {
        // Loop melalui setiap baris data dan buat card untuk setiap destinasi
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="image-container"> 
                                <img src="' . htmlspecialchars($row['gambar']) . '" class="card-img-top" alt="' . htmlspecialchars($row['nama_destinasi']) . '">
                                
                            </div>
                            
                            <div class="card-body">
                                <h3 class="card-title">' . htmlspecialchars($row['nama_destinasi']) . '</h3>
                              
                                <a href="detail_destinasi.php?id=' . $row['id'] . '" class="btn btn-primary">Lihat Destinasi</a>';

            // Periksa apakah user adalah admin
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                $output .= '<form action="backend/hapus_destinasi.php" method="POST" class="mt-2">
                            <input type="hidden" name="id" value="' . $row['id'] . '">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>';
            }

            $output .= '</div>
                    </div>
                </div>';
        }
    } else {
        $output = '<p>No results found for your search.</p>';
    }

    // Mengembalikan hasil pencarian sebagai HTML
    echo $output;

    ?>