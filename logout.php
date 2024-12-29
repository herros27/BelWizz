<?php
session_start();
session_destroy();

header("Location: landing_page.php?message=logout");
// echo "Anda telah sukses keluar sistem <b>LOGOUT</b>";
exit();
?>