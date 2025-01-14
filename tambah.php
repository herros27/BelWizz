<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php?message=Silakan login terlebih dahulu");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php?message=Anda tidak memiliki akses ke halaman ini");
    exit;
}
include_once("koneksi.php");

// Inisialisasi variabel
$isEdit = isset($_GET['id']);
$errors = [];
$destinasi = null;
$target_dir = "userUploads/";
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

// Ambil data jika dalam mode edit
if ($isEdit) {
    $id = intval($_GET['id']);
    $result = mysqli_query($con, "SELECT * FROM destinasi WHERE id = $id");
    $destinasi = mysqli_fetch_assoc($result);


    if (!$destinasi) {
        header("Location: index.php?error=Data tidak ditemukan");
        exit;
    }
}


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_destinasi = mysqli_real_escape_string($con, $_POST['nama_destinasi']);
    $deskripsi = mysqli_real_escape_string($con, $_POST['deskripsi']);
    $id = intval($_POST['id'] ?? 0);

    // Validasi input
    if (empty($nama_destinasi)) {
        $errors['nama_destinasi'] = "Nama destinasi tidak boleh kosong.";
    }

    if (empty($deskripsi)) {
        $errors['deskripsi'] = "Deskripsi tidak boleh kosong.";
    }


    // Menangani unggahan gambar
    if ($isEdit) {
        $gambarUrl = $destinasi['gambar']; // Untuk mode edit, gunakan gambar lama jika tidak ada unggahan baru
    } else {
        $gambarUrl = ''; // Untuk mode tambah, gambar wajib diunggah
    }

    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == 0) {
        $target_file = $target_dir . time() . '_' . basename($_FILES["gambar"]["name"]); // Tambahkan timestamp untuk menghindari duplikasi
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi file gambar
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check === false) {
            $errors['gambar'] = "File yang diunggah bukan gambar.";
        } elseif (!in_array($imageFileType, $allowed_types)) {
            $errors['gambar'] = "Hanya format JPG, JPEG, PNG, dan GIF yang diizinkan.";
        } elseif ($_FILES["gambar"]["size"] > 10485760) {
            $errors['gambar'] = "Ukuran file terlalu besar. Maksimal 10 MB.";
        }

        // Jika valid, pindahkan file
        if (empty($errors)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $gambarUrl = mysqli_real_escape_string($con, $target_file);
            } else {
                $errors['upload'] = "Terjadi kesalahan saat mengunggah file.";
            }
        }
    } else {
        // Validasi untuk kasus gambar kosong
        if (empty($gambarUrl)) {
            $errors['gambar'] = "Gambar wajib diunggah.";
        }
    }


    // Simpan atau update data jika tidak ada kesalahan
    if (empty($errors)) {
        if ($isEdit && $id) {
            if (
                $nama_destinasi === $destinasi['nama_destinasi'] &&
                $deskripsi === $destinasi['deskripsi'] &&
                $gambarUrl === $destinasi['gambar']
            ) {
                // Tidak ada perubahan, kembalikan ke halaman sebelumnya dengan pesan
                header("Location: index.php?message=Tidak ada perubahan yang disimpan");
                exit;
            }

            // Query update hanya dijalankan jika ada perubahan
            $query = "UPDATE destinasi SET 
                nama_destinasi = '$nama_destinasi', 
                deskripsi = '$deskripsi', 
                gambar = '$gambarUrl' 
              WHERE id = $id";
        } else {
            // Tambah data
            $query = "INSERT INTO destinasi (nama_destinasi, deskripsi, gambar) 
                      VALUES ('$nama_destinasi', '$deskripsi', '$gambarUrl')";
        }

        if (mysqli_query($con, $query)) {
            header("Location: index.php?message=Data berhasil disimpan");
            exit;
        } else {
            $errors['database'] = "Gagal menyimpan data ke database.";
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
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link href="assets/tinymce/js/tinymce/skins/ui/oxide/content.min.css" rel="stylesheet"> -->

    <script src="https://cdn.tiny.cloud/1/shjneghiz6db6exftf0bdhpkwk0cqtts2wuhdglfdrlqkp57/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <style>
        body {
            background-color: #f7fafc;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            margin: 0px;

            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
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
    <div class="container mx-auto mt-10 p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-4"><?= $isEdit ? 'Edit Destinasi' : 'Tambah Destinasi' ?></h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $destinasi['id'] ?? '' ?>">

            <div class="mb-4">
                <label for="nama_destinasi" class="block text-gray-700">Nama Destinasi</label>
                <input type="text" id="nama_destinasi" name="nama_destinasi"
                    class="w-full p-2 border rounded"
                    value="<?= htmlspecialchars($destinasi['nama_destinasi'] ?? '') ?>">
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                    class="w-full p-2 border rounded"><?= htmlspecialchars($destinasi['deskripsi'] ?? '') ?></textarea>
            </div>

            <div class="mb-4">
                <!-- Preview gambar -->
                <div id="preview-container" class="mt-2">
                    <?php if ($destinasi['gambar'] ?? false): ?>
                        <p class="text-sm text-gray-600 mt-1">Gambar lama:</p>
                        <div class="flex justify-center items-center">
                            <img src="<?= $destinasi['gambar'] ?>" alt="Preview Gambar Lama" class="mt-2 w-100 h-40 md:h-80 object-cover rounded">
                        </div>

                    <?php endif; ?>
                    <p id="preview-teks" class=" hidden text-sm text-gray-600 mt-1">Gambar baru:</p>
                    <div class="flex justify-center items-center">
                        <img id="preview" src="#" alt="Preview Gambar Baru" class="hidden mt-2 w-100 h-40 md:h-80 object-cover rounded">
                    </div>
                </div>
                <label for="gambar" class="block text-gray-700">Upload Gambar</label>
                <input type="file" id="gambar" name="gambar" class="w-full p-2 border rounded" accept="image/*">


                <?php if (!empty($errors)): ?>
                    <div class="mb-4 text-red-500">
                        <?= implode('<br>', $errors) ?>
                    </div>
                <?php endif; ?>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    <?= $isEdit ? 'Update' : 'Tambah' ?>
                </button>
        </form>
    </div>
    <script>
        document.getElementById('gambar').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file yang dipilih
            if (file) {
                const reader = new FileReader(); // Buat FileReader untuk membaca file
                reader.onload = function(e) {
                    // Tampilkan preview gambar
                    const previewTeks = document.getElementById('preview-teks')
                    const preview = document.getElementById('preview');
                    preview.src = e.target.result;
                    previewTeks.classList.remove('hidden');
                    preview.classList.remove('hidden');

                };
                reader.readAsDataURL(file); // Membaca file sebagai Data URL
            }
        });

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