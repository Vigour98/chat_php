<?php
$title="Your Profile";
include_once("Vichat.php");
include_once("header.php"); 
$posts = new ViChat();
$username = $_SESSION['username'];
include_once("min_header.php");
?>

<!--    
    The css below refers to the icon 
     for the (Update Profile Picture section)

     The main css code for this page and many 
     other pages is found on the (chat.css file)

     In cases where the author want to change the css code
        ->the css on chat.css is grouped in respective to their pages
        -> It is very fast if the user inspects the html element of the item 
           and identify its attribues and searches for the css code of the element
           using the Editors Search feature 
-->
<style>
.cam_ico{
    display:flex;
    justify-content:center;
	align-items:center;
    border:2px solid black;
    border-radius:50%;
    width:50px;
	height:50px;	
	box-shadow:0px 0px 3px 3px black;
	cursor:pointer;
	margin-right:10px;	
	transition:all 0.2s linear;
    background: rgb(228, 117, 11);    
}
.cam_ico:hover{
	transition:all 0.2s linear;
	box-shadow: 0px 0px 2px 2px rgb(59, 126, 14);
	opacity:.8;
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
</style>	
<script type="text/javascript">

//it is a jquery function that uses ajax to submit the forms
// it will be used when a user want to change the details on his profile
//the class $('.MyProfile') is assigned to all the forms on this page   
$(document).ready(function()
{ 
var username=$('#usernameFri').html(); 

$('.MyProfile').submit(function(e){
event.preventDefault();		
$(this).ajaxSubmit({
 method:"POST",
 url:"ajax_to_php.php",   
 dataType: "json",
 success:function(response){
  if(!response.error){ 
     alert(response);     
	 location.reload();     
	    }
     },
 error:function(response){
    alert(response.error);
     }    
  });
});


//geting all class elements called .edit_sign and MyProfile 
//into their respective variables
edit_sign = $('.edit_sign');
MyProfile = $('.MyProfile');
$lab = $('.lab');

//Converting the above elements into an array
sign = Array.from(edit_sign);
form = Array.from(MyProfile);
label = Array.from($lab)

/*accessing each elemet on click event make it visible
 *by removing the class 'hideFrm' which hides the form
 *it is also used to highlight the field that the 
 *user is country working on
 */
for (var i=0;i<sign.length;i++)
{
 $(sign[i]).on('click',function(){     
  event.preventDefault();	
  var v = sign.indexOf(this);
  $(form[v]).fadeIn(1000).removeClass('hideFrm');
  $(label[v]).addClass('Labcolor').removeClass('lab');
 });

}

$(document).on('click','#add_photos',function(){
  event.preventDefault();  
  var form_data = new FormData();
  var totalfiles = document.getElementById('files').files.length;  
  for(var index = 0; index < totalfiles; index++){
      form_data.append('files[]',document.getElementById('files').files[index]);
  }
  form_data.append('username',username);
  $.ajax({
      url: 'multi_upload.php',
      type: 'post',
      data: form_data,
      dataType: 'json',
      contentType: false,
      processData: false,
      success: function(response){
          for(var index=0; index<response.length;index++){
              var src = response[index];
              $('#preview').append('<img src="'+src+'" >');
          }
      },
      error:function(response){
          alert(response.error);
      }
  });//end of the ajax function 

});//end of the multi-click 



function showProfDetails(username){ 	
 var data="mode="+"showProfDetails"+"&username="+username;  
 $.ajax({
		 url:"ajax_to_php.php",
		 data: data,
		 method:"POST",
		 success:function(response){           		 
     	  $('.the_right_side').html(response);			  
		  },
         error:function(response){
          alert(response.error);
        }
	});
}

function showPictures(username){ 	
 var data="mode="+"showPictures"+"&username="+username;  
 $.ajax({
		 url:"ajax_to_php.php",
		 data: data,
		 method:"POST",
		 success:function(response){           		 
     	  $('.the_right_side').html(response);			  
		  },
         error:function(response){
          alert(response.error);
        }
	});
}

//showProfDetails(username);
showProfDetails(username)


});// the end of the jQuery object and the script tag also
</script>

<div class="my_pro_lr">
<?php

//the below query searches for the details of the user and displays them
//the form elements will enable a user to change his user profile
//the Username of the user is the only thing that can not be altered
$query="select * from chat_members where username = '$_SESSION[username]'";
$result=$posts->theQuery($query);
$row = mysqli_fetch_row($result);
$pic = $posts->checkProfile($row[9],$row[6]);
?>
 <div id='usernameFri'><?php echo $username ?></div>

 <div class='myp_left_right'>

     <div class="pronameP">
         <?php 
         print("<div class='my_prof_item_1'>

         <div class='icon_lab'>
            <div class='edit_pro'><img src='icons/edit.png' class='edit_sign'/></div>
            <div class='titlePro lab theWidth'>Profile Picture</div>
         </div>
         
         <div class='form_pic'>             
                  <form method='Post' action='my_profile.php' enctype='multipart/form-data' class='MyProfile hideFrm' >
                        <input type='hidden' name='username' value='$username'/> 
                        <div class='makeRow'>
                             <div class='cam_ico'>  
                                    <div class='media'><input type='file' class='mediaPic' name='picture' /></div>
                             </div>
                             <input type='submit' class='fchange change' name='changePro' value='Update'>
                        </div>
                  </form> 
                  </div> 

             </div>");
         ?>
        <div class='user_pro_my'><img src='propics/<?php echo $pic ?>' class='proppic'/></div> 
        <?php  echo'<div class="prname">'. $row[3].'</div>' ?>
        
    </div>     
    
    <div class='prof_list'>
        <div>Profile</div>
        <div>Your Photos</div>        
        <div>Profile Settings</div>
    </div>

</div><!-- end of the left side -->

<div class="the_right_side"></div>

</div><!-- end of the home_page


