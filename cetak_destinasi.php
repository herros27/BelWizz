<?php
include 'koneksi.php';
$destinasi = mysqli_query($con, "SELECT * FROM destinasi");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Daftar Destinasi Wisata</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body class="container mt-5">
    <h2 class="font-weight-bold text-center mb-4">DAFTAR DESTINASI WISATA</h2>



    <table class="table table-bordered">
        <thead class="table-info">
            <tr>
                <th>NAMA DESTINASI</th>
                <th>DESKRIPSI</th>
                <th>GAMBAR</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($destinasi)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nama_destinasi']); ?></td>
                    <td><?php echo html_entity_decode($row['deskripsi']); ?></td>
                    <td class="text-center">
                        <?php if ($row['gambar'] && file_exists($row['gambar'])): ?>
                            <img src="<?php echo htmlspecialchars($row['gambar']); ?>" class="img-fluid" style="max-width: 100px;">
                        <?php else: ?>
                            <span class="text-muted">Tidak Ada Gambar</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>

    </table>
    <div class="d-flex justify-content-end mb-3">
        <a href="generate_pdf.php" class="btn btn-primary">Download PDF</a>
    </div>
</body>

</html>