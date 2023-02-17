<?php 
$title="Groups";
include_once("header.php");
require_once("Vichat.php");
$username = $_SESSION['username']; 
$group = new ViChat();
?>
<style>
.gr_name{
  display:none;
}

.cam_ico{
  display:flex;
  justify-content:center;
	align-items:center;    
  border-radius:50%;
  margin-top:5px;
  width:100px;
	height:100px;	
	box-shadow:0px 0px 5px 5px black;
	cursor:pointer;		
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
	width:100px;
	height:100px;
  overflow:hidden;  	    
}
.mediaPic{
  height:200px; 
  cursor:pointer;   
}
</style>
<script>
$(document).ready(function(){

var username = $('.gUsName').html();
var fixed_id = $('.fixed_id').html();
var g_name = $('.gr_name').html();

sideGroups(username);

/*this code just shows different views,
 *when a user want to create a group, different content
 *is showed, messages will be revealed if he/she clicks
 *on a group checkdate
 */
switch(fixed_id){  
  case "create": 
    showFriendsToAdd(username);       
    break;
  default:
    showGroupMessages(fixed_id, username);
    break;
}
/* The following code add the names of the 
 * people to be added into a group. On the 
 * groups.php page the users friend will be
 * shown and an { add friend } button will be shown
 * and the names of the friend will be added to a member list
 */
var names = '';
$(document).on('click','.canc_button', function(){
  event.preventDefault();	
  var obj = $(this).siblings();
  var name = $(obj[0]).attr('class');//to take the friend's name in a form

  $('.del_mem').prepend("<div class='del_this'><div class='abs_bar'><div class='line1'></div><div class='line2'></div></div>"+name+"</div>");
  $(this).parent().parent().parent().hide('slow');   

  if(names == ''){
    names = name.replace(/ /g, "+");//this statement replaces    
  }else{                            // the whitespaces with the + sign 
    name = name.replace(/ /g, "+");
    names = names+'/'+name;     
  }  
});

/*The following code handles the removal of group members
 * before they are finally added to the group.
 * Their names will be removed from the group member list and 
 * will disappear from the screen.
 */

$(document).on('click','.abs_bar',function(){  
  name = $(this).parent().html();  
  name = name.replace("<div class=\"abs_bar\"></div>","");  
  if(names.search("/"+name+"/") != -1){
    name = "/"+name+"/";
    names = names.replace(name,"");
  }else if(names.search("/"+name) != -1){    
    name = "/"+name;
    names = names.replace(name,"");
  }else if(names.search(name+"/") != -1){
    name = name+"/";
    names = names.replace(name,"");    
  }else{
    names = "";   
  }
  $(this).parent().hide('slow');
  
});

$(document).on('click','.create_g_button',function(){
    event.preventDefault(); 
    alert(names);
    //createGroup(username, g_name, names)
}); //the end of the $('.create_g_button').click()
  
  

$('.send_Group_msg').submit(function(e){//this is used to send the group messages
event.preventDefault();		
$(this).ajaxSubmit({    
 dataType: "json",
 success:function(response){
  if(!response.error){	 
    sideGroups(username);
    showGroupMessages(fixed_id, username);
    $('.type_msg').val('');	 	 
	  }
  },
 error:function(response){
  alert(response.error);
  }
 });
}); 

/*the following function is used to create the group
 *It takes the username, the group_name and the names of the group members
 *That you have selected
 */
function createGroup(username, g_name, names){
  var data = "mode="+"create_group"+"&username="+username+"&group_name="+g_name+"&names="+names;
  $.ajax({
    url:"ajax_to_php.php",
    data:data,
    method:"POST",
    success:function(response){
      alert("The group is successfully created");
    }
  });
}

/*the following function shows the messages
 *in a particular group.
 *It takes the group_id and the username of the group member
 */

function showGroupMessages(fixed_id, username){
 var data = "mode="+"showGroupMessages"+"&fixed_id="+fixed_id+"&username="+username;
 $.ajax({
		 url:"ajax_to_php.php",
		 data: data,	
		 method:"POST",
		 success:function(response){
		  $('#showMessages').html(response);
		  }
	});
}

/*This function just shows the names of the users friends
 *A user can only add their friends into their groups
 */
function showFriendsToAdd(username){
  var data = "mode="+"addToGroup"+"&username="+username;
  $.ajax({
    url:"ajax_to_php.php",
    data:data,
    method:"POST",
    success:function(response){
      $('.addGrMem').html(response);
     }
  }); 
}

/*This function just shows the list of the groups
 *that the user has joined and the last message that 
 *was sent in that group
 */

function sideGroups(username){
  var data = "mode="+"sideGroups"+"&username="+username;
  $.ajax({
    url:"ajax_to_php.php",
    data:data,
    method:"POST",
    success:function(response){
      $(".g_left").html(response);
    }
  });

}

});//end of the ready function

</script>

<div class="the_page">
<div class="home_contents">
<div class="msg_header_msgs"> 
  
<div class="g_left_height">     
<div class="g_left"> </div>
</div><!-- end of g_left_height -->

<div class="g_right">
<?php

if($_GET['gid'] == "null"){  
  $pic = 'user1.jpg';
  $receiver = 'Group';
  include_once('chat_header.php');
  ?> <div class='when_msg_null'>((?)) Your group messages will appear here ((?))</div> <?php
}elseif($_GET['gid'] == "create"){  
  $receiver = $_GET['group_name'];
  $pic = 'user1.jpg';
  include_once('chat_header.php');
  ?>
  <div class='gr_name'><?php echo $receiver ?></div>
  <div class="addGrMem"></div>
  <?php
}else{
  $gid = $_GET['gid']; 
  $query = "select group_name, propic from group_name where fixed_id = '$gid'";
  $result = $group->theQuery($query);
  $row = mysqli_fetch_row($result);
  $receiver=$row[0];
  $pic = 'user1.jpg';
  include_once('chat_header.php');
  ?>
  <div id="showMessages" class="PersonalMsgs"></div>

  <form method="post" action="ajax_to_php.php" class="send_Group_msg inboxMe">
  <textarea type="text" name="message" class="type_msg" cols="30" rows="3"></textarea>    
  <input type="hidden" name="username"  value="<?php echo $username ?>" />
  <input type="hidden" name="fixed_id" value="<?php echo $_GET['gid']?>" /> 
  <input type="hidden" name="mode" value="Group_Message"/>
  <input type="submit" name="add_member" class="post_submit msg_send"  value="Send" />  	
  </form>
  <?php
}
?>

<div class="fixed_id"><?php echo $_GET['gid'] ?></div>
<div class='gUsName'><?php echo $username ?></div>



</div><!-- end of g_right --> 



</div><!-- end of msg_header_msgs -->
</div>
</div>

