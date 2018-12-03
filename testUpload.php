<?php

include './cloudinary/Helpers.php';
include './cloudinary/Cloudinary.php';
include './cloudinary/Uploader.php';
include './cloudinary/Api.php';
include './cloudinary/Error.php';

session_start();
if (isset($_SESSION['UserGUID']) && $_SESSION['loggedin'] == true) {
    echo 'welcome ' . $_SESSION['name'];
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
<a href="main_trades.php">Trades</a>
<a href="NewTrade.php">Add New Trades</a>


<script type="text/javascript" src="./vendors/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="./cloudinary/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="./cloudinary/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="./cloudinary/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="./cloudinary/js/jquery.cloudinary.js"></script>


<?php 

\Cloudinary::config(array( 
		  "cloud_name" => "tradingjournal", 
		  "api_key" => "164457864928417", 
		  "api_secret" => "WhfvkEl8xD9zbVdo-jidQsTlTUc" 
		));

echo  cloudinary_js_config(); ?>
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   