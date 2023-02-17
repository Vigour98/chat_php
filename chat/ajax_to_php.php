<?php 
include_once("Vichat.php"); 

$posts = new ViChat();
 
if(isset($_POST['mode'])){
   $mode=$_POST['mode'];

   if($mode == 'newPosts'){
	   $username = $_POST['username'];
	   $table = $_POST['table'];
	   $result = $posts->Notifications($username, $table);
	   echo $result;
   }

   if($mode == 'newParentMessages'){
	   $username = $_POST['user'];
	   $table = $_POST['table'];
	   $result = $posts->Notifications($username, $table);
	   echo $result;
   } 
   
   if($mode == 'newGroupMessages'){
	   $username = $_POST['username'];
	   $table = $_POST['table'];
	   $result = $posts->Notifications($username, $table);
	   echo $result;
   }
 
   if($mode == 'showParentPosts'){
	  $result = $posts->showParentPost();   
	  echo $result; 
     }
   
   if($mode == 'sendParentPost'){
      $u_name = $_POST['u_name']; 
	  $commentId = $_POST['commentId'];
	  $p_post = $_POST['p_post'];	  
	  $pic = "No_Picture";
	  $video = "No_Video";	
	  
	  if(isset($_FILES['media']['name'])){
		$media_name = $_FILES['media']['name']; 	  
		$saveto = "posts_media/".$media_name;		
		$media_type = $_FILES['media']['type']; 		  	     		
			
		if( ($media_type == "image/png") || ($media_type == "image/jpeg") ||
		    ($media_type == "image/pjpeg") || ($media_type == "image/gif") ){

			$pic = $media_name; 			
			move_uploaded_file($_FILES['media']['tmp_name'], $saveto);			
		}
		
		if( ($media_type == "video/mp4") || ($media_type == "video/mkv") ||
		    ($media_type == "video/ts") ){
			$video = $media_name;  
			move_uploaded_file($_FILES['media']['tmp_name'], $saveto);
		}
	  }
      
	  $result = $posts->sendParentPost($u_name, $commentId, $p_post, $pic, $video); 
	  echo $result;
	}

   if($mode == "create_group"){
	   $group_name = $_POST['group_name'];
	   $username = $_POST['username'];
	   $names = $_POST['names'];	   
	   $result = $posts->CreateGroup($username, $group_name, $names);
	   echo $result;
     }

   if($mode == "sideGroups"){
	   $username = $_POST['username'];
	   $result = $posts->sideGroups($username);
	   echo $result;
   }
  
   if($mode == 'showReplies'){
	  $post_id=$_POST['post_id']; 
      $result=$posts->getCommentReply($post_id, $marginLeft = 0);
	  echo $result;	   
     }	

   if($mode == 'SendGetReplies'){
	  $id = $_POST['id'];
	  $name = $_POST['name'];
	  $reply = $_POST['reply'];
	  $post_id = $_POST['post_id'];	  
	  $posts->sendReplies($id,$reply, $name);	  
	  $result = $posts->getCommentReply($post_id, $marginLeft = 0);
	  echo $result;
     }	  
    
   if($mode == 'top_msgs'){
	   $username = $_POST['username'];
	   $result = $posts->topLayerMessages($username);
	   echo $result;
   }	 
   if($mode == 'sendingInbox'){
	  $username = $_POST['username'];
	  $receiver = $_POST['receiver'];
	  $message = $_POST['message'];
	  $result = $posts->sendMessagesInbox($username,$receiver,$message);
	  echo $result;	   
	 }
	 
   if($mode == 'showPersonalMsgs'){
	  $username=$_POST['username'];
	  $receiver=$_POST['receiver'];	  
	  $result=$posts->twoPeopleMessages($username,$receiver);
	  echo $result;	   
	 }
	 
   if($mode == 'sendAssocReq'){
	  $friend=$_POST['friend'];	 
      $username=$_POST['username']; 	  
	  $result=$posts->sendAssocReq($username,$friend);
	  echo $result;	   
	 }
	 
   if($mode == 'cancelAssocReq'){
	  $friend = $_POST['friend'];	 
      $username = $_POST['username']; 	  
	  $result = $posts->cancelAssocReq($username,$friend);
	  echo $result;	   
	 }

   if($mode == 'acceptAssocReq'){
	  $friend = $_POST['friend'];	 
      $username = $_POST['username']; 	  
	  $result = $posts->acceptAssocReq($username,$friend);
	  echo $result;	   
	 }

   if($mode == 'RevokeConnect'){
	  $friend = $_POST['friend'];
	  $username = $_POST['username'];
	  $result = $posts->revokeConnect($username, $friend);
	  echo $result;
	} 
    
   if($mode == 'outgoingReqs'){
	  $username = $_POST['username'];
	  $result = $posts->outgoingConnects($username);
	  echo $result;
   }
   
   if($mode == 'incomingReqs'){
	  $username = $_POST['username'];
	  $result = $posts->incomingConnects($username);
	  echo $result;
   }

   if($mode == 'yourConnects'){
	  $username = $_POST['username'];
	  $result = $posts->showConnects($username);
	  echo $result;
   }

   if($mode == 'possibleConnects'){
	  $username = $_POST['username'];
	  $result = $posts->possibleConnects($username);
	  echo $result;
   }
   

	if($mode == 'update_profile'){
	   $username = $_POST['username']; 
	   $column = $_POST['column'];
	   $value = $_POST['value'];	  
	   $result=$posts->updateProfile($username, $column, $value);
	   echo $result;	   
	}

	if($mode == 'update_dob'){
		$username = $_POST['username']; 
	    $column = $_POST['column'];
		$day = $_POST['day']; 
		$month = $_POST['month'];
		$year = $_POST['year'];			
		$value =$year.'-'.$month.'-'.$day;
		$result = $posts->updateProfile($username, $column, $value);
		echo $result;	   
	  }

	if($mode == 'Group_Message'){
		$username = $_POST['username'];
		$fixed_id = $_POST['fixed_id'];
		$message = $_POST['message'];
		$result = $posts->SendGroupMessage($username, $fixed_id, $message);
		echo $result;
	} 
	
	if($mode == 'showGroupMessages'){
		$fixed_id = $_POST['fixed_id'];
		$username = $_POST['username'];
		$result = $posts->showGroupMessages($fixed_id, $username);
		echo $result;
	}

	if($mode == 'addToGroup'){
		$username = $_POST['username'];		
		$result = $posts->add_group_members($username);
		echo $result;
	}

	if($mode == 'showProfDetails' ){
		$username = $_POST['username'];
		$result = $posts->show_prof_details($username);
		echo $result;
	}
      
    if($mode == 'showPictures'){
		$username = $_POST['username'];
		$result = $posts->show_your_pics($username);
		echo $result;
	} 	
	
	 
}   
?> 


