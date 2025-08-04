<?php require_once('includes/session.php'); 
 require_once("includes/connection.php"); 
 require_once('includes/functions.php'); 
 confirm_logged_in();
 include_once("includes/form_functions.php");
 check_supperuser();
?>


<?php	
$deleteQuery = "";
if(isset($_REQUEST['deleteteam']) && $_REQUEST['deleteteam'] !=''){
    $delquery = "DELETE FROM `courseteam` WHERE CTID = ".$_REQUEST['deleteteam'];
    if(mysqli_query($connection,$delquery))
        $deleteQuery = 'Team was deleted.';
}
//////////////////////---Adding Members to the team---\\\\\\\\\\\\\\\\\\\\\\\\
if (array_key_exists('addmember', $_POST)) {
		$errors = array();
		$EID = trim(($_POST['EID']));
		$CTID= $_SESSION['CTID'];
		if($EID == '') { $errors[] = 'You need to select a person to add to the team'; }
		if($CTID == '') { $errors[] = 'No Team is being selected'; }
		//echo $EID.''.$CTID;
		//check for duplicate member name
		if($EID != '') {
			$qry = "SELECT * FROM cmteam WHERE EID='$EID' AND CTID='$CTID'";
			$result = mysqli_query($connection,$qry);
			if($result) {
				if(mysqli_num_rows($result) > 0) {$errors[] = 'Selected student is already part of this team.';}
			} else {die("Query failed");}
		}		
		if ( empty($errors) ) {
			$query = "INSERT INTO cmteam (EID,CTID) VALUES ('$EID','$CTID')";
			$result = mysqli_query($connection,$query);
			if ($result) {$message = "The student successfully Added to this team.";
				$updateresult = mysqli_query($connection,"UPDATE courseteam SET nummembers = nummembers+1  WHERE CTID='$CTID'");
				//if ($updateresult){echo "Congratualation";}else{echo mysql_error();}
			}else{
				$message = "The addition could not be created.";$message .= "<br />" . mysqli_error($connection);
			}
		} else {
			if (count($errors) == 1) {$message = "There was 1 error in the form.";} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}
}
?>
<?		if(!empty($_GET["CID"]) and !empty($_GET["CTID"])){
			$_SESSION['CTID']=$_GET['CTID'];
			$_SESSION['CID']=$_GET['CID'];
		}		
?>
<!--------------------------------------Header------------------------------------->
<?php include('includes/header.php'); ?>
<!--------------------------------------form--------------------------------------->
<?php echo '<p id="deleteTxt">'.$deleteQuery.'</p>'; ?>
<h3>Step1. You need to select a team</h3>
<hr /><br/><br/>
<form name="searchteam" action="addstudents.php" method="POST">
	<table align='center'>
      <tr><td>
          <?php
              $result = mysqli_query($connection,"SELECT * FROM emcourse order by cname asc");
              echo "Course Name:<br/>   <select name=EMCID value='' id='coursename'><option value=''>-----Select one-----</option>";
              while($nt=mysqli_fetch_assoc($result)){echo "<option value=".$nt['EMCID'].">".$nt['cname']."</option>";}
              echo "</select>";
          ?>
          	</td>
          	<td> <?echo dropyear();?></td>
          	<td>Semester:<br/>  <select name="coursesemester" type="text" class="textfield" id="coursesemester"><option value="">-----Select one-----</option><option value="Fall">Fall</option><option value="Winter">Winter</option><option value="Spring">Spring</option><option value="Summer">Summer</option></select> 
          	</td>
			<td colspan="4" align="center">  <input type="submit" name="submit" value="Search teams" /> </td>
		</tr>
    </table>
    </br></br>
    <input type="hidden" name="searchteam" value="1"/>
</form>
<!--------------------------------return the selected teams in course-------------------------------------->
<?
if (array_key_exists('searchteam', $_POST)){
	$_SESSION['CTID']="";
	$_SESSION['CID']="";
     $str ="";
     $str .="SELECT * FROM course, courseteam WHERE course.EMCID = ".$_POST['EMCID']." AND courseteam.CID = course.CID AND course.year='".$_POST['courseyear']."' AND course.semester='".$_POST['coursesemester']."' ORDER BY courseteam.ctname";
     $result = mysqli_query($connection,$str);
     $tbstr ="";
     $tbstr .= "<table border= '0' align='center'>";
     $tbstr .= "<tr><th><b>Team Name</b></th><th><b>Delete</b></th><th><b>Add Member</b></th></tr>";
     while($row = mysqli_fetch_assoc($result)){
		$tbstr .= "<tr><td>";
		$tbstr .= "<a href='#' style='text-decoration:none'>".$row['ctname']."</a>";
		$tbstr .= "</td><td>";
		$tbstr .= "<a href='addstudents.php?deleteteam='".$row['CTID']."' style='text-decoration:none'>Delete</a>";
		$tbstr .= "</td><td>";
		$tbstr .= "<a href='addstudents.php?CTID=".$row['CTID']."&CID=".$row['CID']."&EMCID=".$_POST['EMCID']."&courseyear=".$_POST['courseyear']."&coursesemester=".$_POST['coursesemester']."&coursename=".$row['ctname']."'>Add Members</a>";
		$tbstr .= "</td></tr>";
  	}
 	$tbstr .= "</table><br/>";
  	echo $tbstr;
}?>
<!--------------------------------This section will be used for adding the students to the selected team-------------------------------------->
<h3>Step2. Now you need to select a student and add him to the groups</h3>
<form name="addmember" action="addstudents.php" method="post">
<table align='center'>
	<tr>
    	<td>
			<?php
                 $result = mysqli_query($connection,"SELECT * FROM coursemember WHERE CID = ".$_SESSION['CID']." order by EID asc");
                 echo "Student Name:<br/>   <select name=EID value='' ><option value=''>-----Select one-----</option>";
                 while($nt=mysqli_fetch_assoc($result)){
                     $student = "<option value=$nt[EID]>";
                     $lastname = getmember($nt['EID']);
                     $student .= $lastname['firstname']."  ".$lastname['lastname'];
                     $student .="</option>";
                     echo $student;
                 }
                 echo "</select>";
            ?>
		</td>
        <td> <input type="submit" name="submit" value="Add this student to the team" /></td>
	</tr>
</table>
<input type="hidden" name="addmember" value="1"/>

<input type="hidden" name="EMCID" value="<?if(!empty($_POST['EMCID'])){echo $_POST['EMCID'];}else{echo $_GET['EMCID'];} ?>"/>
<input type="hidden" name="courseyear" value="<?if(!empty($_POST['courseyear'])){echo $_POST['courseyear'];}else{echo $_GET['courseyear'];} ?>"/>
<input type="hidden" name="coursesemester" value="<?if(!empty($_POST['coursesemester'])){echo $_POST['coursesemester'];}else{echo $_GET['coursesemester'];} ?>"/>
</form>

<?
	echo "<br/><pre> Selected team name:        ".$_GET['coursename']."</pre><br/>";
	 $str ="";
     $str .="SELECT * FROM cmteam, member, courseteam WHERE cmteam.CTID = ".$_SESSION['CTID']." AND member.EID=cmteam.EID AND courseteam.CTID=cmteam.CTID";
     $result = mysqli_query($connection,$str);
     $tbstr ="";
     $tbstr .= "<table border= '1' align='center'>";
     $tbstr .= "<tr><th><b>Student Name</b></th><th><b>Team Name</b></th><th><b>Course Code</b></th></tr>";
     while($row = mysqli_fetch_assoc($result)){
		  $tbstr .= "<tr><td>";
		  $tbstr .= $row['firstname']."'-'".$row['lastname']."'-'".$row['username'];
		  $tbstr .= "</td><td>";
		  $tbstr .= $row['ctname'];
		  $tbstr .= "</td><td>";
		  $tbstr .= $row['CID'];
		  $tbstr .= "</td></tr>";
  	}
	$tbstr .= "</table><br/>";
	echo $tbstr;
?>



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
setSelectedIndex(document.getElementById("coursename"),"<?if(!empty($_POST['EMCID'])){echo $_POST['EMCID'];}else{echo $_GET['EMCID'];} ?>");
setSelectedIndex(document.getElementById("courseyear"),"<?if(!empty($_POST['courseyear'])){echo $_POST['courseyear'];}else{echo $_GET['courseyear'];} ?>");
setSelectedIndex(document.getElementById("coursesemester"),"<?if(!empty($_POST['coursesemester'])){echo $_POST['coursesemester'];}else{echo $_GET['coursesemester'];} ?>");
</script>

       <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
       <?php if (!empty($errors)) { display_errors($errors); }?>
<script>
    $(document).ready(function(){
        setTimeout(function(){
           $('#deleteTxt').hide(700); 
        },1000);
    })
</script>
<?php include('includes/footer.php'); ?>