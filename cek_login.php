<?php
if (!empty($_POST['honeypot'])) {
    die('You are a bot');
} else {
    include "koneksi.php";

    // Ambil input dari form
    $id_user = $_POST['id_user'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data user berdasarkan id_user
    $sql = "SELECT * FROM user WHERE id_user = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $r = $result->fetch_assoc();

        // Verifikasi password menggunakan password_verify()
        if (password_verify($password, $r['password'])) {
            session_start();
            $_SESSION["login"] = true;
            $_SESSION['iduser'] = $r['id_user'];
            $_SESSION['passuser'] = $r['password'];
            $_SESSION['role'] = $r['role'];

            header('location:index.php');
            exit;
        } else {
            // Password tidak cocok
            session_start();
            $_SESSION['error'] = "Login gagal! Coba lagi.";
            $_SESSION['form_status'] = 'login';
            header('location:login.php');
            exit;
        }
    } else {
        // ID user tidak ditemukan
        session_start();
        $_SESSION['error'] = "Login gagal! Coba lagi.";
        $_SESSION['form_status'] = 'login';
        header('location:login.php');
        exit;
    }
}
