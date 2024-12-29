document.addEventListener("DOMContentLoaded", function () {
  // Elemen untuk konten utama
  const mainContent = document.getElementById("main-content");

  // Fungsi untuk memuat konten
  function loadContent(url) {
    fetch(url)
      .then((response) => response.text())
      .then((data) => {
        // Masukkan konten ke dalam #main-content
        mainContent.innerHTML = data;
      })
      .catch((error) => {
        console.error("Error loading content:", error);
        mainContent.innerHTML = "<p>Error loading page.</p>";
      });
  }

  // Set URL default untuk memuat halaman pertama
  const defaultUrl = "dashboard.php"; // Ganti dengan URL halaman default Anda
  loadContent(defaultUrl);

  // Ambil semua tautan di sidebar
  const links = document.querySelectorAll(".nav-link");

  // Fungsi untuk menandakan link yang aktif
  function setActiveLink(activeUrl) {
    links.forEach((link) => {
      // Menghapus kelas 'active' dari semua link
      link.classList.remove("active");
      // Menambahkan kelas 'active' ke link yang sesuai dengan URL yang aktif
      if (link.getAttribute("href") === activeUrl) {
        link.classList.add("active");
      }
    });
  }

  // Set default active link saat halaman pertama dimuat
  setActiveLink(defaultUrl);

  links.forEach((link) => {
    link.addEventListener("click", function (e) {
      const url = this.getAttribute("href"); // Dapatkan URL dari atribut href

      // Jika tautan adalah logout, biarkan navigasi normal terjadi
      if (url === "logout.php") {
        return; // Tidak menggunakan mekanisme AJAX
      }

      if (url === "cetak_destinasi.php") {
        return;
      }

      if (url === "tambah.php") {
        return;
      }

      e.preventDefault(); // Cegah navigasi default
      loadContent(url); // Muat konten berdasarkan URL
      setActiveLink(url); // Menandakan link yang aktif
    });
  });
});

document.getElementById("search-input").addEventListener("input", function () {
  const query = document.getElementById("search-input").value;

  // Kirim permintaan AJAX hanya jika query tidak kosong
  if (query.trim() !== "") {
    fetch(`search.php?query=${encodeURIComponent(query)}`)
      .then((response) => response.text())
      .then((data) => {
        // Ganti isi elemen dengan ID 'destinasi-list' dengan hasil pencarian
        document.getElementById("destinasi-list").innerHTML = data;
      })
      .catch((error) => console.error("Error:", error));
  } else {
    // Jika input kosong, tampilkan semua destinasi
    fetch("search.php") // Panggil search.php tanpa query untuk menampilkan semua data
      .then((response) => response.text())
      .then((data) => {
        document.getElementById("destinasi-list").innerHTML = data;
      })
      .catch((error) => console.error("Error:", error));
  }
});

document.addEventListener("DOMContentLoaded", function () {
  // Cek apakah ada pesan dari URL
  const urlParams = new URLSearchParams(window.location.search);
  const message = urlParams.get("message");

  if (message) {
    // Buat elemen pesan muncul
    const floatingMessage = document.createElement("div");
    floatingMessage.className = "floating-message";
    if (message === "Data berhasil disimpan") {
      floatingMessage.style.backgroundColor = "#4BDD1FFF";
    } else {
      floatingMessage.style.backgroundColor = "#ff0404";
    }
    floatingMessage.textContent = message;

    // Tambahkan elemen ke body
    document.body.appendChild(floatingMessage);

    // Tampilkan elemen dengan efek
    floatingMessage.style.display = "flex";

    // Hilangkan elemen setelah 3 detik
    setTimeout(() => {
      floatingMessage.style.opacity = "0";
      setTimeout(() => floatingMessage.remove(), 500); // Hapus elemen dari DOM
      window.location.href = "index.php";
    }, 3000);
  }
});
