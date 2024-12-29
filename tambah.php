<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Memanggil file koneksi.php
include_once("koneksi.php");

$errors = []; // Menampung pesan kesalahan
$status = 200; // Default: sukses

if (isset($_POST['Submit'])) {
    // Variable untuk menampung data $_POST yang dikirimkan melalui form
    $nama_destinasi = mysqli_real_escape_string($con, $_POST['nama_destinasi']);
    $deskripsi = mysqli_real_escape_string($con, $_POST['deskripsi']);

    // Menangani unggahan gambar
    $target_dir = "userUploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar diunggah
    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == 0) {
        // Periksa apakah file gambar adalah gambar asli atau palsu
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check === false) {
            $errors['gambar'] = "File yang diunggah bukan gambar.";
        }

        // Periksa apakah file sudah ada
        if (file_exists($target_file)) {
            $errors['gambar'] = "File sudah ada. Silakan ubah nama file Anda.";
        }

        // Periksa ukuran file (maksimal 10 MB)
        if ($_FILES["gambar"]["size"] > 10485760) {
            $errors['gambar'] = "Ukuran file terlalu besar. Maksimal 10 MB.";
        }

        // Perbolehkan format file tertentu
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            $errors['gambar'] = "Hanya format JPG, JPEG, PNG, dan GIF yang diizinkan.";
        }
    } else {
        $errors['gambar'] = "Tidak ada file gambar yang diunggah.";
    }

    // Jika tidak ada kesalahan, lanjutkan proses unggah
    if (empty($errors)) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            // Simpan URL gambar ke database
            $gambarUrl = mysqli_real_escape_string($con, $target_file);
            $result = mysqli_query($con, "INSERT INTO destinasi (nama_destinasi, deskripsi, gambar) VALUES ('$nama_destinasi', '$deskripsi', '$gambarUrl')");

            if ($result) {
                $status = 201; // Created
                header("Location: index.php?message=Data berhasil disimpan");
                exit;
            } else {
                $errors['database'] = "Gagal menyimpan data ke database.";
            }
        } else {
            $errors['upload'] = "Terjadi kesalahan saat mengunggah file.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Destinasi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- <link href="assets/tinymce/js/tinymce/skins/ui/oxide/content.min.css" rel="stylesheet"> -->

    <script src="https://cdn.tiny.cloud/1/shjneghiz6db6exftf0bdhpkwk0cqtts2wuhdglfdrlqkp57/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <style>
        body {
            background-color: #f7fafc;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            margin: 50px;

            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 600px;
            margin: 20px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2d3748;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #3182ce;
            outline: none;
        }

        .form-group input[type="file"] {
            padding: 3px;
        }

        .form-group textarea {
            resize: vertical;
        }

        .form-group button {
            background-color: #3182ce;
            color: white;
            padding: 12px 20px;
            width: 100%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: #2b6cb0;
        }

        .form-group a {
            display: inline-block;
            color: #3182ce;
            text-decoration: none;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }

        .form-group a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            .form-group button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">Tambah Destinasi</h2>
        <a href="index.php" class="text-blue-500 hover:none mb-4 inline-block">Go to Home</a>
        <form action="tambah.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_destinasi">Nama Destinasi</label>
                <input type="text" name="nama_destinasi" id="nama_destinasi">
                <?php if (isset($errors['nama_destinasi'])): ?>
                    <div class="text-red-500 text-sm"><?= $errors['nama_destinasi'] ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"></textarea>
                <?php if (isset($errors['deskripsi'])): ?>
                    <div class="text-red-500 text-sm"><?= $errors['deskripsi'] ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <input type="file" name="gambar" id="gambar">
                <?php if (isset($errors['gambar'])): ?>
                    <div class="text-red-500 text-sm"><?= $errors['gambar'] ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group mt-4">
                <button type="submit" name="Submit">Tambah</button>
            </div>
        </form>
    </div>
    <script>
        tinymce.init({
            selector: 'textarea#deskripsi',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
        });
    </script>
</body>

</html>