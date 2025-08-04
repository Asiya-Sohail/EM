<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();?>


<?php
     include_once("includes/form_functions.php");

//in this page we have Two different form with Two hidden file to keep track of which form is posted
				
//////////////////////---Adding Members to the team---\\\\\\\\\\\\\\\\\\\\\\\\
if (array_key_exists('addmember', $_POST)) {
//echo "you are trying to change password";
		$errors = array();
		$EID = trim(($_POST['EID']));
		$CTID= $_SESSION['CTID'];
		if($EID == '') { $errors[] = 'You need to select a person to add to the team'; }
		if($CTID == '') { $errors[] = 'No Team is being selected'; }
		echo $EID.''.$CTID;
		//check for duplicate team name
		
		if($EID != '') {
			$qry = "SELECT * FROM cmteam WHERE EID='".$EID."' AND CTID='".$CTID."'";
			$result = mysqli_query($connection,$qry);
			if($result) {
				if(mysqli_num_rows($result) > 0) {
					$errors[] = 'Selected student is already part of this team.';
					//mysql_close($connection);
				}
			}
			else {
				die("Query failed");
				//$message= mysql_error();
			}
		}		
		if ( empty($errors) ) {
			$query = "INSERT INTO cmteam (
							EID,CTID
						) VALUES (
							'".$EID."','".$CTID."'
						)";
			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "The student successfully Added to this team.";
			} else {
				$message = "The addition could not be created.";
				$message .= "<br />" . mysqli_error($connection);
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}
}

?>

<?		if(!empty($_GET["CID"]) and !empty($_GET["CTID"])){
			$_SESSION['CTID']=$_GET['CTID'];
			$_SESSION['CID']=$_GET['CID'];
		}//else {//this still might happen in the first talb}
?>

<?php include('includes/header.php'); ?>

<!--/////////////////////////////********************form**************************\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->

<? if (array_key_exists('searchteam', $_POST)) {echo "searched";}?>
<hr />

<form name="addmember" action="courseteam.php#tabs-2" method="post">
<table align='center'><tr><td>
<?php
     $result = mysqli_query($connection,"SELECT * FROM coursemember WHERE CID = ".$_SESSION['CID']." order by EID asc");
     echo "Student Name:<br/>   <select name=EID value='' ><option value=''>-----Select one-----</option>";
      while($nt=mysqli_fetch_assoc($result)){
		 $student = "<option value=".$nt['EID'].">";
		 $lastname = getmember($nt['EID']);
		 $student .= $lastname['lastname'].$lastname['lastname'];
		 $student .="</option>";
		 echo $student;
	  }
      echo "</select>";
?>
</td><td> <input type="submit" name="submit" value="Add this student to the team" /></td></tr></table>
<input type="hidden" name="addmember" value="1"/>
<?
	 $str ="";
	 echo $CTID;
     $str .="SELECT * FROM cmteam, member, courseteam WHERE cmteam.CTID = ".$CTID." AND member.EID=cmteam.EID AND courseteam.CTID=cmteam.CTID";
     $result = mysqli_query($connection,$str);
     $tbstr ="";
     $tbstr .= "<table border= '1' align='center'>";
     $tbstr .= "<tr><th><b>Student Name</b></th><th><b>Team Name</b></th><th><b>Course Code</b></th></tr>";
     while($row = mysqli_fetch_assoc($result)){
		  $tbstr .= "<tr><td>";
		  $tbstr .= $row['firstname'].'-'.$row['lastname'].'-'.$row['username'];
		  $tbstr .= "</td><td>";
		  $tbstr .= $row['ctname'];
		  $tbstr .= "</td><td>";
		  $tbstr .= $row['CID'];
		  $tbstr .= "</td></tr>";
  	}
  $tbstr .= "</table><br/>";
  echo $tbstr;
?>
</form>
       <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
       <?php if (!empty($errors)) { display_errors($errors); }?>

<?php include('includes/footer.php'); ?>