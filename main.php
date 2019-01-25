<?php

session_start();
if (isset($_SESSION['UserGUID']) && $_SESSION['loggedin'] == true) {
    
    header('Location: Dashboard.php');
    
} else {
    header('Location: login_page.php');
    exit;
}
?>

<br />

<a href="main_strategy.php">Strategy</a>
<a href="NewStrategy.php">Add New Strategy</a>
<a href="main_lessonlearn.php">Lesson Learn</a>
<a href="NewLessonLearn.php">Add Lesson Learn</a>
<a href="main_premarket.php">Pre-Market</a>
<a href="ViewTrades.php">Trades</a>
<a href="NewTrade.php">Add New Trades</a>