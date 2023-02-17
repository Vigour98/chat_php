<?php

$past_time=1648732963;

$time_ago=time()-$past_time;


echo $time_ago."<br>";


if($time_ago < 60)
  {	
   if($time_ago==1)
    {
     echo $time_ago." second ago";
	}
   else
	   {
		echo $time_ago." seconds ago";	
	   }
  }
elseif($time_ago < 3600)
      {
	   $time=floor($time_ago/60);
	   if($time==1)
         {
          echo $time." minute ago";
	     }
	    else
	        {
		     echo $time." minutes ago";
		    } 	   
       }
elseif($time_ago < 86400 )
      {
	   $time=floor($time_ago/3600);	  
	   if($time==1)
         {
          echo $time." hour ago";
	     }
	    else
	        {
		     echo $time." hours ago";
		    }
      }
elseif($time_ago < 604800 )
      {
	   $time=floor($time_ago/86400);	   
	   if($time==1)
         {
          echo $time." day ago";
	     }
	    else
	        {
		     echo $time." days ago";
		    }
      }
elseif($time_ago < 2592000 )
      {
	   $time=floor($time_ago/604800);
	   if($time==1)
         {
          echo $time." week ago";
	     }
	    else
	        {
		     echo $time." weeks ago";
		    }
      }
elseif($time_ago < 31536000 )
      {
	   $time=floor($time_ago/2592000);
	   if($time==1)
         {
          echo $time." month ago";
	     }
	    else
	        {
		     echo $time." months ago";
		    }
      }
elseif($time_ago >= 31536000 )
      {
	   $time=floor($time_ago/31536000);
	   if($time==1)
         {
          echo $time." year ago";
	     }
	    else
	        {
		     echo $time." years ago";
		    }
      }
	  
	  
	  
	  
	  

?>



<style>
div{
	background:red;
}
</style>
<div style="width:50%">
koki
</div>







<form method="post"  action="demo.php" enctype='multipart/form-data'>    
<div class='media'><input type='file' class='mediaPic' name='media' /></div>
<input type="submit" name="submit" id="submit" class="post_submit"  value="POST" />				
</form>	

<?php 

if(isset($_FILES['media']['name'])){
	$media_name = $_FILES['media']['name']; 	  
	$saveto = "posts_media/".$media_name;				
	move_uploaded_file($_FILES['media']['tmp_name'], $saveto);		
		
	}



?>














