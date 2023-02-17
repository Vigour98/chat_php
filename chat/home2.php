<?php
$title="ViChat post comments";
include_once("header.php");
require_once("Vichat.php");
$home = new ViChat();
$username = $_SESSION['username']; 
?> 

<script type="text/javascript">
$(document).ready(function(){

var post_id=$('#p_id').html();

function showReplies(post_id){
 data="mode="+"showReplies"+"&post_id="+post_id;
 $.ajax ({
	     url:"ajax_to_php.php",
         method:"POST",
         data:data,
         success:function(response){
	      $('#replies').html(response);		  
         }		  
        });	
} 
 
showReplies(post_id);
  
$('#commentForm').submit(function(e){

 event.preventDefault();
 var name=$('#name').val(); 
 var id=$('#replyId').val();
 var reply=$('#post_reply').val();
 
 data="mode="+"SendGetReplies"+"&id="+id+"&name="+name+"&reply="+reply+"&post_id="+post_id;
 $.ajax({
	     url:"ajax_to_php.php",
         method:"POST",
         data:data,
	     success:function(response){	  	 
	      $('#replies').html(response);
         }	 
       });     
});
 
$(document).on('click', '.reply', function(){
 $(this).hide();	
 var k = $('#commentForm');

 if(k.hasClass('com')== true){

	k.removeClass('com').addClass('com');	
	$(this).after(k);	
	var replyId = $(this).attr("id");
	$('#replyId').val(replyId);
	$('#post_reply').focus();

   }else{
	     k.removeClass('commentForm').addClass('com');	 
	     $(this).after(k);
	     var replyId = $(this).attr("id");
	     $('#replyId').val(replyId);
        }
});

$(document).on('click', '#submit', function(){

 var k=$('.com');	
 k.addClass('commentForm');
 k.removeClass('com');	 
 location.reload();

});

});	//the end of the ready function
</script>

<div class="the_page">
<?php include_once("user_header.php"); ?>

<div class="side_and_home">
<div class="side_bar">
<?php 
$query = "select  username, propic from chat_members where username='$username'";
$result = $home->theQuery($query);
$row = mysqli_fetch_row($result);
?>
<div class="user_the_propic">
   <div class="my_prof_pic">
	   <img src='propics/<?php echo $row[1] ?>' >  
   </div>	
   <div class="user_the_name">
	   <?php echo $row[0] ?>
   </div>	   
</div> 	      

 <ul class="home_thList">
    <li>My Profile</li> 
    <li>Search People</li>		
	<li>Settings and Privacy</li>
  </ul>	
  
  
</div><!-- end of .side_bar -->	



<div class="home_contentsH">


<form class="commentForm" id="commentForm" >
<input type="hidden" name="name" id="name"  value="<?php echo $username ?>" />
<input type="text" name="post_reply" id="post_reply" class="post_reply"  placeholder="Reply to post"  required /> 
<input type="hidden" name="replyId" id="replyId" value="0" /> 
<input type="submit" name="submit" id="submit" class="submit_reply"  value="Reply" />  	
</form> 

<?php
$post_id='';

if($_GET['post']){
	
 $post_id=$_GET['post'];
 $query="select * from posts where post_id='$post_id'";
 $result=$home->theQuery($query);

 $the_post = '';
 $row= mysqli_fetch_array($result);
 $pic = $home->PostPic($row['sender']);
 $the_post .= '
 <div class="the_parent_post">
 <div class="pic_name_time">';
        $the_post .= "<div><img  src='propics/$pic' class='the_round_pic' /></div>";
		$the_post .= ' <div class="name_time">			           
			           <div class="poster_name">'.$row['sender'].'</div>'.
					   '<div class="date_posted">'.$home->time_ago($row['date_posted']).'</div>'.
				 '</div>			     
		    </div>
 <div class="post_text">'.$row['post'].'</div>';
 if($row['post_pic'] != "No_Media"){
	$the_post .='<div class="post_media_parent">'."<img  class='post_media2' src='posts_media/$row[post_pic]' /></div>";
   }
 $the_post .='<div class="like_reply">		
			<div class="like lleft"><img src="icons/like.png"/></div>
		    <div class="dislike rright"><img src="icons/dislike.png"/></div>        
		</div>'. 
 '<button type="button"  id="'.$row["post_id"].'" class="reply margin">Reply</button>
 </div>';
 
 $post_id=$row["post_id"];
 echo $the_post;  
}
?>
<div id="p_id"><?php echo $post_id ?></div> 
<div id="replies"  class="now_replies"></div>


</div><!-- end of .home_contentsH -->
</div><!-- end of .side_and_home -->
</div><!-- end of .the_page -->
