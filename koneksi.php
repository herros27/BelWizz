<?php
// Variable untuk koneksi ke MySQL
$host = "localhost";
$username = "root";
$password = "";
$databasename = "responsi";

// $host = "sql102.infinityfree.com";
// $username = "if0_37999398";
// $password = "Kemas8935";
// $databasename = "if0_37999398_responsi";


// Syntax untuk koneksi ke MySQL
$con = mysqli_connect($host, $username, $password, $databasename);

// Perkondisian jika gagal konek ke MySQL
if (!$con) {
    echo "Error: " . mysqli_connect_error();
    exit();
}

?>

<!-- // Syntax untuk menambahkan data dummy
$insertDataQuery = "
INSERT INTO destinasi (nama_destinasi, deskripsi, gambar) VALUES
('Pantai Kuta', 'Pantai indah dengan pasir putih dan ombak yang cocok untuk berselancar.', 'https://via.placeholder.com/150'),
('Gunung Bromo', 'Gunung berapi aktif dengan pemandangan matahari terbit yang menakjubkan.', 'https://via.placeholder.com/150'),
('Candi Borobudur', 'Candi Buddha terbesar di dunia yang menjadi warisan budaya dunia.', 'https://via.placeholder.com/150'),
('Danau Toba', 'Danau vulkanik terbesar di dunia dengan pulau Samosir di tengahnya.', 'https://via.placeholder.com/150'),
('Raja Ampat', 'Kepulauan dengan pemandangan bawah laut yang memukau dan beragam terumbu karang.', 'https://via.placeholder.com/150')
";

// Eksekusi query untuk memasukkan data
if (mysqli_query($con, $insertDataQuery)) {
echo "Data berhasil dimasukkan ke tabel 'destinasi'.<br>";
} else {
echo "Error saat memasukkan data: " . mysqli_error($con) . "<br>";
} -->