<?php
class ViChat{
	  private $host  = 'localhost';      	  
      private $user  = 'valentine';    
	  private $dbConnect = false;
	
      public function __construct(){
       if(!$this->dbConnect){ 
          $conn = new mysqli($this->host, $this->user, $this->user, $this->user);
          if($conn->connect_error){
             die("Error failed to connect to MySQL: " . $conn->connect_error);
          }else{
                  $this->dbConnect = $conn;
                 }
			}
       }
	
      public function theQuery($sqlQuery){
	   $result = mysqli_query($this->dbConnect, $sqlQuery);
	   if(!$result){
	      die('Error in query: '. mysqli_error($this->dbConnect));
	     }	 
	   return  $result;
	  }
	
      public function numOfRows($sqlQuery){
	   $result = mysqli_query($this->dbConnect, $sqlQuery);
	   if(!$result){
	      die('Error in query: '. mysqli_error($this->dbConnect));
	     }
	   $numRows = mysqli_num_rows($result);
	   return $numRows;
	  }	
	  
      private function validateUsername($value){     
	   $value = trim($value); 
	   if ($value==""){ 
	      return "Please enter your Username."."<br>";
	   }elseif (strlen($value) <3){		  
	          return "Username must be greater that 3 words."."<br>";  
	   }elseif(strlen($value) > 20) {		  
	          return "Username must not be greater than 20."."<br>";
	   }else return "";    
	  }
	  
      private function validateFirstname($value){     
	   $value = trim($value); 
	   if ($value==""){		   
	      return "Please enter your Firstname."."<br>";
	   }elseif (strlen($value) <3){
			  return "Firstname must be greater that 3 words."."<br>";
			 }			  
	   elseif(strlen($value) > 20){	   
	          return "Firstname must not be greater than 20."."<br>";
			 }else return "";    
      }
	  
      private function validateLastname($value){     
	   $value = trim($value); 
	   if ($value==""){	
	      return "Please enter your Lastname."."<br>";
	   }elseif (strlen($value) <3){	   
	          return "Lastname must be greater that 3 words."."<br>";  
	   }elseif(strlen($value) > 20){
	          return "Lastname must not be greater than 20."."<br>";
	   }else return "";    
	  }
	  
      private function validatePassword($value){ 
       $value = trim($value); 
	   if($value == ""){
		  return "No Password was entered."."<br>"; 
	   }elseif(strlen($value) < 6){	
			   return "Password must be at least six(6) characters."."<br>";
	   }elseif( 
			  !preg_match("/[a-z]/", $value) ||            
              !preg_match("/[A-Z]/", $value) ||          
              !preg_match("/[0-9]/", $value)
			 ){	 
               return "Passwords require 1 each of a-z, A-Z and 0-9."."<br>"; 
	   }else return ""; 
      }  
	  
      private function validatePassword2($value,$value2){
	   if($value != $value2){   		  
          return "The passwords must match."."<br>";
		 } return "";   
      }	
	 
      private function validateEmail($value){      
       $value = $this->dbConnect->real_escape_string(trim($value)); 
	   $query= "select * from chat_members where email='$value'";	  
	   if($this->numOfRows($query) > 0){		   
	      return 'This Email is already in use.'."<br>";  
	   }elseif($value == null){	 
			 return "Email must not be empty."."<br>"; 
	   }elseif(strlen($value) <10){	   
	          return "Email address too short."."<br>";
	   }elseif(strpbrk($value,"^!#$%&[]{}~:;*(/\)-+=?><,'")){
	         return "Invalid Characters only Digits, numbers (_)"."<br>"; 
	   }elseif (!((strpos($value,".")> 0))) {	      
		return "Invalid Email Address"."<br>";
	   }elseif (!((strpos($value,"@")> 0))){    
			  return "Invalid Email Address."."<br>"; 
	   }else return ""; 
      }
	  
      private function validateDob($value1, $value2, $value3){
	    if(($value1 == "") || ($value2 == "") || ($value2 == "")){
		  return "Fill all fields for your date of birth."."<br>";
		}elseif(!(is_numeric($value1))  || !(is_numeric($value2)) || !(is_numeric($value2)) ){  
	      return "Invalid date of birth."."<br>"; 
		}elseif(($value1 > 31) || ($value1 < 1)){
		return "Invalid date of birth."."<br>";
		}elseif(($value2 >12) || ($value2 < 1)){
		return "Invalid date of birth."."<br>";	
		}elseif(strlen($value3) < 4 ){
		  return "Invalid date of birth."."<br>";
	    }else return ""; 
	  }
	  
      public function ValidatePHP($username,$firstname,$lastname,$email,$password,$password2,$day,$month,$year,$gender){   
       $error="";	   
	   if($this->validateUsername($username)){
		  $error.=$this->validateUsername($username);		   
		 }		 
       if($this->validateFirstname($firstname)){
		  $error.=$this->validateFirstname($firstname);		   
		 }		 
       if($this->validateLastname($lastname)){
		  $error.=$this->validateLastname($lastname);		   
		 }		 
       if($this->validatePassword($password)){
		  $error.=$this->validatePassword($password); 
		 }		 
       if($this->validatePassword2($password,$password2)){
		  $error.=$this->validatePassword2($password,$password2);
	     }		 
       if($this->validateEmail($email)){
		  $error.=$this->validateEmail($email);
		 }		 
       if($this->validateDob($day,$month,$year)){
		  $error.=$this->validateDob($day,$month,$year);
		 }		   
       if($error==""){		  	
		  $date = date("y:m:d");		
		  $query = "insert into chat_members(user_id,firstname,lastname,username,
		  		passwordX,email,gender,dob,date_joined)  
		  		values(null,'$firstname','$lastname','$username',
		 	    '$password','$email','$gender','$year-$month-$day','$date')"; 
		  $this->theQuery($query);
		  
		  $query = "insert into notifications values ('$username', 'post', 0)"; 
		  $this->theQuery($query);

		  $query = "insert into notifications values ('$username', 'group_messages', 0)"; 
		  $this->theQuery($query);

		  $query = "insert into notifications values ('$username', 'chat_messages', 0)"; 
		  $this->theQuery($query);

		  $query= "select user_id from chat_members where email='$email'";
		  $result = $this->theQuery($query);
		  $row = mysqli_fetch_row($result);
		
          $signed=array(); 
	      if(!empty($row)){
		     $signed[] = $row[0];  
	         $signed[]= $username;	 
		     return $signed;
	        }
	      }else{
		        return $error; 
	        }		
      }

      public function login($email,$password){
	   $email = $this->dbConnect->real_escape_string(trim($_POST['email']));
	   $password = $this->dbConnect->real_escape_string(trim($_POST['password']));
	   //$password = md5($password);
	   $query="select user_id,username from chat_members where email='$email' and passwordX='$password'";
	   $result = $this->theQuery($query); 
	   $row = mysqli_fetch_row($result);	   
	   
	   if(!empty($row)){			 		  
		  $_SESSION['userid'] = $row[0];	 	 
	      $_SESSION['username'] = $row[1];
		  header("Location:home.php");          
	   }else{			  	 
		     return "Incorrect Email or Password"; 
	         }      				 
      } 

	  
      public function PostPic($username){
	    $query = "select * from chat_members where username = '$username'"; 
	    $result = $this->theQuery($query);
        $pro = mysqli_fetch_row($result);      
	    return $this->checkProfile($pro[9],$pro[6]);	
      }

	  public function bi_notifications($username, $other){
		$query = "select * from notifications where username = '$username' and the_field = '$other'";
	    $result = $this->theQuery($query);
	    $row = mysqli_fetch_row($result);

		$query2 = "select * from chat_messages where msg_sender != '$username' and msg_id > '$row[2]'";		
	    $num = $this->numOfRows($query2);

		if($num > 0){
			return $num;
		}else{
			$num="";
			return $num;
		}		  
	}

      public function Notifications($username, $table){	
		$username = trim($username);		 
	    $query = "select * from notifications where username = '$username' and the_field = '$table'";
	    $result = $this->theQuery($query);
	    $row1 = mysqli_fetch_row($result);		
		
		if($table == "post"){
	       $query = "select post_id from posts where sender != '$username' and post_id > '$row1[2]'";		
	       $num = $this->numOfRows($query);
		}

	    if($table == "chat_messages"){
		   $query = "select msg_id from chat_messages where  msg_receiver = '$username' and msg_id > '$row1[2]'";		
	       $num = $this->numOfRows($query);		   
		}

		if($table == "group_messages"){
			$group_ids = array();

			$query = "select fixed_id from group_members where username = '$username'";
			$result = $this->theQuery($query);			
			while($row = mysqli_fetch_row($result)){
				  $group_ids[] .= $row[0];				 
			}			
			$addlist = array();            
				
			foreach($group_ids as $group_id){
			     	$query2 = "select msg_id from group_messages where (username != '$username'
					 and fixed_id = '$group_id')  and msg_id > '$row1[2]'";		
	                $addlist[] .= $this->numOfRows($query2);
			}

			$num = 0;

			foreach($addlist as $add){
				$num = $num + intval($add);
			}
		}
		
	    if($num > 0){
		   $skilful = "<div class='no_style'>".$num."</div>";	
	       return $skilful;
	    }else{
	       $num="";
	       return  $num;
	       }		
	   }   
	  
      public function showParentPost(){
	   $query="select * from posts where parent_id='0' order by post_id desc";
       $result=$this->theQuery($query); 
       $p_post='';
       while($row=mysqli_fetch_array($result)){
	   $pic = $this->PostPic($row['sender']);
		$p_post.='<div class="the_parent_post">';  
		    $p_post.='<div class="pic_name_time">';
			     $p_post.="<div>"."<img  src='propics/$pic' class='the_round_pic' />"."</div>";
			     $p_post.='<div class="name_time">';			           
			           $p_post.='<div class="poster_name">'.$row['sender'].'</div>';
					   $p_post.='<div class="date_posted">'.$this->time_ago($row['date_posted']).'</div>';
				 $p_post.='</div>';			     
		    $p_post.='</div>';			
	        $p_post.='<div class="post_text">'."<a href='home2.php?post=$row[post_id]'>".$row['post']."</a>".'</div>';
			if($row['post_pic'] != "No_Picture"){
			$p_post.='<div class="post_media_parent">'."<a href='home2.php?post=$row[post_id]'><img  src='posts_media/$row[post_pic]'".' class="post_media" /></a>'.'</div>';
			}
			if($row['post_video'] != "No_Video"){
				$p_post.='<div class="post_media_parent">'."<a href='home2.php?post=$row[post_id]'>";
				$p_post.= '<video class="post_media" controls >'."<source  src='posts_media/$row[post_video]'></video>".'</a>'.'</div>';
				}	

			$p_post.='<div class="like_reply">';
			       $p_post.='<div class="span_like_dislike">';
			             $p_post.='<div class="like likeLT">'."<img src='icons/like.png'>".'</div>';
				         $p_post.='<div class="dislike">'."<img src='icons/dislike.png'>".'</div>';
				   $p_post.='</div>';
                   $p_post.='<div class="comments">'."<img src='icons/comment.png'>".'</div>';
		    $p_post.='</div>';	   
	   	$p_post.='</div>';
	   }
	   echo $p_post;
      }
	  
	  public function time_ago($time){  
		$time_ago=time()-$time;
		if($time_ago < 60){	
           return "seconds ago";	
	    }elseif($time_ago < 3600){
	           $time=floor($time_ago/60);
	           if($time==1){
                  return $time." mins";
	           }else{
		            return $time." mins";
		           } 	   
        }elseif($time_ago < 86400){
	           $time=floor($time_ago/3600);	  
	           if($time==1){
                  return $time." hour";
	           }else{
		            return $time." hours";
		           }
              }
        elseif($time_ago < 604800){
	           $time=floor($time_ago/86400);	   
	           if($time==1){
                  return $time." day";
	           }else{
		            return $time." days";
		           }
              }
        elseif($time_ago < 2592000){
	           $time=floor($time_ago/604800);
	           if($time==1){
                  return $time." week";
	           }else{
		            return $time." weeks";
		           }
              }
        elseif($time_ago < 31536000){
	           $time=floor($time_ago/2592000);
	           if($time==1){
                  return $time." month";
	           }else{
		            return $time." months";
		           }
               }
		elseif($time_ago >= 31536000){
	           $time=floor($time_ago/31536000);
	           if($time==1){
                  echo $time." year";
	           }else{
		            echo $time." years";
		           }
              }
      }
	
      public function sendParentPost($u_name, $commentId, $p_post, $pic, $video){
	   if( !empty($u_name) ){ 
	      $date=time();
	      $query = "insert into posts values (null, '$commentId', '$p_post', '$pic', '$video', '$u_name', '$date')";
	      $this->theQuery($query);
		  $feedback= "You have successfully send a post";
		  echo json_encode($feedback);
	   }else{
			$feedback= "An error occured while sending your post!";
			echo json_encode($feedback);
		   } 
      }
	
      public function getCommentReply($parentId = 0, $marginLeft = 0){
	   $commentHTML = '';
	   $query = "select * from posts where parent_id = '".$parentId."'";	
	   $result=$this->theQuery($query);
	   $num_of_comm =$this->numOfRows($query);
	 
	   if($parentId == 0){
		  $marginLeft = 0;
	   }else{
		    $marginLeft = $marginLeft + 40;
	       }
	   if($num_of_comm > 0){
		  while($row = mysqli_fetch_assoc($result)){  
			    $pic = $this->PostPic($row['sender']);
			    $commentHTML .= '				
				<div class="reply_reply">
			    <div  style="margin-left:'.$marginLeft.'px">				 
				 <div class="the_parent_post postrep">
                 <div class="pic_name_time">';				 
			     $commentHTML .= "<div><img  src='propics/$pic' class='the_round_pic' /></div>";
				 $commentHTML .= '<div class="name_time">			           
			            <div class="poster_name">'.$row['sender'].'</div>'.
					    '<div class="date_posted">'.$this->time_ago($row['date_posted']).'</div>'.
				 '</div>			     
		        </div>
			    <div class="post_text">'.$row['post'].'</div>'.'
			    <div class="panel-footer" align="left"><button type="button" class="reply" id="'.$row["post_id"].'">Reply</button></div>
			    </div>			    
			    </div>
				</div>				
			    ';
			    $commentHTML .= $this->getCommentReply($row["post_id"], $marginLeft);
		       }
	     }
	     return $commentHTML;
      }
	
      public function sendReplies($id,$reply, $name){
	   if(!empty($name) && !empty($reply)){
	      $date=time();		
	      $query = "insert into posts(post_id,parent_id,post,sender,date_posted)
		            values(null,'$id','$reply','$name','$date')";
          $this->theQuery($query);
	     }	  
      }


/*  the topLayerMessages() function is used to show the last messages between the user
 *  and the connects. A user will click on that chat and the user will be taken to 
 *  a detailed chat between the user and its connect.
 */  
	  public function topLayerMessages($username){		  
	    $query = "select msg_sender, msg_receiver from chat_messages where 
		          msg_sender = '$username' or msg_receiver = '$username'"; //this query takes the
	    $result=$this->theQuery($query);								   //names of the connects who have
		$names=array();													   //had converstation with the user
		while($row = mysqli_fetch_assoc($result)){
			  if($row['msg_sender'] == $username){	  
			     $names[].=$row['msg_receiver'];			     
			  }elseif($row['msg_receiver']== $username){
					 $names[].=$row['msg_sender'];		
					}				  
		     }			
		
		$names=array_unique($names);	 
      	$results = '';
		$results .= "<div class='adj_m_height'>";  
		$results .= "<div class='chts_header'>Chats</div>";  
		if(empty($names)){
			$results .= "<h3 class='NoMsgs'>There are no messages here yet!</h3>";
			$results .= "<div class='ref'><a href='friends.php'>Start Chat</a></div>";
		}else{
		foreach ($names as $name){
		 $query="select * from chat_messages where msg_sender = '$name' or msg_receiver = '$name' order by msg_id desc";
		 $result=$this->theQuery($query);
		 $row = mysqli_fetch_array($result);
		 $pic = $this->PostPic($name);
			  
		 $results .= "<div class = 'messages_cover'>";
		 $results .= "<img  src = 'propics/$pic' class='the_round_pic' />";
		 $results .= "<a href = 'messages.php?friend=$name'>";
		 $results .= "<div class = 'msg_name'>".$name."</div>";
		 $results .= "<div class = 'messageNyou'>";
		 if($username==$row[1]){
			$results .= "<div class='youItalic'>"."You: "."</div>";
		   }	 
		   $results .= "<div class = 'msgYou'>".$this->substring($row[3], 17)."</div>";
		   $results .= '<div class = "notiM">'.$this->bi_notifications($username, $name).'</div>';
		   $results .="</div>";	
		 	 
		   $results .= "</div>";
		   $results .= "<hr/>";
		   } 
	    }
		$results .= "</a></div>";
		echo $results;		
	  }

	  
	  
/* The sendMessagesInbox() is used to send the messages to other users.
 * It is used on the messages.php page
 */ 

	  public function sendMessagesInbox($username,$receiver,$message){
	   if(!empty($username) && !empty($message)){ 
	      $date = date('y-m-d G:i:s');
	      $query="insert into chat_messages values (null,'$username','$receiver','$message','$date')";
	      $this->theQuery($query);
		  $feedback= "You have successfully send a post";
		  echo json_encode($feedback);
	   }else{
			$feedback= "An error occured while sending your message!";
			echo json_encode($feedback);
		   } 
      }
/* the twoPeopleMessages() is used to show the messages between the user and his friend
 * It is used on the messages.php
 */
	  
	  public function twoPeopleMessages($username,$receiver){
	   $query="select * from chat_messages where (msg_sender='$receiver' and msg_receiver='$username') or (msg_sender='$username' and msg_receiver='$receiver')";
	   $result=$this->theQuery($query);	   

	   $messages="";
	   while($row = mysqli_fetch_assoc($result)){
		         
			   if($row['msg_sender'] == $receiver){
				 $messages.= "<div class='theOther'>";	
				 $messages.= $row['message'];	
				 $messages.= "<div class='d_sent'>";
				 $messages.= $this->message_time($row['date_sent']);
				 $messages.= "</div>";			  
				 $messages.= "</div>";
				
			   }else{
				    $messages.="<div class='theMe'>";	
				    $messages.= $row['message'];
					$messages.= "<div class='d_sent'>";
			    	$messages.= $this->message_time($row['date_sent']);	
				 	$messages.= "</div>";
				    $messages.= "</div>";					
			       }		  	 
			 }			 
			 echo $messages;
      }
/*the message_time() function is used to show the time on which the message was sent
 * It is used on the message.php page  inside the twoPeopleMessages()
 */ 
	 public function message_time($date){
		
		$yr1 = array();
		$yr2 = array();				
		$year = substr($date, 0, 10);
		$date2 = date('Y-m-d h:i:s');
		$year2 = substr($date2, 0, 10);
		$yr1 = explode('-',$year);
		$yr2 = explode('-',$year2);
		$my_year = "";
		$day = "";
		$day2 = "";

		if($yr1[0] == $yr2[0]){
			$my_year = '';
		}else{
			$my_year = $yr1[0];
		}

		switch(intval($yr1[1]-1)){
			case "01": $month = "Jan"; break;
			case "02": $month = "Feb"; break;
			case "03": $month = "Mar"; break;
			case "04": $month = "Apr"; break;
			case "05": $month = "May"; break;
			case "06": $month = "Jun"; break;
			case "07": $month = "Jul"; break;
			case "08": $month = "Aug"; break;
			case "09": $month = "Sep"; break;
			case "10": $month = "Oct"; break;
			case "11": $month = "Nov"; break;
			case "12": $month = "Dec"; break;
			default: $month ='';break;
		}
        /* Due to the date error on my computer i am manually calculating the current time and date from
		 * the date and time that is given on my computer
		 * The two following if statements are calculating the day that the message was sent
		 * and the current date on the machine
		 */ 
		if($yr1[2] == 1){
			$day = 31;
		}else{
			$day = intval($yr1[2] - 1);
		}

		if($yr2[2] == 1){
			$day2 = 31;
		}else{
			$day2 = intval($yr2[2] - 1);
		}

		$hr = array();
		$time = substr($date, 11, 16);
		$hr = explode(':',$time);
		
		$new_time = intval($hr[0] + 3);
		$answer = "";
		$am = "pm";
		
		if( $new_time >= 24){
			switch($hr[0]){
				case "22":
					$answer = 1; break;
				case "23":
					$answer = 2; break;
				case "24": 
					$answer = 3; break;
			}
		}else{
			$answer = $new_time; 
		}

		if($answer > 12){
			$am = "am";
		}
        
		if($day == $day2){
			return $answer.":".$hr[1].$am;
		}else{
			return $day.".".$month. " ".$my_year . " ".$answer.":".$hr[1].$am;
		}
		
		
   }

/* the sendAssoc() function is used to send a connect request to another user
 * it is used on the friends.php page
 */	  
	  
	  public function sendAssocReq($username,$friend){
	   if(!empty($username)){	      
	      $query="insert into friends values (null,'$username','$friend')";
	      $this->theQuery($query);
		  $feedback= "You have successfully sent an Asscociate Request";
		  echo json_encode($feedback);
	   }else{
			$feedback= "An error occured while sending your Asscociate Request!";
			echo json_encode($feedback);
		   } 
      }

	  public function revokeConnect($username, $friend){
	    if(!empty($username)){
			$query="delete from friends where username='$username' and friend='$friend' ";			 
	        $this->theQuery($query);
			$query="delete from friends where username='$friend' and friend='$username' ";			
	        $this->theQuery($query);
			$feedback= "You have successfully cancelled your connection";
			echo json_encode($feedback);
		}else{
			$feedback= "An error occured while removing your Connect!";
			echo json_encode($feedback);
		}	  
	  }
      
/* the cancelAssocReq() function is used to cancel a connect request that the user has previously made
 * it is used on the friends.php page
 */		  
	  public function cancelAssocReq($username,$friend){
	   if(!empty($username)){ 	      
	      $query="delete from friends where username='$username' and friend='$friend'";
	      $this->theQuery($query);
		  $feedback= "You have successfully cancelled an Asscociate Request";
		  echo json_encode($feedback);
	     }else{
			$feedback= "An error occured while cancelling your Asscociate Request!";
			echo json_encode($feedback);
		   } 
      }
/* the acceptAssocReq() function is used to accept a connect request from another user
 * it is used on the friends.php page
 */		  
	  public function acceptAssocReq($username,$friend){
	   if(!empty($username)){ 	      
	      $query = "insert into friends values (null,'$username','$friend')";
	      $this->theQuery($query);
		  $query = "insert into notifications values ('$username','$friend',0)";		  
	      $this->theQuery($query);
		  $query = "insert into notifications values ('$friend','$username',0)";		  
	      $this->theQuery($query);
		  $feedback = "You have successfully accepted an Asscociate Request";
		  echo json_encode($feedback);
	     }else{
			$feedback = "An error occured while accepting your Asscociate Request!";
			echo json_encode($feedback);
		   } 
      }

/* The yourConnects function is used to fetch for names of users to whom the user has sent a connect
 * request, have received a connect request from and the names of the connect. It takes the username 
 * as the input variable and is used by other functions  
 */	  
	   public function yourConnects($username){
		$conn_list = array(); // It stores 3 array. the first array stores the names to where the 
							  // user has sent request, the second shows the names of people who 
							  // requested to be your connect and the third array stores the name of
							  // the mutual connects
	    	
		$out_request = array(); // this stores an array of names to where a user sent requests
		$query = "select friend from friends where username='$username'";
		$result = $this->theQuery($query);
		
		while($row = mysqli_fetch_assoc($result)){
		 $out_request[].=$row['friend'];  
		}		
		$conn_list[] = $out_request;

		$in_request = array();// this stores an array of names of the people who have sent the request to you
		$query="select username from friends where friend='$username'";
		$result = $this->theQuery($query);
		while($row=mysqli_fetch_assoc($result)){
		 $in_request[] .= $row['username'];	
		}
		$conn_list[] = $in_request;

		$connects = array_intersect($in_request,$out_request);// this stores an array of names of mutual connects
		$conn_list[] = $connects;

        return $conn_list; 
	   }


	  public function showConnects($username){
		$result = '';  
		$result .= '<h3>Your Connects</h3>';  
		$result .= '<div class="layeringConnects">'; 
		
	    $assoc = $this->yourConnects($username); 
		
		foreach($assoc[2] as $asc){ 
		 $query = "select gender, propic from chat_members where username='$asc'";
		 $results = $this->theQuery($query);
		 $row = mysqli_fetch_row($results); 
		 $pic = $this->checkProfile($row[1],$row[0]);   
			
		 $result .= '<div class="NewConCover">';
		 $result .= '<div class="asc_name_pic">'."<a href='profile.php?name=$asc'>";  
		 $result .= '<div class="pic_name">';
		 	$result .= '<div class="asc_pic">'."<img src='propics/$pic' class='asc_Tpic'/></div>";
			$result .= '<div class="asc_name">'.$asc."</div></a>"; 
		$result .= '</div>';
 
	    $result .= "<form class='revCon'>";
		$result .= "<input type='hidden'  name='username' value='$username' />";
		$result .= "<input type='hidden' name='friend' value='$asc '/>";
		$result .= "<input type='hidden' name='mode' value='RevokeConnect' />";  
		$result .= "<input type='submit'  class='canc_button' value='Remove Your Connect'>";
		$result .= "</form>"; 
		$result .= "</div> </div>";
		
		 }      
		      
		$result .= "</div>";
		return $result;	  
	  } 
	  
	  public function incomingConnects($username){
		$result = '';
		$result .= "<h3>Incoming Connect Request(s)</h3>";
        $result .= '<div class = "layeringConnects">'; 

	   	$assoc = $this->yourConnects($username);

        $in_ass_requests=array_diff($assoc[1],$assoc[2]);             
        foreach($in_ass_requests as $asc_rec){
        $query="select gender, propic from chat_members where username='$asc_rec'";
        $the_result=$this->theQuery($query);
        $row=mysqli_fetch_row($the_result);
        $pic = $this->checkProfile($row[1],$row[0]);
		   
        $result .= '<div class="NewConCover">';
        $result .= "<div class='asc_name_pic'>"."<a href='profile.php?name=$asc_rec'>";
        $result .= "<div class='pic_name'>";        
			$result .= "<div class='asc_pic'>"."<img src='propics/$pic' class='asc_Tpic'/></div>"; 
            $result .= "<div class='asc_name'>".$asc_rec."</div></a>
		</div>
       
	   <form class='accpt_assoc'>
	   <input type='hidden'  name='username' value='$username' />
       <input type='hidden' name='friend' value='$asc_rec' />
       <input type='hidden' name='mode' value='acceptAssocReq' /> 
       <input type='submit'  class='canc_button' value='Accept Connect Request'>
       </form> 
       
       </div></div>";
       } 
       $result .= "</div>";
	   return $result;
	  }

	  public function outgoingConnects($username){
		$result = '';  
		$result .= "<h3>Your Connect Request(s)</h3>";
		$result .= '<div class = "layeringConnects">';

	    $assoc = $this->yourConnects($username);		

		$out_ass_requests=array_diff($assoc[0],$assoc[2]);
		foreach($out_ass_requests as $asc_sent){
		  $query="select gender, propic from chat_members where username='$asc_sent'";
		  $the_result=$this->theQuery($query);
		  $row=mysqli_fetch_row($the_result);
		  $pic = $this->checkProfile($row[1],$row[0]);        
		
		$result .= '<div class="NewConCover">';
		$result .= "<div class='asc_name_pic'>"."<a href='profile.php?name=$asc_sent'>";
		$result .= "<div class='pic_name'>";
			$result .= "<div class='asc_pic'>"."<img src='propics/$pic' class='asc_Tpic'/></div>"; 
			$result .= "<div class='asc_name'>$asc_sent</div></a>
		</div> 
		 
		 <form class = 'canc_assoc'>
		 <input type = 'hidden'  name='username' value='$username' />
		 <input type = 'hidden' name='friend' value='$asc_sent'/>
		 <input type = 'hidden' name='mode' value='cancelAssocReq' />  
		 <input type = 'submit'  class='canc_button' value='Cancel Associate Request'>
		 </form>  
		 
		</div></div>";		 
		}
		$result .= "</div>";
		return $result; 
	  }


	  public function possibleConnects($username){
		$all_members = array();
		$query = "select * from chat_members";
		$result = $this->theQuery($query);
		while($row = mysqli_fetch_assoc($result)){
				 if($row['username'] != $username){
				   $all_members[] .= $row['username'];		  
					}
			  }
 
		$names_in_friends = array();
		$query = "select username,friend from friends where username='$username' or friend='$username'";
		$result = $this->theQuery($query);
		while($row = mysqli_fetch_assoc($result)){
			   if($row['username'] != $username){
				   $names_in_friends[] .= $row['username'];
				 }elseif($row['friend'] != $username){
					 $names_in_friends[] .= $row['friend'];
					   }	  
			   }	 
 
		 $possible_assoc = array_diff($all_members,$names_in_friends);	
		 
		 $results = '';		 
		 $results .= "<h3>Possible Connects</h3>";
		 $results .= '<div class="layeringConnects">'; 
		 	        
		 foreach($possible_assoc as $p_assoc){
		 $query="select gender, propic from chat_members where username='$p_assoc'";
		 $result=$this->theQuery($query);
		 $row=mysqli_fetch_row($result);
		 $pic = $this->checkProfile($row[1],$row[0]);
		 
		 
		 $results .= '<div class="NewConCover">';
		 $results .= "<div class='asc_name_pic'>"."<a href='profile.php?name=$p_assoc'>";
		 $results .= "<div class='pic_name'>";
			 $results .= "<div class='asc_pic'>"."<img src='propics/$pic' class='asc_Tpic'/></div>";
			 $results .= "<div class='asc_name'>".$p_assoc."</div></a> 
		</div>	
		  
		  <form class='assoc_req'>
		  <input type='hidden'  name='username' value='$username' />
		  <input type='hidden' name='friend' value='$p_assoc' />
		  <input type='hidden' name='mode' value='sendAssocReq' />  
		  <input type='submit' class='canc_button ascB' value='Send Associate Request'>
		  </form> 
		  
		  </div></div>";		  
		 } 
		 $results .= "</div>";
		 return $results;
	  }

/*checkProfile() function is checking if the user has uploaded his/her profile picture *
 *if there is no profile picture uploaded then the code will also *
 *check the gender of the user and insert the default picture for the given gender

 *It is used on pages (my_profile.php and profile.php)
*/
	  public function checkProfile($val,$val2){
		if($val != ""){
			$pic = $val;
		 }else{
			if($val2 == "Male"){
			   $pic = "user3.jpg";
			}else{
			   $pic = "user2.jpg";        
			} 
		 }
		 return $pic;
	  }

	  /*The showProfile() function is a function that displays
	   *the details of an associate on the Vichat platform.

	   *It will be edited so that it will hide some information
	   *from other associates in accordance to your settings
	   */ 

	  public function showProfile($name,$username){
		$query="select * from chat_members where username = '$name'";
		$result=$this->theQuery($query);
		$row = mysqli_fetch_row($result);
			
            $pic = $this->checkProfile($row[9],$row[6]);
            echo "<div class='prof_pic_item'>";

			echo "<div class='pic_item'>
			    <img src='propics/$pic' class='proppic'/>
				<div class='p_urs_na'>$row[3]</div>
			</div>";

			echo "<div class='prof_item'>"; 		
			
			echo "<div class='tit_desc'>";
            echo "<div class='titlePro'>Firstname</div>";
            echo "<div class='descri'>  $row[1]</div> ";           
			echo "</div>";
			 
			echo "<div class='tit_desc'>";
            echo "<div class='titlePro'>Lastname</div>";
            echo "<div class='descri'>  $row[2]</div>";                        
            echo "</div>";
			
			echo "<div class='tit_desc'>";        
            echo "<div class='titlePro'>Gender</div>";
            echo "<div class='descri'>  $row[6]</div>";          
			echo "</div>";
			 
			echo "<div class='tit_desc'>";
            echo "<div class='titlePro'>Email</div>";
            echo "<div class='descri'>  $row[5]</div>";           
			echo "</div>";
			
			echo "<div class='tit_desc'>";
            echo "<div class='titlePro'>D.O.B</div>";
            echo "<div class='descri'>  $row[7]</div>";                       
            echo "</div>";			
			
			$hd = $this->init_space($row[10]);
			echo "<div class='tit_desc'>";			        
            echo "<div class='titlePro'>Home Address</div>";
            echo "<div class='descri'>  $hd </div>"; 
			echo "</div>";                       
                        
			
			$whatD = $this->init_space($row[12]);
			echo "<div class='tit_desc'>";			        
            echo "<div class='titlePro'>What You Do</div>";
            echo "<div class='descri'>  $whatD </div>";                       
            echo "</div>";
            
			$marS = $this->init_space($row[13]);
			echo "<div class='tit_desc'>";			       
            echo "<div class='titlePro'>Marital Status</div>";
            echo "<div class='descri'>  $marS </div>"; 
			echo "</div>";                       
           
            
			$self = $this->init_space($row[11]);
			echo "<div class='tit_desc'>";			       
            echo "<div class='titlePro'>Self Description</div>";
            echo "<div class='descri'>  $self </div>"; 
			echo "</div>";

			echo "<div class='toMsgs'><a href='messages.php?friend=$name'>Send Message</a></div>";
			
            echo "</div>";
			echo "</div>";

		
  
	  }

      /* the updateProfile() is used to edit the users personal information.
	   * It is also used to add new information to your profile so that 
	   * your user experience may be improved.
	   * 
	   * For security reasons, username will not be edited as it allow us to track 
	   * your details more closely 
	   */
	  public function updateProfile($username, $column, $value){
		  if(!empty($value)){			  
			switch($column){
				case "firstname": $error = $this->validateFirstname($value); break;
				case "lastname": $error = $this-> validateLastname($value); break;
				case "gender": $error = ""; break;
				case "email": $error = $this->validateEmail($value); break; 
				case "dob":					
					$date = [];
					$date = explode('-', $value); 
					$error = $this->validateDob($date[2], $date[1], $date[0]);
					break;
				case "home_address":
				case "Profession":
				case "marital_status":
				case "about_you":
				default: $error = ""; break;


			}
			if($error == ""){
			  $query="update chat_members set $column='$value' where username='$username'";
			  $this->theQuery($query);
			  $feedback = "You have successfully updated your profile";
			  echo json_encode($feedback);
		      }else{
			       $feedback = $error;
			       echo json_encode($feedback);
			    }
	        }else{ 
				 $feedback = "An error occured while updating your profile!";
			     echo json_encode($feedback);
	           }
	  }
	  



/*The init_space function is used to check if the variable is 
 * empty or not. If the variable is empty, it will be initialized
 * to var x = "-------";
  
 * If the variable is not empty it will be initialized to itself.
 * 
 * It is used on pages (my_profile.php) and the (profile.php)
*/
	  public function init_space($val){
		if($val == ""){
            $hd = "- - - - - -";
        }else{
            $val= $val;
        }
		return $val;
	  }

/*The show_date() function is a function that 
 *uses the date stored in a database to present
 *in a human friendly format.

 * It is mainly used on the (my_profile.php) and 
 * (profile.php) pages in this project.
*/
	  public function show_date($val){
		 $dob = []; 
		 $month = '';
		 $dob = explode('-', $val);
		 switch($dob[1]){
			 case "01": $month = "January"; break;
			 case "02": $month = "February"; break;
			 case "03": $month = "March"; break;
			 case "04": $month = "April"; break;
			 case "05": $month = "May"; break;
			 case "06": $month = "June"; break;
			 case "07": $month = "July"; break;
			 case "08": $month = "August"; break;
			 case "09": $month = "September"; break;
			 case "10": $month = "October"; break;
			 case "11": $month = "November"; break;
			 case "12": $month = "December"; break;
			 default: $month ='';break;
		 }
		 $date = $dob[2].", ".$month." ".$dob[0];
		 return $date;
	  }
	  
	  public function SendGroupMessage($username, $fixed_id, $message){
		  if(!empty($message)){
			  $date = date('y-m-d G:i:s');
			  $query = "insert into group_messages values(null, '$fixed_id', '$username', '$message', '', '$date')";
			  $this->theQuery($query);
			  $feedback = "You have successfully sent a message to the group!";
			  echo json_encode($feedback);
		  }else{
			$feedback = "An error occured while sending your message!";
			echo json_encode($feedback);
		    }
		  }


	  public function showGroupMessages($fixed_id,$username){			     
			$query="select * from group_messages where fixed_id='$fixed_id'";
			$result=$this->theQuery($query);
			$num_of_messages = $this->numOfRows($query);
			$messages = "";			
			if($num_of_messages < 1){
				$messages .= "<h1>There are no messages yet!!</h1>";
			}else{
				while($row = mysqli_fetch_array($result)){
					if($row['username'] == $username){
						$messages .= "<div class='theMe'>";
						$messages .= $row['message'];
						$messages .= "<div class='d_sent'>";
						$messages .= $this->message_time($row['date_sent']);
						$messages .= "</div>";
						$messages .= "</div>";
					}else{
						$messages .= "<div class='theOther'>";
						$messages .= $row['message'];	
						$messages .= "<div class='d_sent'>";
						$messages .= $this->message_time($row['date_sent']);
						$messages .= "</div>";											
						$messages .= "</div>";
					}					
				}
			}
			echo $messages; 
		
	  }	
	  
	  public function substring($string, $max){		  
		  if(strlen($string) < $max){
			  return $string;
		  }else{
			  return substr($string, 0, $max).'...';
		  }
	  }

	  public function add_group_members($username){
		$out_request = array(); 
		$query="select friend from friends where username='$username'";
		$result=$this->theQuery($query);
			 
		while($row=mysqli_fetch_assoc($result)){
			  $out_request[].=$row['friend'];  
			 }
	  
		$in_request = array();
		$query="select username from friends where friend='$username'";
		$result=$this->theQuery($query);
		while($row=mysqli_fetch_assoc($result)){
			  $in_request[].=$row['username'];	
			 }	   	
		$assoc=array_intersect($in_request,$out_request);
		$to_group = '';
		$to_group .= '<div class="my_gr_all_cover">';
		$to_group .= '<div class="gr_r_side">';	
		$to_group .= '<div class="del_mem"></div>';	
		$to_group .= '<h4>-->Select group participants on your right<--</h4>';
		$to_group .= '<h4>---->You must select at least 2 people<----</h4>';
		$to_group .= '<h3 class="linkGbelow">Click the button below to Create Group</h3>';
		$to_group .= '<button class="create_g_button">Create Group</button>';
		$to_group .= '</div>';
		$to_group .= '<div class="cover_add_width">';
		$to_group .= '<div class="my_add_width">';
		foreach($assoc as $asc){ 
		  $query="select gender, propic from chat_members where username='$asc'";
		  $result=$this->theQuery($query);
		  $row=mysqli_fetch_row($result); 
		  $pic = $this->checkProfile($row[1],$row[0]);	 
		
		  $to_group .= '<div class="NewConCover">';
		  $to_group .= '<div class="asc_name_pic">'."<a href='profile.php?name=$asc'>";  
		  $to_group .= '<div class="pic_name">';
			  $to_group .= '<div class="asc_pic">'."<img src='propics/$pic' class='asc_Tpic'/></div>";
			  $to_group .= '<div class="asc_name">'.$asc."</div></a>"; 
		  $to_group .= '</div>';
	  
		 $to_group .= "<form class='addGM'>		 
		 <div class='$asc'></div>
		 <button class='canc_button'>Add to Group</button>
		 </form></div></div>"; 		 
		  } 
		$to_group .= '</div></div></div>';
		return $to_group; 
	  } 

	 public function CreateGroup($username, $group_name, $names){
		 if(!empty($group_name)){
			 $date = date("y:m:d");
			 $query = "insert into group_members values(null, '$group_name','$username','1','')";
             $this->theQuery($query);
			 $query = "select g_id from group_members where group_name ='$group_name'";
             $result = $this->theQuery($query);
			 $row = mysqli_fetch_row($result);
             $query = "update group_members set fixed_id = '$row[0]' where username ='$username' and group_name = '$group_name'";
             $this->theQuery($query);
			 $query = "insert into group_name values('$group_name', '$row[0]','' ,'$date')";
             $this->theQuery($query);
			 $names_arr = array();
		 	 $names_arr = explode("/",$names);
			 $query = "select g_id from group_members where group_name ='$group_name'";
             $result = $this->theQuery($query);
        	 $row = mysqli_fetch_array($result);
		     foreach($names_arr as $name){
					 $query ="insert into group_members values(null, '', '$name', '0', '$row[g_id]' )";
				     $this->theQuery($query);			
		            }
			 $feedback = "You have successfully created a group";
			 echo json_encode($feedback);
		 }else{
			  $feedback = "An error occured while creating your group!!";
			  echo json_encode($feedback);
		 }
	 }  


     public function show_your_pics($username){
		$query="select * from user_pictures where username = '$username'";
		$num =$this->numOfRows($query);
		$feedback = '';
		
		$feedback .= "<div class='form_pic'>             
            <form method='post' action='' enctype='multipart/form-data' >            
                <div class='makeRow'>                    
                    <div class='cam_ico'>  
                        <div class='media'><input type='file' class='mediaPic' id='files' name='files[]' multiple></div>
                    </div>
                    <input type='hidden' name='mode' value='multi_photos' >
                    <input type='submit'  id='add_photos' class='fchange change' name='changePro' value='Add Photos'>
                </div>
            </form> 
        </div>

        <div id='preview'></div>";

		$feedback .= '<div class="my_pers_pics">';
		
		if($num > 0){
		  $result=$this->theQuery($query);
		  while($row = mysqli_fetch_row($result)){

			if(strpos($row[2],'**') != 0){
				$pics = explode('**', $row[2]);
				foreach($pics as $pic){
					$feedback .= "<div class='pic_cov'>"."<img src='photos/$pic' >"."</div>";
				}
			}else{
				$feedback .= "<div class='pic_cov'>"."<img src='photos/$row[2]' >"."</div>";
			}			
		  }
		}else{
			$feedback .= '<div class="no_pics">No Pictures Yet</div>';
		}
		$feedback .= '</div>';
		echo $feedback;
	 }


	 public function show_prof_details($username){
		$query="select * from chat_members where username = '$username'";
		$result=$this->theQuery($query);
		$row = mysqli_fetch_row($result);
    
		$feedback = '';

		$feedback .= "<div class='prof_item_big'>
    	<div class='img_lab'>
       	 	<div class='edit_pro'><img src='icons/edit.png' class='edit_sign'/></div>
       	 	<div class='titleHead lab'>Firstname</div>
         	<div class='descriMy'>  $row[1]</div>
    	</div>       
        <div class='edit_frm_now'>
             <form class='MyProfile hideFrm'>
                   <input type='hidden' name='username' value='$username' />
                   <input type='hidden' name='mode' value='update_profile'/>
                   <input type='hidden' name='column' value='firstname'/>
                   <input type='text' class='FtextPro' name='value' placeholder='edit firstname'>
                   <input type='submit' class='change' value='Update'>
             </form>  
        	</div>
    	</div>";

		$feedback .= "<div class='prof_item_big'>
    	<div class='img_lab'>
        	<div class='edit_pro'><img src='icons/edit.png' class='edit_sign'/></div>
        	<div class='titleHead lab'>Lastname</div>
        	<div class='descriMy'>  $row[2]</div>
    	</div> 
    	<div class='edit_frm_now'>   
         <form class='MyProfile hideFrm'>
                <input type='hidden' name='username' value='$username'/>
                <input type='hidden' name='mode' value='update_profile'/>
                <input type='hidden' name='column' value='lastname'/>
                <input type='text' class='FtextPro' name='value' placeholder='edit lastname'>
                <input type='submit' class='change' value='Update'>
          </form>  
    	 </div>      
		</div>";


		$feedback .= "<div class='prof_item_big'>
    	<div class='img_lab'>       
        	<div class='edit_pro'><img src='icons/edit.png' class='edit_sign'/></div>
        	<div class='titleHead lab'>Gender</div>
        	<div class='descriMy'>  $row[6]</div>
    	</div>
    	<div class='edit_frm_now'>     
         <form class='MyProfile  hideFrm'>
                <input type='hidden' name='username' value='$username'/>
                <input type='hidden' name='mode' value='update_profile'/>
                 <input type='hidden' name='column' value='gender'/>                   
                   <div class='s_gender'>
                   <input type='radio' value='Male' class='male maleR' id='male' name='value'  />
                   <label for='male' class='genderR genColor'>Male</label>
                   <input type='radio' value='Female' class='female femaleR' id='female' name='value' checked/>
                   <label for='female' class='genderR genColor'>Female</label>
                   <input type='submit' class='change chanProGe' value='Update'>
                   </div>                  
             </form>  
             </div>      
        </div>";

		$feedback .= "<div class='prof_item_big'>
        <div class='img_lab'>
       		 <div class='edit_pro'><img src='icons/edit.png' class='edit_sign'/></div>
        	 <div class='titleHead lab'>Email</div>
        	 <div class='descriMy'>  $row[5]</div>
    	</div> 
    	<div class='edit_frm_now'>         
             <form class='MyProfile hideFrm'>
                   <input type='hidden' name='username' value='$username'/>
                   <input type='hidden' name='mode' value='update_profile'/>
                   <input type='hidden' name='column' value='email'/>
                   <input type='text' class='FtextPro' name='value' placeholder='edit Email'>
                   <input type='submit' class='change' value='Update'>
             </form> 
            </div>       
        </div>";

		$dob = $this->show_date($row[7]);
        $feedback .= "<div class='prof_item_big'>
    	<div class='img_lab'>
        	<div class='edit_pro'><img src='icons/edit.png' class='edit_sign'/></div>
        	<div class='titleHead lab'>D.O.B</div>
        	<div class='descriMy'>$dob</div>
    	</div>  
    	<div class='edit_frm_now'>  
             <form class='MyProfile hideFrm'>
                   <input type='hidden' name='username' value='$username'/>
                   <input type='hidden' name='mode' value='update_dob'/>
                   <input type='hidden' name='column' value='dob'/>                   
                   <div class='dobP'>
                    <input type='text' name='day' placeholder='dd' maxlength='2' class='dayP'  required />
                    <input type='text' name='month' placeholder='mm' maxlength='2' class='monthP'  required />
                    <input type='text' name='year' placeholder='year' maxlength='4' class='yearP' required />
                    <input type='submit' class='change' value='Update'>
                    </div>                   
             </form> 
            </div>
        </div>";

		$hd = $this->init_space($row[10]);    
    	$feedback .= "<div class='prof_item_big'>
     	<div class='img_lab'>
            <div class='edit_pro'><img src='icons/edit.png' class='edit_sign'/></div>
            <div class='titleHead lab'>Home Address</div>
            <div class='descriMy'>$hd</div>
   		</div>  
   	    <div class='edit_frm_now'>
                 <form class='MyProfile hideFrm'>
                    <input type='hidden' name='username' value='$username'/>
                    <input type='hidden' name='mode' value='update_profile'/>
                    <input type='hidden' name='column' value='home_address'/>
                    <input type='text' class='FtextPro' name='value' placeholder='edit home address'>
                    <input type='submit' class='change' value='Update'>
            </form> 
           </div>        
        </div>"; 
		
		$wyd = $this->init_space($row[12]);
        $feedback .= "<div class='prof_item_big'>
        <div class='img_lab'>
            <div class='edit_pro'><img src='icons/edit.png' class='edit_sign'/></div>
            <div class='titleHead lab'>What You Do</div>
            <div class='descriMy'>  $wyd </div>
        </div> 
        <div class='edit_frm_now'>   
                 <form class='MyProfile hideFrm'>
                    <input type='hidden' name='username' value='$username'/>
                    <input type='hidden' name='mode' value='update_profile'/>
                    <input type='hidden' name='column' value='Profession'/>
                    <input type='text' class='FtextPro' name='value' placeholder='what you do'>
                    <input type='submit' class='change' value='Update'>
            </form>
            </div>        
        </div>"; 
		 

		$ms = $this->init_space($row[13]);
        $feedback .= "<div class='prof_item_big'>
        <div class='img_lab'>
            <div class='edit_pro'><img src='icons/edit.png' class='edit_sign'/></div>
            <div class='titleHead lab'>Marital Status</div>
            <div class='descriMy'>  $ms </div>
        </div> 
        <div class='edit_frm_now'>     
                 <form class='MyProfile hideFrm'>
                    <input type='hidden' name='username' value='$username'/>
                    <input type='hidden' name='mode' value='update_profile'/>
                    <input type='hidden' name='column' value='marital_status'/>
                    <input type='text' class='FtextPro' name='value' placeholder='edit marital status'>
                    <input type='submit' class='change' value='Update'>
            </form> 
            </div>       
        </div>"; 
		
		$sd = $this->init_space($row[11]);
        $feedback .= "<div class='prof_item_big'>
        <div class='img_lab'>
            <div class='edit_pro'><img src='icons/edit.png' class='edit_sign'/></div>
            <div class='titleHead lab'>self description</div>
            <div class='descriMy'>  $sd </div>
        </div>
        <div class='edit_frm_now'>    
                 <form class='MyProfile hideFrm'>
                    <input type='hidden' name='username' value='$username'/>
                    <input type='hidden' name='mode' value='update_profile'/>
                    <input type='hidden' name='column' value='about_you'/>
                    <input type='text' class='FtextPro' name='value' placeholder='edit self description'>
                    <input type='submit' class='change' value='Update'>
            </form> 
            </div>       
        </div>"; 

		echo $feedback;
	 }

	 public function sideGroups($username){
		$results ='';

		$results .= "<div class='chts_header'>Groups</div>
		<form action='groups.php' method='get' >
		<input type='text' name='group_name' required class='create_g_form'placeholder='Create Group'/>
		<input type='hidden' name='gid' value='create' />
		<input type='submit' class='post_submit cr_gr' value='Create' />
		</form>";		
		
		$fixed_id = array();
		$query = "select fixed_id from group_members where username ='$username'";
		$result = $this->theQuery($query);
		
		while($row = mysqli_fetch_row($result)){
			$fixed_id[] .= $row[0];
		 }
		
		if(empty($fixed_id)){
		  $results .= "<h4 class='NoMsgs'>?) There are no GROUP CHATS yet (?</h4>"; 
		}else{
			  foreach($fixed_id as $id){
					  $query = "select group_name from group_name where fixed_id ='$id'";
					  $result = $this->theQuery($query);
					  $row = mysqli_fetch_row($result);
					  $results .= '<div class="parent_cover_group">';             
		
					  $results .= '<div class="g_pic">'."<a href='groups.php?gid=$id'>".'<img src="icons/group.png">'.'</a></div>';
		
					  $query2 = "select message from group_messages where fixed_id ='$id' order by msg_id desc";
					  $last_msg = $this->theQuery($query2);
					  $msg = mysqli_fetch_row($last_msg);
					  $num_of_messages = $this->numOfRows($query2);
					  if($num_of_messages < 1){
						 $val="";
					  }else{
							$val = $this->substring($msg[0], 25);
					  }
			
					  
					  $results .= '<div class="gname_gmsg">';
					  $results .=        "<a href='groups.php?gid=$id'>";
					  $results .=        "<div class='g_name'>".$row[0]."</div>";
					  $results .=        "<div class='last_message'>$val</div>";
					  $results .=        '</a></div>';    
					  $results .= "</div>";         
				}
		 }
		
		echo $results;
	 }

	  

	 














	
	
	
	
	
}

?>