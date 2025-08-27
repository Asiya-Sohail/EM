<?php 
require_once("includes/connection.php");
function getmember($eid){
			$q = "select * from member where EID='".$eid."' LIMIT 1";	
			$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
              $result = mysqli_query($connection,$q);
			  $num_rows = mysqli_num_rows($result);
			  echo 'this is num of rows'.$num_rows;
              $row = mysqli_fetch_assoc($result);
			  echo 'this is function'.$q;
			  echo $row['firstname'];
              return $row;
 }
 
$_SESSION['user_id'] = 756;
$eid=$_SESSION['user_id'];

$row_1= getmember($eid); 
print_r($row_1);

?>