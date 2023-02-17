<?php
$title="Welcome into ViChat";
include_once("header.php");
require_once("Vichat.php");
$toClass = new Vichat();
$page="welcome.php";
?>
<style>
#logsign{	
	background:radial-gradient(rgb(226, 236, 236),rgb(206, 114, 9));	
}
</style>
<script type="text/javascript">
  $(document).ready(function(){
  $(document).on('click', '.login_submit', function(){
    $(this).css('border','4px solid black');
  });
  $(document).on('click', '.signup_submit', function(){
    $(this).css('border','4px solid black');
  });

  });

</script>
<div id="logsign" class="logsign">

<div class="weHead"><h1>KONET</h1></div>

<div class="anLogSign">
    <div class="anLog clkAn">LOGIN</div>
    <div class="anSign"><a href="welcom.php">SIGNUP</a></div>
</div>

<div class="side_logS">


<div class="myLoginForm ">
 
<form class="loginForm" method="post" action="welcome.php">
<h3 class="h3below">Enter Login details below</h3> 
<?php
$email=$password="";
if(isset($_POST['login'])){  
  $errors = $toClass->login($_POST['email'],$_POST['password']);
  echo "<div class='wrong'>";
  echo $errors;
  echo "</div>";
}
?>
<input type="email" name="email" class="log_input" value="<?php echo $email ?>" placeholder="Email Address" required />
<input type="password" name="password" class="log_input" value="<?php echo $password ?>" placeholder="Password"required />
<input type="submit" value="LOGIN" name="login" class="login_submit"/>
<div class="fgt_pword">Forgot password?</div>
</form>
</div>

<div class="welcomeStatement">
<p><span class="bigW">W</span>elcome to KONET! It is a world class platform that gets you
connected to the world.Do you want GREATNESS? Join us and share your great ideas with
like minded people only at KONET!!</p>
</div>

<?php
include_once("signup.php");
?>

</div>
<?php include_once("footer.php"); ?>
</div>

