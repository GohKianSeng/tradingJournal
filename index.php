<?php

session_start();
if (isset($_SESSION['UserGUID']) && $_SESSION['loggedin'] == true) {
    header('Location: main.php');
} else {
    header('Location: login.php');
    exit;
}
?>