<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: views/welcome.php");
} else {
    header("Location: views/auth/login.php");
}
exit;
