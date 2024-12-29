<?php
if (isset($_GET['message']) && $_GET['message'] == 'logout') {
  echo "<div id='logoutAlert' class='logout-alert'>
            Anda telah sukses keluar sistem <b>LOGOUT</b>
          </div>";
}
?>

<!-- CSS untuk menampilkan pesan logout di bagian atas -->
<style>
  .logout-alert {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background-color: #4CAF50;
    /* Warna latar belakang hijau */
    color: white;
    text-align: center;
    padding: 10px;
    font-size: 16px;
    z-index: 9999;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .card {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  }

  .card:hover {
    transform: translateY(-5px);
    transition: transform 0.3s;

  }

  .card {
    position: relative;
    /* Untuk memastikan elemen card memiliki posisi yang relatif */
    overflow: hidden;
    /* Mencegah gambar keluar dari batas card */
  }

  .image-container {
    overflow: hidden;
    /* Untuk membatasi gambar agar tidak keluar */
  }

  .image {
    width: 100%;
    /* Pastikan gambar memenuhi lebar kontainer */
    height: 200px;
    /* Atur tinggi gambar */
    object-fit: cover;
    /* Agar gambar tidak terdistorsi */
    transition: transform 0.3s ease-in-out;
    /* Untuk efek transisi saat zoom */
  }

  .card:hover .image {
    transform: scale(1.2);
    /* Efek zoom ketika card dihover */
  }
</style>

<script>
  window.onload = function() {
    var logoutAlert = document.getElementById('logoutAlert');
    if (logoutAlert) {
      setTimeout(function() {
        logoutAlert.style.display = 'none'; // Sembunyikan alert setelah 3 detik
        window.location.href = 'landing_page.php'; // Arahkan ke landing_page.php setelah alert hilang
      }, 3000); // Waktu tampil alert (dalam milidetik)
    }
  };
</script>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page - Wisata</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-2 flex justify-between items-center">
      <a href="#" class="text-2xl font-bold text-gray-800">BelWizz</a>
      <div>
        <a href="login.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-cover bg-center h-screen" style="background-image: url('https://www.belitungtours.com/asap/assets/asap/pages/setting/artikel/images/5/190917221110_rent-car-belitung_2.jpg');">
    <div class="flex items-center justify-center h-full bg-gray-900 bg-opacity-50">
      <div class="text-center text-white">
        <h1 class="text-5xl font-bold mb-4">Selamat Datang di BellWizz</h1>
        <p class="text-xl mb-8">Temukan destinasi wisata terbaik di Belitung</p>
        <a href="login.php" class="bg-blue-500 text-white px-6 py-3 rounded-full hover:bg-blue-600">Mulai Sekarang</a>
      </div>
    </div>
  </section>

  <!-- Content Section -->
  <section class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-8">Destinasi Populer</h2>
    <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Card 1 -->
      <div class="card bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="image-container">
          <img src="src/Pulau-Lengkuas.jpg" alt="Pulau-Lengkuas" class="image">
        </div>
        <div class="p-4">
          <h3 class="text-xl font-bold mb-2">Pulau Lengkuas</h3>
          <p class="text-gray-700">Pulau Lengkuas memiliki daya tarik tersendiri salah satunya adalah keberadaan sebuah mercusuar peninggalan Belanda yang masih berdiri kokoh meskipun telah berusia lebih dari satu abad..</p>
        </div>
      </div>
      <!-- Card 2 -->
      <!-- <div class="card bg-white rounded-lg shadow-lg overflow-hidden">
        <img src="src/pantai-tanjung-tinggi-belitung_2.jpg" alt="Tanjung Tinggi" class="w-full h-48 object-cover">
        <div class="p-4">
          <h3 class="text-xl font-bold mb-2"></h3>
          <p class="text-gray-700"></p>
        </div>
      </div> -->
      <div class="card bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="image-container">
          <img src="src/pantai-tanjung-tinggi-belitung_2.jpg" alt="Tanjung Tinggi" class="image">
        </div>
        <div class="p-4">
          <h3 class="text-xl font-bold mb-2">Pantai Tanjug Tinggi</h3>
          <p class="text-gray-700">Pantai Tanjung Tinggi merupakan salah satu tempat wisata di pulau Belitung. Letaknya tidak jauh dari Pantai Tanjung Kelayang dan berjarak sekitar 31 km dari kota Tanjung Pandan. Pantai ini merupakan salaah satu tempat lokasi syuting film laskar pelangi.</p>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="card bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="image-container">
          <img src="src/batu-bedil.jpg" alt="Batu Bedil" class="image">
        </div>
        <div class="p-4">
          <h3 class="text-xl font-bold mb-2">Batu Bedil Trias Granite Rock</h3>
          <p class="text-gray-700">Batu Bedil Trias Granite Rock adalah salah satu geosite di Belitong Geopark yang memiliki keindahan alam yang luar biasa. Geosite ini terletak di Desa Sungai Padang, Kecamatan Sijuk, Belitung.</p>
        </div>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-4">
    <div class="container mx-auto text-center">
      <p>&copy; 2024 BellWizz. Kemas Khairunsyah.</p>
    </div>
  </footer>

</body>

</html>