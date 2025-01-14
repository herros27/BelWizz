<?php
session_start();
include_once("../koneksi.php");

// Periksa apakah pengguna adalah admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Periksa apakah ID sudah dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Ambil path gambar dari database berdasarkan ID
    $queryGetImage = "SELECT gambar FROM destinasi WHERE id = ?";
    $stmtGetImage = mysqli_prepare($con, $queryGetImage);
    mysqli_stmt_bind_param($stmtGetImage, "i", $id);
    mysqli_stmt_execute($stmtGetImage);
    mysqli_stmt_bind_result($stmtGetImage, $gambarPath);
    mysqli_stmt_fetch($stmtGetImage);
    mysqli_stmt_close($stmtGetImage);

    $gambarPath = "../" . $gambarPath;
    // Hapus file gambar dari server jika ada
    if (!empty($gambarPath) && file_exists($gambarPath)) {
        // if (!unlink($gambarPath)) {
        //     // echo "Gagal menghapus file gambar dari server.";
        //     header("Location: ../index.php?message=Gagal menghapus file gambar dari server");

        //     exit();
        // }

        // Query untuk menghapus data berdasarkan ID
        $queryDelete = "DELETE FROM destinasi WHERE id = ?";
        $stmtDelete = mysqli_prepare($con, $queryDelete);

        // Bind parameter dan eksekusi query
        mysqli_stmt_bind_param($stmtDelete, "i", $id);
        if (mysqli_stmt_execute($stmtDelete)) {
            // Redirect kembali ke halaman sebelumnya dengan pesan sukses
            header("Location: ../index.php?message=Data berhasil dihapus");
            exit();
        } else {
            header("Location: ../index.php?message=Gagal menghapus data: " . mysqli_error($con));
            // echo "Gagal menghapus data: " . mysqli_error($con);
        }
    }
} else {
    // Redirect jika tidak ada ID yang dikirim
    header("Location: index.php");
    exit();
}
