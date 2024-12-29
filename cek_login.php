<?php
if (!empty($_POST['honeypot'])) {
    die('You are a bot');
} else {
    include "koneksi.php";

    // Ambil input dari form
    $id_user = $_POST['id_user'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data user berdasarkan id_user
    $sql = "SELECT * FROM user WHERE id_user = ? OR email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $id_user, $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    //kalo data nya ada berarrti berhasil login
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Verifikasi password menggunakan password_verify()
        if (password_verify($password, $data['password'])) {
            session_start();
            $_SESSION["login"] = true;
            $_SESSION['iduser'] = $data['id_user'];
            $_SESSION['passuser'] = $data['password'];
            $_SESSION['role'] = $data['role'];

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
