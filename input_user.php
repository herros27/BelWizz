<?php
session_start(); // Pastikan session hanya dimulai sekali
include "koneksi.php";

if (!empty($_POST['honeypot'])) {
    die('You are a bot');
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data dari form
        $id_user = mysqli_real_escape_string($con, $_POST['id_user']);
        $nama = mysqli_real_escape_string($con, $_POST['nama']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $confirmPass = mysqli_real_escape_string($con, $_POST['confirmPass']);
        $role = mysqli_real_escape_string($con, $_POST['role']);

        // Validasi input
        $errors = [];

        if (empty($id_user)) {
            $errors[] = "Username Harus Di Isi.";
        }

        if (empty($nama)) {
            $errors[] = "Nama Lengkap Harus Di Isi.";
        }

        if (empty($email)) {
            $errors[] = "Email Harus Di Isi.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format Email Tidak Valid.";
        }

        if (empty($password)) {
            $errors[] = "Password Harus Di Isi.";
        } elseif ($password !== $confirmPass) {
            $errors[] = "Password Dan Konfirmasi Password tidak sama.";
        }

        if (empty($role)) {
            $errors[] = "Role Wajib Di Pilih.";
        }

        // Jika ada error, kembali ke form dengan pesan error
        if (count($errors) > 0) {
            $_SESSION['signup_errors'] = $errors;
            $_SESSION['form_status'] = 'signup';
            header("Location: login.php");
            exit();
        }

        // Periksa apakah username sudah ada di database
        $checkQuery = "SELECT * FROM user WHERE id_user = '$id_user'";
        $result = mysqli_query($con, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['signup_errors'] = ["Username sudah digunakan. Silakan pilih username lain."];
            $_SESSION['form_status'] = 'signup';
            header("Location: login.php");
            exit();
        }

        // Hash password
        $hashedPassword =
            password_hash($password, PASSWORD_BCRYPT);

        // Insert data ke database
        $insertQuery = "INSERT INTO user (id_user, nama, email, password, role) VALUES ('$id_user', '$nama', '$email', '$hashedPassword', '$role')";
        if (mysqli_query($con, $insertQuery)) {
            $_SESSION['signup_success'] = "Pendaftaran berhasil!";
            $_SESSION['form_status'] = 'login';
            header("Location: login.php");
        } else {
            $_SESSION['signup_errors'] = ["Terjadi kesalahan: " . mysqli_error($con)];
            $_SESSION['form_status'] = 'signup';
            header("Location: login.php");
        }
        mysqli_close($con);
    }
}
