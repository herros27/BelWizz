<?php
session_start();

// Mengarahkan ke halaman utama jika sudah login
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

require 'koneksi.php';

// Menentukan status form (login atau signup) berdasarkan parameter URL atau sesi
$form_status = isset($_SESSION['form_status']) ? $_SESSION['form_status'] : 'login';

// Menangani pengalihan form berdasarkan parameter URL
if (isset($_GET['form']) && $_GET['form'] === 'signup') {
    $form_status = 'signup';
    $_SESSION['form_status'] = 'signup';  // Menyimpan status form ke sesi
} else {
    $form_status = 'login';
    $_SESSION['form_status'] = 'login';  // Menyimpan status form ke sesi
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login dan Registrasi</title>

    <!-- <style> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="src/style/auth-styles.css ">
    <style>

    </style>
</head>

<body class="bg-gray-100 h-screen mb-0 align-center ">
    <nav class="bg-white shadow-md w-full fixed top-0 left-0 z-10">
        <div class="mx-auto px-4 py-2 flex justify-between items-center">
            <a href="landing_page.php" class="text-2xl font-bold text-gray-800">BelWizz</a>
        </div>
    </nav>

    <!-- Content Section -->
    <section class="container mx-auto px-45 md:px-8 py-20 md:py-10 mt-80 md:mt-0">

        <div class="main-content">
            <div class="wrapper p-8 shadow-md rounded-lg mt-70 md:mt-20">
                <div class="title-text">
                    <div class="title login">Sign In</div>
                    <div class="title signup">Sign Up</div>
                </div>
                <div class="form-container">
                    <div class="slide-controls">
                        <input type="radio" name="slide" id="login" <?php echo $form_status === 'login' ? 'checked' : ''; ?>>
                        <input type="radio" name="slide" id="signup" <?php echo $form_status === 'signup' ? 'checked' : ''; ?>>
                        <label for="login" class="slide login cursor-pointer">Sign In</label>
                        <label for="signup" class="slide signup cursor-pointer">Sign Up</label>
                        <div class="slider-tab"></div>
                    </div>
                    <div class="form-inner">
                        <form method="post" action="cek_login.php" class="login">
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo "<div id='error-alert' class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>
                                    <strong class='font-bold'>Error!</strong>
                                    <span class='block sm:inline'>{$_SESSION['error']}</span>
                                    <span class='absolute top-0 bottom-0 right-0 px-4 py-3'>
                                        <svg class='fill-current h-6 w-6 text-red-500' role='button' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' onclick='closeAlert()'><title>Close</title><path d='M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z'/></svg>
                                    </span>
                                  </div>";
                                unset($_SESSION['error']);
                            }
                            if (isset($_SESSION['signup_success'])) {
                                echo "<div id='success-alert' class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4' role='alert'>
                                    <strong class='font-bold'>Success!</strong>
                                    <span class='block sm:inline'>{$_SESSION['signup_success']}</span>
                                    <span class='absolute top-0 bottom-0 right-0 px-4 py-3'>
                                        <svg class='fill-current h-6 w-6 text-green-500' role='button' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' onclick='closeAlert()'><title>Close</title><path d='M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z'/></svg>
                                    </span>
                                  </div>";
                                unset($_SESSION['signup_success']);
                            }
                            ?>
                            <div class="field mb-4">
                                <input name="id_user" type="text" class="form-input mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Nama Pengguna atau Email" required>
                                <!-- <input name="id_user" type="text" class="form-input mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Username" required> -->
                            </div>
                            <div class="field password-container">
                                <input name="password" type="password" class="form-input mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Password" required>
                                <span class="toggle-password text-gray-500 cursor-pointer" data-state="hidden">👁️</span>
                            </div>
                            <input type="tex" name="honeypot" style="display: none;">
                            <!-- <div class="pass-link mb-4"><a href="#" class="text-blue-500 hover:underline">Forgot password?</a></div> -->

                            <div class="signup-link mt-4">Belum punya akun? <label for="signup" class="text-blue-500 hover:underline cursor-pointer">Signup now</label></div>

                            <div class="field btn">
                                <div class="btn-layer"></div>
                                <input type="submit" value="SignIn">
                            </div>
                        </form>
                        <form method='post' action="input_user.php" class="signup">
                            <?php
                            if (isset($_SESSION['signup_errors'])) {
                                echo "<div id='error-alert' class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>
                                    <strong class='font-bold'>Error!</strong>";
                                foreach ($_SESSION['signup_errors'] as $error) {
                                    echo "<span class='block sm:inline'>$error</span><br>";
                                }
                                echo "<span class='absolute top-0 bottom-0 right-0 px-4 py-3'>
                                    <svg class='fill-current h-6 w-6 text-red-500' role='button' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' onclick='closeAlert()'>
                                        <title>Close</title>
                                        <path d='M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z'/>
                                    </svg>
                                </span>
                                </div>";
                                unset($_SESSION['signup_errors']);
                            }
                            ?>
                            <div class="field">
                                <input name='id_user' type='text' placeholder="Nama Pengguna" required class='form-input mt-1 block w-full border border-gray-300 rounded-md p-2'>
                            </div>
                            <div class="field">
                                <!-- <label class='block text-gray-700'></label> -->
                                <input name='nama' type='text' placeholder="Nama Lengkap" required class='form-input mt-1 block w-full border border-gray-300 rounded-md p-2'>
                            </div>
                            <div class="field">
                                <input name="email" type="email" placeholder="Alamat Email" required>
                            </div>
                            <div class="field password-container">
                                <input name="password" type="password" class="form-input mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Password" required>
                                <span class="toggle-password text-gray-500">👁️</span>
                            </div>
                            <div class="field password-container">
                                <input name='confirmPass' type="password" placeholder="Konfirmasi password" required>
                                <span class="toggle-password text-gray-500">👁️</span>
                            </div>
                            <div class="field">
                                <select id='role' name='role' class="form-select block w-full mt-1 p-3 border-gray-300shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value='user'>User</option>
                                    <option value='admin'>Admin</option>
                                </select>
                            </div>
                            <input type="text" name="honeypot" style="display: none;">
                            <div class="field btn">
                                <div class="btn-layer"></div>
                                <input type="submit" value="Signup">
                            </div>
                        </form>
                    </div>
                </div>

            </div>

    </section>
    <div class="bg-gray-900 text-center py-8 mb-0">
        <section class="flex items-center justify-center w-full">
            <div class="mx-8 mt-8 mb-8 text-center">
                <h1 class="text-white text-5xl font-bold hover:text-teal-400">Welcome To</h1>
                <h1 class="text-white text-5xl font-bold mb-4 hover:text-violet-800 ">BelWizz</h1>
                <p class="text-white text-xl sm:text-2xl md:text-3xl lg:text-4xl hover:font-semibold  hover:text-fuchsia-400 text-justify leading-tight mx-auto">
                    BelWizz adalah platform terpercaya untuk merencanakan dan memesan perjalanan wisata di Belitung. Temukan destinasi menarik, jadwal trip yang fleksibel, dan pengalaman wisata yang tak terlupakan hanya di BelWizz.
                </p>
            </div>
        </section>
    </div>





    <!-- Footer -->
    <footer class="bg-gray-800 text-white w-full py-2">
        <div class="mx-auto text-center">
            <p>&copy; 2024 BellWizz. Kemas Khairunsyah.</p>
        </div>
    </footer>
    <script>
        const formStatus = "<?php echo $form_status; ?>";
    </script>
    <script>
        const loginText = document.querySelector(".title-text .login");
        const loginForm = document.querySelector("form.login");
        const loginBtn = document.querySelector("label.login");
        const signupBtn = document.querySelector("label.signup");
        const signupLink = document.querySelector("form .signup-link label");
        const wrapper = document.querySelector(".wrapper");

        signupBtn.onclick = () => {

            loginForm.style.marginLeft = "-50%";
            loginText.style.marginLeft = "-50%";
            wrapper.style.maxHeight = "1000px";

        };
        loginBtn.onclick = () => {
            loginForm.style.marginLeft = "0%";
            loginText.style.marginLeft = "0%";
            wrapper.style.maxHeight = "500px";

        };
        signupLink.onclick = () => {
            signupBtn.click();
            return false;
        };

        // Seleksi semua elemen toggle-password
        const togglePasswordButtons = document.querySelectorAll(".toggle-password");

        togglePasswordButtons.forEach((toggle) => {
            toggle.addEventListener("click", () => {
                const container = toggle.closest(".password-container");
                const input = container.querySelector("input"); // Hilangkan type="password" dari selector

                if (input.type === "password") {
                    input.type = "text";
                    toggle.textContent = "🙈";
                    toggle.setAttribute("title", "Hide Password");
                } else {
                    input.type = "password";
                    toggle.textContent = "👁️";
                    toggle.setAttribute("title", "Show Password");
                }
            });
        });

        window.onload = function() {
            // var errorAlert = document.getElementById("errorAlert");
            // if (errorAlert) {
            //     setTimeout(function() {
            //         errorAlert.style.display = "none"; // Sembunyikan elemen
            //     }, 2000); // 3000 ms = 3 detik
            // }

            // Pengecekan status form_status
            if (formStatus === "signup") {
                signupBtn.click(); // Pindahkan ke form Signup

            } else if (formStatus === "login") {
                loginBtn.click(); // Pindahkan ke form Login

            }
        };

        function closeAlert() {
            var errorAlert = document.getElementById('error-alert');
            var successAlert = document.getElementById('success-alert');
            if (errorAlert) {
                errorAlert.style.display = 'none'; // Menyembunyikan elemen
            }
            if (successAlert) {
                successAlert.style.display = 'none'; // Menyembunyikan elemen
            }
        }
    </script>
</body>

</html>