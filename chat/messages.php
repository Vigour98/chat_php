<?php 
$title="Your messages";
include_once("Vichat.php");
include_once("header.php");
$username = $_SESSION['username'];
$posts = new ViChat();
?>

<script type="text/javascript">
$(document).ready(function()
{ 
 var username = $('.gUsName').html();
 var receiver = $('#receiver').val(); 
 
 two_by_two(username);
 showMessages(username,receiver);
 
 $('#inboxMe').submit(function(e)
 {
  event.preventDefault();		
  $(this).ajaxSubmit(
  {
   dataType: "json",
   success:function(response) 
   {
	if(!response.error)
	  {	 
       $('#message').val('');  
	   showMessages(username,receiver);
	  }
	else if(response.error)
		  {
		   $('#PersonalMsgs').html(response);
		   
		  }
    }
   })
 }); 

 function two_by_two(username){
  var data="mode="+"top_msgs"+"&username="+username;
  $.ajax({
    url:"ajax_to_php.php",
    data:data,
    method:"POST",
    success:function(response){
      $('.all_messages_cover').html(response);
    }
  });
} 

function showMessages(username,receiver){ 	
 var data="mode="+"showPersonalMsgs"+"&receiver="+receiver+"&username="+username;  
 $.ajax({
		 url:"ajax_to_php.php",
		 data: data,
		 method:"POST",
		 success:function(response){		    
     	  $('#PersonalMsgs').html(response);			  
		     }
	    });
}

	
});//the end of the ready function
</script>
<div class='gUsName'><?php echo $username ?></div>

<div class="the_page">

<div class="home_contents">
<div class="msg_header_msgs">  

<div class='all_messages_cover'></div>

<div class="two_by_two">
<?php

if($_GET['friend'] =="null"){  
  $pic = 'user5.jpg';
  $receiver = 'Friend';
  include_once('chat_header.php');
  ?> <div class='when_msg_null'>((?)) Your messages will appear here ((?))</div> <?php
}else{
  $receiver=$_GET['friend'];
  $pic = $posts->PostPic($receiver);
  include_once('chat_header.php');
?>

<div class="msg_height">
<div id="PersonalMsgs" class="PersonalMsgs"></div>
</div>

<form class="inboxMe" id="inboxMe" method="post" action="ajax_to_php.php">
<textarea type="text"name="message" id="message" cols="30" rows="3" class="type_msg" placeholder="Type a message to <?php echo $receiver ?>"  required ></textarea>
<input type="hidden" name="username" id="username"   value="<?php echo $username ?>" />
<input type="hidden" name="receiver" id="receiver" value="<?php echo $receiver ?>" />  
<input type="hidden" name="mode"  value="sendingInbox" />  
<input type="submit" name="submit"   class="post_submit msg_send" value="Send" />				
</form> 

<?php } ?>

     </div>     
   </div>
 </div>
</div>