<div class="mySignupForm privV">
<form id="signupForm" class="signupForm" method="post" action="<?php echo $page ?>">
<h3 class="h3below">Create a new Account</h3>
<?php 
$username=$firstname=$lastname=$email=$password=$password2=$day=$month=$year=$gender="";
if(isset($_POST['Signup'])){    
    $username = $_POST['username'];  
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname']; 
    $email = $_POST['email']; 	
    $password = $_POST['password']; 
    $password2 = $_POST['password2']; 
    $day = $_POST['day']; 
    $month = $_POST['month']; 
    $year = $_POST['year']; 
    $gender = $_POST['gender']; 

 $errors = $toClass->ValidatePHP($username,$firstname,$lastname,$email,$password,$password2,$day,$month,$year,$gender);
 if(is_array($errors) == true){
	$_SESSION['userid'] =  $errors[0];
	$_SESSION['username'] = $errors[1];	
	header("Location:home.php");
 }else{	
	   echo "<div class='wrong'>";
       echo $errors;
       echo "</div>";	    
       $username=$_POST['username'];
       $firstname=$_POST['firstname'];
       $lastname=$_POST['lastname'];
       $email=$_POST['email'];
       $dob=$_POST['day']; 
       $dob=$_POST['month'];
       $dob=$_POST['year'];
     }
}
?>
<label class="s_label"></label>
<input type="text" name="username" class="sign_input username" value="<?php echo $username ?>" placeholder="Username" required />
<label class="s_label"></label>
<input type="text" name="firstname" class="sign_input firstname"  value="<?php echo $firstname ?>" placeholder="Firstname"required />
<label class="s_label"></label>
<input type="text" name="lastname" class="sign_input lastname" value="<?php echo $lastname ?>" placeholder="Lastname" required />
<label class="s_label"></label>
<input type="password" name="password" class="sign_input password" placeholder="Password" required />
<label class="s_label"></label>
<input type="password" name="password2" class="sign_input password2" placeholder="Confirm Password"required />
<label class="s_label"></label>
<input type="email" name="email" class="sign_input email" value="<?php echo $email ?>" placeholder="Email Address"required />
<label class="s_label"></label>
<div class="dob">
<input type="text" name="day" placeholder="dd" maxlength="2" class="day" value="<?php echo $day ?>" required />
<input type="text" name="month" placeholder="mm" maxlength="2" class="month" value="<?php echo $month ?>" required />
<input type="text" name="year" placeholder="year" maxlength="4" class="year" value="<?php echo $year ?>" required />
</div>
<div class="s_gender">
<input type="radio" value="Male" class="male" id="male" name="gender" checked />
<label for="male" class="genderR">Male</label>
<input type="radio" value="Female" class="female" id="female" name="gender"/>
<label for="female" class="genderR">Female</label>
</div>
<input type="submit" name="Signup" class="signup_submit" value="Join Us"/>
</form>
</div>
