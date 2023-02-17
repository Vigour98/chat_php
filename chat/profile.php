<?php 
$title="Associate's Profile";
include_once("Vichat.php");
include_once("header.php");
$username = $_SESSION['username'];
$name = $_GET['name']; 
$posts = new ViChat();
include_once("min_header.php");
?>

<div class="the_page">
<?php
$posts->showProfile($name, $username);
?>

</div>