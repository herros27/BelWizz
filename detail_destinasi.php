<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Memanggil file koneksi.php
include_once("koneksi.php");

// Mendapatkan ID dari URL
$id = $_GET['id'];

// Mengambil data destinasi berdasarkan ID
$result = mysqli_query($con, "SELECT * FROM destinasi WHERE id=$id");

if (mysqli_num_rows($result) == 0) {
    echo "Data tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Destinasi</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
    <style>
        body {
            background-color: #f7fafc;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .image-container img {
            max-width: 100%;
            border-radius: 8px;
        }

        .content {
            text-align: left;
        }

        .content h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #2d3748;
        }

        .content p {
            font-size: 1rem;
            color: #4a5568;
            line-height: 1.6;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #3182ce;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <nav class="bg-blue-600 shadow-md">
        <div class="ml-0 md:ml-20 mx-auto flex items-center justify-between px-4 py-3">
            <a href="index.php" class="text-white font-bold text-lg">BelWizz</a>
        </div>
    </nav>
    <div class="container">
        <div class="image-container">
            <img src="<?php echo $data['gambar']; ?>" alt="<?php echo $data['nama_destinasi']; ?>">
        </div>
        <div class="content">
            <h2><?php echo $data['nama_destinasi']; ?></h2>
            <p><?php echo nl2br($data['deskripsi']); ?></p>
            <a href="index.php" class="back-link">Kembali ke Daftar Destinasi</a>
        </div>
    </div>
</body>

</html>