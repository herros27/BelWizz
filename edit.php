<?php
session_start();
include_once("koneksi.php");


if (!isset($_SESSION["login"])) {
    header("Location: landing_page.php");
    exit;
}
// Mengambil id dari session
$id = $_SESSION['iduser'];

// Periksa apakah form update sudah disubmit
if (isset($_POST['update'])) {
    // Ambil data dari form
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    // $role = $_POST['role'];

    // Update data ke database
    $query = "UPDATE user SET nama = ?, email = ? WHERE id_user = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $nama, $email, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Data berhasil diupdate!";
        header("Location: index.php");
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($con);
    }
}

// Syntax untuk mengambil data berdasarkan id
$result = mysqli_query($con, "SELECT * FROM user WHERE id_user='$id'");
$user_data = mysqli_fetch_array($result);
$role = $_SESSION['role'];
$nama = $user_data['nama'];
$email = $user_data['email'];
// $role = $user_data['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="bg-blue-600 shadow-md">
        <div class="container mx-auto flex items-center justify-between px-4 py-3">
            <a href="index.php" class="text-white font-bold text-lg">BelWizz</a>
        </div>
    </nav>

    <div class="container mx-auto mt-10">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center mb-6">Edit Data User</h2>
            <form name="update_user" method="post" action="">
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 font-bold mb-2">Nama</label>
                    <input type="text" name="nama" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $nama; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $email; ?>" required>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="flex justify-center">
                    <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>