<style>
   .my_own_username{
      display:none;
   }
</style> 

<script type="text/javascript">
$(document).ready(function(){

var username = $('.my_own_username').html();
newPosts(username);
function newPosts(username)
 {  
 var data ="mode="+"newPosts"+"&username="+username+"&table="+"post";

 $.ajax({
		 url:"ajax_to_php.php",
		 data: data,	
		 method:"POST",
		 success:function(response){
		  $('.noti').html(response);
		  }
	    });
} 
setInterval(function(){newPosts(username)}, 1000);

function newMsgs(username)
 {  
 var data =" mode="+"newParentMessages"+"&user="+username+"&table="+"chat_messages";
 $.ajax({
		 url:"ajax_to_php.php",
		 data: data,	
		 method:"POST",
		 success:function(response){
		  $('.noti2').html(response);      
		  }
	    });
}
setInterval(function(){newMsgs(username)}, 1000);

function newGrpMsgs(username)
 {  
  var data =" mode="+"newGroupMessages"+"&username="+username+"&table="+"group_messages";
  $.ajax({
		 url:"ajax_to_php.php",
		 data: data,	
		 method:"POST",
		 success:function(response){
		  $('.noti3').html(response);      
		  }
	    });
}
setInterval(function(){newGrpMsgs(username)}, 1000);


});

</script>   
<div class="my_own_username"><?php echo $_SESSION['username'] ?></div>

<div class="Allheader2">
   <div class="Cname">KONET</div> 
      <div class="main_nav_bar">
          <ul class="main_nav_bar_ul">
          <a href="home.php"><li class="the_link">Home<span class="noti"></span></li></a>
          <a href="friends.php"><li class="the_link">Connects</li></a>
          <a href="messages.php?friend=null"> <li class="the_link">Messages<span class="noti2"></span></li></a>
          <a href="groups.php?gid=null"> <li class="the_link">Groups<span class="noti3">5</span></li></a>
          <a href="groups.php">  <li class="the_link">Alerts</li></a>
          <a href="login.php"> <li class="the_link">Logout</li></a>
         </ul>
    </div>
 </div>
 
 
 