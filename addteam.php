<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();
check_supperuser();
?>


<?php
     include_once("includes/form_functions.php");

//////////////////////addteam\\\\\\\\\\\\\\\\\\\\\\\\\\
if (array_key_exists('addteam', $_POST)) {
    $errors = array();
   	$ctname = trim(($_POST['ctname']));
    $EMCID = trim(($_POST['EMCID']));
    $courseyear = trim(($_POST['courseyear']));
	$coursesemester = trim(($_POST['coursesemester']));

	//this function is defined in include/function.php
	$CID= mysql_one_data("SELECT CID FROM course WHERE course.EMCID = ".$_POST['EMCID']." AND course.year=".$_POST['courseyear']." AND course.semester='".$_POST['coursesemester']."'");
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
							'".$ctname."','".$CID."'
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
?>
<?php include('includes/header.php'); ?>
<!----------------------------------------form-------------------------------------->
<br/></br><h3> Team creation </h3></br>
<form name="addteam" action="addteam.php#tabs-1" method="post">
 <table align='center'>
<tr><td>Team name:<br/><input type="text" name="ctname" /></td>
 <td>
<?php
     $result = mysqli_query($connection,"SELECT * FROM emcourse order by cname asc");
	echo "Course Name:<br/>   <select name=EMCID value='' id='coursename'><option value=''>-----Select one-----</option>";
    while($nt=mysqli_fetch_assoc($result)){echo "<option value=".$nt['EMCID'].">".$nt['cname']."</option>";}
    echo "</select>";
?>
 </td>
 <td> <?php echo dropyear();?></td>
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

	 $str ="SELECT * FROM course, courseteam WHERE course.EMCID = ".$_POST['EMCID']." AND courseteam.CID = course.CID AND course.year=".$_POST['courseyear']." AND course.semester='".$_POST['coursesemester']."'   ORDER BY courseteam.ctname";
     //$eid = $_SESSION['user_id'];
     $result = mysqli_query($connection,$str);
     $tbstr ="";
     $tbstr .= "<table border= '1' align='center'>";
     $tbstr .= "<tr><th><b>Team Name</b></th><th><b>Delete</b></th><th><b>Add Member</b></th></tr>";
     while($row = mysqli_fetch_assoc($result))
  {
    $tbstr .= "<tr><td>";
    $tbstr .= "<a href='#' style='text-decoration:none'>".$row['ctname']."</a>";
    $tbstr .= "</td><td>";
    $tbstr .= "<a href='#' style='text-decoration:none'>Delete</a>";
    $tbstr .= "</td><td>";
    		$tbstr .= "<a href='addstudents.php?CTID=".$row['CTID']."&CID=".$row['CID']."&EMCID=".$_POST['EMCID']."&courseyear=".$_POST['courseyear']."&coursesemester=".$_POST['coursesemester']."&coursename=".$row['ctname']."'>Add Members</a>";
	$tbstr .= "</td></tr>";
  }
  $tbstr .= "</table><br/>";
  echo $tbstr;
?>

<?}?>

<script>
function setSelectedIndex(s, valsearch){
// Loop through all the items in drop down list
for (i = 0; i< s.options.length; i++){ 
if (s.options[i].value == valsearch){
// Item is found. Set its property and exit
s.options[i].selected = true;
break;}
}
return;
}
setSelectedIndex(document.getElementById("coursename"),"<?echo $_POST['EMCID']; ?>");
if(<?echo $_POST['courseyear']; ?> == '')
    setSelectedIndex(document.getElementById("courseyear"),"<? echo date('Y'); ?>");
else
    setSelectedIndex(document.getElementById("courseyear"),"<?echo $_POST['courseyear']; ?>");
setSelectedIndex(document.getElementById("coursesemester"),"<?echo $_POST['coursesemester']; ?>");
</script>
 
      
       <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
       <?php if (!empty($errors)) { display_errors($errors); }?>

<?php include('includes/footer.php'); ?>