<?php

session_start();
if (isset($_SESSION['UserGUID']) && $_SESSION['loggedin'] == true) {
    echo $_SESSION['username'] . " logout successfully";
    session_destroy();
    header('Location: login_page.php');
} else {
    header('Location: login_page.php');
    exit;
}
?>