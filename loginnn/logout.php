<?php
session_start();      // Wajib ada
session_unset();      // Bersihkan variabel
session_destroy();    // Hancurkan session

header("Location: login.php"); // Pastikan file login.php ada di folder yang sama
exit();
?>