<?php
require_once("includes/connection.php");
	session_start();
	
	function logged_in() {
		return isset($_SESSION['user_id']);
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}
	
	function check_supperuser()
	{
	$connection = mysqli_connect('localhost','root','','emuem001_emuem');	
     $eid = $_SESSION['user_id'];
     $result = mysqli_query($connection,"Select EID, supperuser From member WHERE EID='$eid'");
     $row = mysqli_fetch_assoc($result);
     if ($row['supperuser']==0){ redirect_to("login.php");}
  }

	function ruadmin()
	{
	 $connection = mysqli_connect('localhost','root','','emuem001_emuem');	
     $eid = $_SESSION['user_id'];
     $result = mysqli_query($connection,"Select EID, supperuser From member WHERE EID='$eid'");
     $row = mysqli_fetch_assoc($result);
     //if ($row['supperuser']==0){ return false;}
     return $row['supperuser'];
     //echo   $row['supperuser'];
  }
?>
