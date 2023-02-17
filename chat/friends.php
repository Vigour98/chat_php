<?php 
$title="See your Associates and find new ones!";
include_once("Vichat.php");
include_once("header.php");
$username = $_SESSION['username'];
$members = new Vichat();
?>
<script type="text/javascript">
$(document).ready(function(){

 var username=$('#usernameFri').html(); 

 function outgoingRequests(username){ 	
 var data="mode="+"outgoingReqs"+"&username="+username;  
 $.ajax({
		 url:"ajax_to_php.php",
		 data: data,
		 method:"POST",
		 success:function(response){           		 
     	  $('.asc_recv').html(response);			  
		  },
     error:function(response){
        alert(response.error);
        }
	    });
}

function incomingRequests(username){ 	
 var data="mode="+"incomingReqs"+"&username="+username;  
 $.ajax({
		 url:"ajax_to_php.php",
		 data: data,
		 method:"POST",
		 success:function(response){           		 
     	  $('.asc_req').html(response);			  
		  },
     error:function(response){
        alert(response.error);
        }
	    });
}

function yourConnects(username){ 	
 var data="mode="+"yourConnects"+"&username="+username;  
 $.ajax({
		 url:"ajax_to_php.php",
		 data: data,
		 method:"POST",
		 success:function(response){           		 
     	  $('.the_assoc').html(response);			  
		  },
     error:function(response){
        alert(response.error);
        }
	    });
}

function possibleConnects(username){ 	
 var data="mode="+"possibleConnects"+"&username="+username;  
 $.ajax({
		 url:"ajax_to_php.php",
		 data: data,
		 method:"POST",
		 success:function(response){           		 
     	  $('.sendaxcR').html(response);			  
		  },
     error:function(response){
        alert(response.error);
        }
	    });
}
possibleConnects(username);
 
$(document).on('submit','.assoc_req',function(){
event.preventDefault();		
$(this).ajaxSubmit({
 method:"POST",
 url:"ajax_to_php.php",   
 dataType: "json",
 success:function(response){
  if(!response.error){	 
	 
	  }
  },
 error:function(response){
  alert(response.error);
  }
 });
}); 

$(document).on('submit','.revCon',function(){ 
event.preventDefault();		
$(this).ajaxSubmit({
 method:"POST",
 url:"ajax_to_php.php",   
 dataType: "json",
 success:function(response){
  if(!response.error){	 
	  	 
	 }
  },
 error:function(response){
  alert(response.error);
  }  
 });
});
 

$(document).on('submit','.accpt_assoc',function(){
event.preventDefault();		
$(this).ajaxSubmit({
 method:"POST",
 url:"ajax_to_php.php",   
 dataType: "json",
 success:function(response){
  if(!response.error){	 
	 	 
	  }
  },
 error:function(response){
  alert(response.error);
  }
 });
}); 

$(document).on('submit','.canc_assoc',function(){  
event.preventDefault();		
$(this).ajaxSubmit({
 method:"POST",
 url:"ajax_to_php.php",   
 dataType: "json",
 success:function(response){
  if(!response.error){	 
	  	 
	 }
  },
 error:function(response){
  alert(response.error);
  }
  
 });
});

$(document).on('click','.canc_button',function(){
  var button = $(this).parent().parent().parent().hide('slow'); 
});

var conn = $('.the_assoc');
var req = $('.asc_req');
var reqv = $('.asc_recv');
var pot = $('.sendaxcR');
let arr = [conn, req, reqv, pot];

var inc = $('.inc_button');
var outc = $('.outc_button');
var pot = $('.pot_button');
var con = $('.con_button');
let arr2 = [inc, outc, pot, con];

$('.hover_conn ul li').click(function(){  
   var cur = $(this).attr("class");

   for(j=0; j<arr2.length; j++){
    arr2[j].css({background:'radial-gradient(rgb(226, 236, 236),rgb(206, 114, 9))',color:'black'});
   }
   
   $(this).css({background:'black',color:'rgb(228, 117, 11)'});

   for(i=0; i<arr.length; i++){  
    if(arr[i].hasClass("conn_show") == true){
      arr[i].removeClass("conn_show")
      }
   }

    if($(this).hasClass("inc_button") == true){
      $('.asc_req').addClass("conn_show");
      incomingRequests(username);
    }

    if($(this).hasClass("outc_button") == true){
      $('.asc_recv').addClass("conn_show");
      outgoingRequests(username);           
    }

    if($(this).hasClass("pot_button") == true){
      $('.sendaxcR').addClass("conn_show"); 
      possibleConnects(username);     
    }

    if($(this).hasClass("con_button") == true){
      $('.the_assoc').addClass("conn_show");
      yourConnects(username);      
    } 
    
    

});// end of the $(.hover_conn ul li') click function
 
 
}); //the end of the ready statement
</script>

<div id='usernameFri'><?php echo $username ?></div>

<div class="the_page">
<?php include_once("user_header.php"); ?>

<div class="home_contents">	     
       
<div class='list_friends'>

     <div class='hover_conn'>
      <ul>
        <li class="pot_button">Potential Connects</li>
        <li class="inc_button">Incoming Connect Request</li>
        <li class="outc_button">Your Connect Request</li>        
        <li class="con_button">Your Connects</li>
      </ul>  
      </div><!-- end of class <hover_conn> -->

       <div class='the_assoc'></div>       
       <div class='asc_req'></div>	  
       <div class='asc_recv'></div>
       <div class='sendaxcR conn_show'></div>

      
       
       

        <div class='f_fotos'>
          <h6>Friends Photos</h6>          

          <?php 
          $friends = ($members->yourConnects($username)); 
          foreach ($friends[2] as $friend){
            if($friend != ""){
              $query="select gender, propic from chat_members where username = '$friend' ";
              $result=$members->theQuery($query);
		          $row = mysqli_fetch_row($result);			
              $pic = $members->checkProfile($row[1],$row[0]); 
              ?>
              <img src='propics/<?php echo $pic ?>'  />
              <?php              
            }
          }
          


          ?>
          


        </div><!-- end of class<f_fotos> -->


		</div><!-- end of class <list_friends -->
  </div><!-- end of class <home_contents> -->
</div><!-- end of class <the_page> -->
