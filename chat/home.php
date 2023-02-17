<?php 
$title="ViChat home page";
include_once("header.php");
include_once("Vichat.php");
$username = $_SESSION['username'];
$home=new Vichat();
?>

<style>
.cam_ico{
    display:flex;
    justify-content:center;
	align-items:center;    
    border-radius:50%;
    width:50px;
	height:50px;	
	box-shadow:0px 0px 5px 5px black;
	cursor:pointer;
	margin-right:20px;
	margin-top:5px;	
	transition:all 0.5s linear;
    background: linear-gradient(to bottom, black, rgb(206, 114, 9));; 
	border:5px solid black;
	padding:5px;   
}
.cam_ico:hover{
	transition:all 0.5s linear;
	box-shadow: 0px 0px 5px 5px rgb(206, 114, 9);	
	transform:rotate(360deg);
}

.media{	
    background-image:url("icons/camera.png");	
	background-size:cover;
	background-repeat:no-repeat;
    border-radius:50%;
	display:flex;
    justify-content:center;
	align-items:center;
	width:50px;
	height:50px;
    overflow:hidden;    
}
.mediaPic{
    height:120px;    
}

@media screen and (max-width: 1100px){
	.cam_ico{
		width:70px;
	    height:70px;
		margin-right:15px;
	}

}
</style>	
<script type="text/javascript">


$(document).ready(function(){	

 showComments();      

 $('#parentPostForm').submit(function(e){
  event.preventDefault();   
  $(this).ajaxSubmit({
   dataType: "json",
   success:function(response){
	if(!response.error){	   
	   location.reload();		    			   
	   showComments();
	   }
     },
   error:function(response){
		 alert(response.error);
	    }	
     });   
 }); 

});//the end of the ready function

function showComments(){
 var data="mode="+"showParentPosts";
 $.ajax({
		 url:"ajax_to_php.php",
		 data: data,	
		 method:"POST",
		 success:function(response){
		  $('#showParentPosts').html(response);
		  }
	    });
} 
 
</script>

<div class="the_page">
<?php include_once("user_header.php"); ?>

<div class="side_and_home">

<div class="home_contentsH">

   <form method="post" class="parentPostForm" id="parentPostForm" action="ajax_to_php.php" enctype='multipart/form-data'>
   <div class='cam_ico'>  
                        <div class='media'><input type='file' class='mediaPic' name='media' /></div>
                  </div>
   <textarea type="text"name="p_post" id="p_post"  class="p_post" placeholder="Send a post"> </textarea>
   <input type="hidden" name="u_name" id="u_name"   value="<?php echo $username ?>" />
   <input type="hidden" name="commentId" id="commentId" value="0" />
   <input type="hidden" name="mode" value="sendParentPost" />
   <input type="submit" name="submit" id="submit" class="post_submit"  value="POST" />				
   </form>	
   
<div id="showParentPosts" class="showParentPosts" ></div>

</div><!-- end of .home_contentsH -->

<div class="side_bar">
<?php 
$query = "select  gender, propic from chat_members where username='$username'";
$result = $home->theQuery($query);
$row = mysqli_fetch_row($result);
$pic = $home->checkProfile($row[1],$row[0])
?>
<div class="user_the_propic">
   <div class="my_prof_pic">
	   <img src='propics/<?php echo $pic ?>' >  
   </div>	
   <div class="user_the_name">
	   <?php echo $username ?>
   </div>	   
</div> 	      

 <ul class="home_thList">
    <li>My Profile</li> 
    <li>Search People</li>		
	<li>Settings and Privacy</li>
  </ul>	
  
  
</div><!-- end of .side_bar -->	

</div><!-- end of .side_and_home -->
</div><!-- end of .the_page -->