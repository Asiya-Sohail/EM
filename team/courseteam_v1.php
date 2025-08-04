<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();?>


<?php
     include_once("includes/form_functions.php");

//in this page we have Two different form with Two hidden file to keep track of which form is posted

//////////////////////changing profile\\\\\\\\\\\\\\\\\\\\\\\\\\
if (array_key_exists('addteam', $_POST)) {
    $errors = array();
   	$ctname = trim(mysql_prep($_POST['ctname']));
    $EMCID = trim(mysql_prep($_POST['EMCID']));
    $courseyear = trim(mysql_prep($_POST['courseyear']));
	$coursesemester = trim(mysql_prep($_POST['coursesemester']));

	//this function is defined in include/function.php
	$CID= mysql_one_data("SELECT CID FROM course WHERE course.EMCID = {$_POST['EMCID']} AND course.year={$_POST['courseyear']} AND course.semester='{$_POST['coursesemester']}'");
	//echo $CID;
	if ($CID==''){$errors[] = 'The selected class is not activated for the selected semester.'; }
	
	if($ctname == '') { $errors[] = 'Team name is missing'; }
	if($EMCID == '') { $errors[] = 'Course name is missing'; }
	if($courseyear == '') { $errors[] = 'Year is missing'; }
	if($coursesemester == '') { $errors[] = 'Semester is missing'; }
	//check for duplicate team name
	
	if($ctname != '') {
    $qry = "SELECT * FROM courseteam WHERE ctname='$ctname' AND CID='$CID'";
		$result = mysqli_query($connection,$qry);
		//echo $result['CID'];
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				$errors[] = 'Team already in use, Please chose another team name';
       	mysqli_close($connection);
      }
		}
		else {
			die("Query failed");
		}
	}
	//if there is no error now we can enter the data in courseteam table
	
	
	
	
	
		if ( empty($errors) ) {
			$query = "INSERT INTO courseteam (
							ctname,CID
						) VALUES (
							'{$ctname}','{$CID}'
						)";
			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "The Team successfully created.";
			} else {
				$message = "The Team could not be created.";
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
		//if($_GET["action"]=='delete'){
		//echo "boo000000000ok";
		//echo $_GET["action"];
		//}else{//echo "NOOOOOOOOOOOO";}
		if(!empty($_GET["CID"]) and !empty($_GET["CTID"])){
			$_SESSION['CTID']=$_GET['CTID'];
			$_SESSION['CID']=$_GET['CID'];
		}//else {//this still might happen in the first talb}
		
		
		
		
		
		
		
//////////////////////---Adding Members to the team---\\\\\\\\\\\\\\\\\\\\\\\\
if (array_key_exists('addmember', $_POST)) {
//echo "you are trying to change password";
		$errors = array();
		$EID = trim(mysql_prep($_POST['EID']));
		$CTID= $_SESSION['CTID'];
		if($EID == '') { $errors[] = 'You need to select a person to add to the team'; }
		if($CTID == '') { $errors[] = 'No Team is being selected'; }
		echo $EID.''.$CTID;
		//check for duplicate team name
		
		if($EID != '') {
			$qry = "SELECT * FROM cmteam WHERE EID='{$EID}' AND CTID='{$CTID}'";
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
							'{$EID}','{$CTID}'
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





<?php include('includes/header.php'); ?>

<!--/////////////////////////////********************form**************************\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Create a team</a></li>
		<li><a href="#tabs-2">Add students</a></li>
	</ul>
	
<div id="tabs-1"><!--********************----------Begining of tab 1------------*******************-->
</br><h3> Team creation </h3></br>
<form name="addteam" action="courseteam.php#tabs-1" method="post">
 <table align='center'>
<tr><td>Team name:<br/><input type="text" name="ctname" /></td>
 <td>
<?php
     $result = mysql_query("SELECT * FROM emcourse order by cname asc");
	echo "Course Name:<br/>   <select name=EMCID value='' id='coursename'><option value=''>-----Select one-----</option>";
    while($nt=mysql_fetch_array($result)){echo "<option value=$nt[EMCID]>$nt[cname]</option>";}
    echo "</select>";
?>
 </td>
 <td> <?echo dropyear();?></td>
<td>Semester:<br/>  <select name="coursesemester" type="text" class="textfield" id="coursesemester"><option value="">-----Select one-----</option><option value="Fall">Fall</option><option value="Winter">Winter</option><option value="Spring">Spring</option><option value="Summer">Summer</option></select> </td>
</td></tr>
<tr><td colspan="4" align="center">  <input type="submit" name="submit" value="Create a team" /> </td></tr>
</table>
</br></br>
<input type="hidden" name="addteam" value="1"/>
</form>


<?
if(isset($_POST['submit'])){
//echo $_POST['EMCID'].'-'.$_POST['courseyear'].'-'.$_POST['coursesemester'];

	     $str ="";
     $str .="SELECT * FROM course, courseteam WHERE course.EMCID = {$_POST['EMCID']} AND courseteam.CID = course.CID AND course.year={$_POST['courseyear']} AND course.semester='{$_POST['coursesemester']}'   ORDER BY courseteam.ctname";
     //$eid = $_SESSION['user_id'];
     $result = mysqli_query($connection,$str);
     $tbstr ="";
     $tbstr .= "<table border= '1' align='center'>";
     $tbstr .= "<tr><th><b>Team Name</b></th><th><b>Delete</b></th><th><b>Add Member</b></th></tr>";
     while($row = mysqli_fetch_assoc($result))
  {
    $tbstr .= "<tr><td>";
    $tbstr .= "<a href='courseteam.php?action=delete#tabs-2'>".$row[ctname]."</a>";
    $tbstr .= "</td><td>";
    $tbstr .= "<a href='courseteam.php?action=delete&CTID=".$row[CTID]."#tabs-1'>Delete</a>";
    $tbstr .= "</td><td>";
    $tbstr .= "<a href='courseteam.php?CTID=".$row[CTID]."&CID=".$row[CID]."#tabs-2'>Add Members</a>";
	$tbstr .= "</td></tr>";
  }
  $tbstr .= "</table><br/>";
  echo $tbstr;
?>


<?}?>

<script>
function setSelectedIndex(s, valsearch)
{
// Loop through all the items in drop down list
for (i = 0; i< s.options.length; i++)
{ 
if (s.options[i].value == valsearch)
{
// Item is found. Set its property and exit
s.options[i].selected = true;
break;
}
}
return;
}
setSelectedIndex(document.getElementById("coursename"),"<?echo $_POST['EMCID']; ?>");
setSelectedIndex(document.getElementById("courseyear"),"<?echo $_POST['courseyear']; ?>");
setSelectedIndex(document.getElementById("coursesemester"),"<?echo $_POST['coursesemester']; ?>");
</script>
</div><!--********************----------End of tab 1------------*******************-->



<div id="tabs-2"><!--********************----------Begining of tab 2------------*******************-->

<h2 >Search a team that you want to add members to it.</h2><br/>

<form name="searchteam" action="courseteam.php#tabs-2" method="post">
 <table align='center'>
<tr><td>
<?php
     $result = mysqli_query($connection,"SELECT * FROM emcourse order by cname asc");
	echo "Course Name:<br/>   <select name=EMCID value='' id='coursename'><option value=''>-----Select one-----</option>";
    while($nt=mysqli_fetch_assoc($result)){echo "<option value=$nt[EMCID]>$nt[cname]</option>";}
    echo "</select>";
?>
</td>
 <td> <?echo dropyear();?></td>
<td>Semester:<br/>  <select name="coursesemester" type="text" class="textfield" id="coursesemester"><option value="">-----Select one-----</option><option value="Fall">Fall</option><option value="Winter">Winter</option><option value="Spring">Spring</option><option value="Summer">Summer</option></select> </td>
</td></tr>
<tr><td colspan="4" align="center">  <input type="submit" name="submit" value="Create a team" /> </td></tr>
</table>
</br></br>
<input type="hidden" name="searchteam" value="1"/>
</form>




<?
if (array_key_exists('searchteam', $_POST)) {echo "searched";
}
?>



<hr />



<form name="addmember" action="courseteam.php#tabs-2" method="post">
<table align='center'>
<tr><td>
<?php
	//$_SESSION['CTID']=$_GET['CTID'];
	//$_SESSION['CID']=$_GET['CID'];
	
     $result = mysqli_query($connection,"SELECT * FROM coursemember WHERE CID = {$_SESSION['CID']} order by EID asc");
     echo "Student Name:<br/>   <select name=EID value='' ><option value=''>-----Select one-----</option>";
      while($nt=mysqli_fetch_assoc($result)){
	   $student = "<option value=$nt[EID]>";
	   $lastname = getmember($nt[EID]);
	   $student .= $lastname['lastname'].$lastname['lastname'];
	   $student .="</option>";
	   echo $student;
	  }
      echo "</select>";
?>
</td>
<td> <input type="submit" name="submit" value="Add this student to the team" /></td></tr>
</table>
<input type="hidden" name="addmember" value="1"/>


<?
	 $str ="";
	 echo $CTID;
     $str .="SELECT * FROM cmteam, member, courseteam WHERE cmteam.CTID = {$CTID} AND member.EID=cmteam.EID AND courseteam.CTID=cmteam.CTID";
     $result = mysqli_query($connection,$str);
     $tbstr ="";
     $tbstr .= "<table border= '1' align='center'>";
     $tbstr .= "<tr><th><b>Student Name</b></th><th><b>Team Name</b></th><th><b>Course Code</b></th></tr>";
     while($row = mysqli_fetch_assoc($result))
  {
    $tbstr .= "<tr><td>";
    $tbstr .= $row[firstname].'-'.$row[lastname].'-'.$row[username];
    $tbstr .= "</td><td>";
    $tbstr .= $row[ctname];
    $tbstr .= "</td><td>";
    $tbstr .= $row[CID];
	$tbstr .= "</td></tr>";
  }
  $tbstr .= "</table><br/>";
  echo $tbstr;
?>


</form>


</div><!--********************----------End of tab 2------------*******************-->


</div><!--********************----------End of Tabs------------*******************-->
 
 
 
       <?php//you should use tab otherwise your template doesn't work ?>
       <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
       <?php if (!empty($errors)) { display_errors($errors); }?>

<?php include('includes/footer.php'); ?>