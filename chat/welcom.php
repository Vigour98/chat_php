<?php
$title="Welcome into ViChat";
include_once("header.php");
require_once("Vichat.php"); 
$toClass = new Vichat();// used to access methods in a class
$page="welcom.php";
?>
<style>
#logsign{	
	background:radial-gradient(rgb(226, 236, 236),rgb(206, 114, 9));
}

.privV{
    display:block;    
    display:flex;
    justify-content:center;
}
</style>
<script type="text/javascript">
  $(document).ready(function(){
  
  $(document).on('click', '.signup_submit', function(){
    $(this).css('border','4px solid black');
  });

  });

</script>
<div id="logsign" class="logsign">

<div class="weHead"><h1>KONET</h1></div>

<div class="anLogSign">
    <div class="anSign"><a href="welcome.php">LOGIN</a></div>
    <div class="anLog clkAn">SIGNUP</div>
</div>

<div class="side_logS">

<?php include_once("signup.php"); ?>

</div>
<?php include_once("footer.php"); ?>
</div>
