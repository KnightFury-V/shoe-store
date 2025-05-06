<?php
session_start();
session_destroy();
redirect('login.php'); // Redirect to admin login page after logout
exit();
?>