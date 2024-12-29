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
            $errors[] = "Username is required.";
        }

        if (empty($nama)) {
            $errors[] = "Nama Lengkap is required.";
        }

        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        } elseif ($password !== $confirmPass) {
            $errors[] = "Password and Confirm Password do not match.";
        }

        if (empty($role)) {
            $errors[] = "Role is required.";
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
            $_SESSION['success'] = "Pendaftaran berhasil!";
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
