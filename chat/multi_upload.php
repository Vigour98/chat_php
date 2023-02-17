<?php
include_once("Vichat.php");
$conn = new ViChat();
$username = $_POST['username'];

$countfiles = count($_FILES['files']['name']);
$upload_location = "photos/";
$files_arr = array();
$pic_names = array();

for($index = 0; $index < $countfiles; $index++){
	$filename = $_FILES['files']['name'][$index];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$valid_ext = array("png", "jpeg", "jpg");

	if(in_array($ext, $valid_ext)){
		$path = $upload_location.$filename;
		if(move_uploaded_file($_FILES['files']['tmp_name'][$index], $path)){
		   $files_arr[] = $path;
		   $pic_names[] = $filename;
				}
			}
		}
if($countfiles > 1){
  $files = implode('**',$pic_names);
}else{
  $files = $pic_names[0]; 	
}

$query = "insert into user_pictures values(null, '$username','$files')";
$result = $conn->theQuery($query);

echo json_encode($files_arr);
die;    
?>       