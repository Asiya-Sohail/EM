<?php ini_set('display_errors', 0);
ini_set('log_errors', 1);
?>

<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();?>
<?php //check_supperuser();?>
<?php include_once("includes/form_functions.php");?>

<?//$pos_id=$_SESSION['pos_id'];?>
<?php
//****************************************************************changing the main profile tab-1***************************************************************\\
if (array_key_exists('chprofile', $_POST)) {
$errors = array();
$errors="";
$message ="";
$studentID = trim(($_POST['studentID']));
$firstname = trim(($_POST['firstname']));
$lastname = trim(($_POST['lastname']));
$phone = trim(($_POST['phone']));
$email = trim(($_POST['email']));
$track = trim(($_POST['track']));
$bsemester = trim(($_POST['bsemester']));
$fsemester = trim(($_POST['fsemester']));
$adstatus = trim(($_POST['adstatus']));
$aadvisor = trim(($_POST['aadvisor']));
if($studentID == '') { $errors[] = 'StudentID missing'; }
if($firstname == '') { $errors[] = 'First name missing'; }
if($lastname == '') { $errors[] = 'Last name missing'; }
if($email == '') { $errors[] = 'email is missing'; }

if ( empty($errors) ) {
$query = "UPDATE member
SET studentID='".$studentID."', firstname='".$firstname."', lastname='".$lastname."', phone='".$phone."', email='".$email."', track='".$track."',bsemester='".$bsemester."', fsemester='".$fsemester."',aadvisor='".$aadvisor."',adstatus='".$adstatus."'
WHERE EID='".$_SESSION['pos_id']."'";
$result = mysqli_query($connection,$query);
if ($result) {
$message = "The profile was successfully updated.";
} else {
$message = "The profile could not be updated.";
$message .= "<br />" . mysqli_error($connection);
}
} else {
if (count($errors) == 1) {
$message = "There was 1 error in the form.";
} else { $message = "There were " . count($errors) . " errors in the form."; }
}
}

//****************************************************************changing the Core Courses profile tab-2***************************************************************\\
if (array_key_exists('chcore', $_POST)) {
$errors = array();
$errors="";
$row = getmember($_SESSION['pos_id']);

// Check track for different core course sets
if($row['track'] == 6) {
// New Curriculum Fall 2018
addcore2($_POST['semester_EM505'], $_POST['year_EM505'],$_POST['grade_EM505'],$_POST['certification_EM505'],'EM505');
addcore2($_POST['semester_EM509'], $_POST['year_EM509'],$_POST['grade_EM509'],$_POST['certification_EM509'],'EM509');
addcore2($_POST['semester_EM520'], $_POST['year_EM520'],$_POST['grade_EM520'],$_POST['certification_EM520'],'EM520');
addcore2($_POST['semester_EM540'], $_POST['year_EM540'],$_POST['grade_EM540'],$_POST['certification_EM540'],'EM540');
addcore2($_POST['semester_EM531'], $_POST['year_EM531'],$_POST['grade_EM531'],$_POST['certification_EM531'],'EM531');
addcore2($_POST['semester_EM620'], $_POST['year_EM620'],$_POST['grade_EM620'],$_POST['certification_EM620'],'EM620');
} else {
// All other tracks
addcore2($_POST['semester_EM505'], $_POST['year_EM505'],$_POST['grade_EM505'],$_POST['certification_EM505'],'EM505');
addcore2($_POST['semester_EM509'], $_POST['year_EM509'],$_POST['grade_EM509'],$_POST['certification_EM509'],'EM509');
addcore2($_POST['semester_EM520'], $_POST['year_EM520'],$_POST['grade_EM520'],$_POST['certification_EM520'],'EM520');
addcore2($_POST['semester_EM540'], $_POST['year_EM540'],$_POST['grade_EM540'],$_POST['certification_EM540'],'EM540');
addcore2($_POST['semester_EM570'], $_POST['year_EM570'],$_POST['grade_EM570'],$_POST['certification_EM570'],'EM570');
addcore2($_POST['semester_EM580'], $_POST['year_EM580'],$_POST['grade_EM580'],$_POST['certification_EM580'],'EM580');
addcore2($_POST['semester_EM695'], $_POST['year_EM695'],$_POST['grade_EM695'],$_POST['certification_EM695'],'EM695');
}

// if (empty($errors)) {
// $message = "Core courses updated successfully.";
// }
}

//****************************************************************changing the Track Courses profile tab-3***************************************************************\\

if (array_key_exists('chtrack', $_POST)) {
$errors = array();
$errors="";
$row = getmember($_SESSION['pos_id']);
if($row['track']==1){
addcore2($_POST['semester_EM511'], $_POST['year_EM511'],$_POST['grade_EM511'],$_POST['certification_EM511'],'EM511');
addcore2($_POST['semester_EM558'], $_POST['year_EM558'],$_POST['grade_EM558'],$_POST['certification_EM558'],'EM558');
addcore2($_POST['semester_EM620'], $_POST['year_EM620'],$_POST['grade_EM620'],$_POST['certification_EM620'],'EM620');
addcore2($_POST['semester_EM636'], $_POST['year_EM636'],$_POST['grade_EM636'],$_POST['certification_EM636'],'EM636');
addcore2($_POST['semester_EM649'], $_POST['year_EM649'],$_POST['grade_EM649'],$_POST['certification_EM649'],'EM649');
addcore2($_POST['semester_EM670'], $_POST['year_EM670'],$_POST['grade_EM670'],$_POST['certification_EM670'],'EM670');
}
if($row['track']==2){
addcore2($_POST['semester_EM556'], $_POST['year_EM556'],$_POST['grade_EM556'],$_POST['certification_EM556'],'EM556');
addcore2($_POST['semester_EM558'], $_POST['year_EM558'],$_POST['grade_EM558'],$_POST['certification_EM558'],'EM558');
addcore2($_POST['semester_EM620'], $_POST['year_EM620'],$_POST['grade_EM620'],$_POST['certification_EM620'],'EM620');
addcore2($_POST['semester_EM649'], $_POST['year_EM649'],$_POST['grade_EM649'],$_POST['certification_EM649'],'EM649');
addcore2($_POST['semester_EM659'], $_POST['year_EM659'],$_POST['grade_EM659'],$_POST['certification_EM659'],'EM659');
addcore2($_POST['semester_EM669'], $_POST['year_EM669'],$_POST['grade_EM669'],$_POST['certification_EM669'],'EM669');
}
if($row['track']==3){
addcore2($_POST['semester_EM519'], $_POST['year_EM519'],$_POST['grade_EM519'],$_POST['certification_EM519'],'EM519');
addcore2($_POST['semester_EM547'], $_POST['year_EM547'],$_POST['grade_EM547'],$_POST['certification_EM547'],'EM547');
addcore2($_POST['semester_EM556'], $_POST['year_EM556'],$_POST['grade_EM556'],$_POST['certification_EM556'],'EM556');
addcore2($_POST['semester_EM609'], $_POST['year_EM609'],$_POST['grade_EM609'],$_POST['certification_EM609'],'EM609');
addcore2($_POST['semester_EM620'], $_POST['year_EM620'],$_POST['grade_EM620'],$_POST['certification_EM620'],'EM620');
addcore2($_POST['semester_EM649'], $_POST['year_EM649'],$_POST['grade_EM649'],$_POST['certification_EM649'],'EM649');
}
if($row['track']==5){
addcore2($_POST['semester_EM547'], $_POST['year_EM547'],$_POST['grade_EM547'],$_POST['certification_EM547'],'EM547');
addcore2($_POST['semester_EM620'], $_POST['year_EM620'],$_POST['grade_EM620'],$_POST['certification_EM620'],'EM620');
addcore2($_POST['semester_QUAL647'], $_POST['year_QUAL647'],$_POST['grade_QUAL647'],$_POST['certification_QUAL647'],'QUAL647');
addcore2($_POST['semester_EM691'], $_POST['year_EM691'],$_POST['grade_EM691'],$_POST['certification_EM691'],'EM691');
addcore2($_POST['semester_EM690'], $_POST['year_EM690'],$_POST['grade_EM690'],$_POST['certification_EM690'],'EM690');
addcore2($_POST['semester_QUAL551'], $_POST['year_QUAL551'],$_POST['grade_QUAL551'],$_POST['certification_QUAL551'],'QUAL551');
addcore2($_POST['semester_QUAL557'], $_POST['year_QUAL557'],$_POST['grade_QUAL557'],$_POST['certification_QUAL557'],'QUAL557');
addcore2($_POST['semester_QUAL651'], $_POST['year_QUAL651'],$_POST['grade_QUAL651'],$_POST['certification_QUAL651'],'QUAL651');
}
if($row['track']==4){
$elec_name = trim(($_POST['elec_name']));

$elec_chr = trim(($_POST['elec_chr']));
$elec_semester =trim(($_POST['elec_semester']));
$elec_grade = trim(($_POST['elec_grade']));
$elec_certificate = trim(($_POST['elec_certificate']));
if($elec_name == '') { $errors[] = 'Course name field is missing'; }
if($elec_chr == '') { $errors[] = 'Credit hours field is missing'; }
if($elec_semester == '') { $errors[] = 'Semester field is missing'; }


if ( empty($errors) ) {
$query = "INSERT INTO elective
SET EID='".$_SESSION['pos_id']."', name='".$elec_name."', chr='".$elec_chr."', semester='".$elec_semester."', grade='".$elec_grade."', certification='".$elec_certificate."', qualitytrack=1";
$result = mysqli_query($connection,$query);
if ($result) {
$message = "The profile was successfully updated.";
} else {
$message = "The profile could not be updated.";
$message .= "<br />" . mysqli_error($connection);
}
} else {
if (count($errors) == 1) {
$message = "There was 1 error in the form.";
} else { $message = "There were " . count($errors) . " errors in the form."; }
}
}

// Track 6 handling (same as Track 4 but for Track 6)
if($row['track']==6){
$elec_name = trim(($_POST['elec_name']));
$elec_chr = trim(($_POST['elec_chr']));
$elec_semester =trim(($_POST['elec_semester']));
$elec_grade = trim(($_POST['elec_grade']));
$elec_certificate = trim(($_POST['elec_certificate']));

if($elec_name == '') { $errors[] = 'Course name field is missing'; }
if($elec_chr == '') { $errors[] = 'Credit hours field is missing'; }
if($elec_semester == '') { $errors[] = 'Semester field is missing'; }

if ( empty($errors) ) {
$query = "INSERT INTO elective
SET EID='".$_SESSION['pos_id']."', name='".$elec_name."', chr='".$elec_chr."', semester='".$elec_semester."', grade='".$elec_grade."', certification='".$elec_certificate."', qualitytrack=1";
$result = mysqli_query($connection,$query);
if ($result) {
$message = "Track course added successfully.";
} else {
$message = "The course could not be added.";
$message .= "<br />" . mysqli_error($connection);
}
} else {
if (count($errors) == 1) {
$message = "There was 1 error in the form.";
} else { $message = "There were " . count($errors) . " errors in the form."; }
}
}

if (empty($errors) && in_array($row['track'], [1, 2, 3, 5])) {
$message = "Track courses updated successfully.";
}
}


//****************************************************************changing the Elective Courses profile tab-4***************************************************************\\

if (array_key_exists('chelective', $_POST)) {
$errors = array();
$errors="";
$elec_name = trim(($_POST['elec_name']));

$elec_chr = trim(($_POST['elec_chr']));
$elec_semester =trim(($_POST['elec_semester']));
$elec_grade = trim(($_POST['elec_grade']));
$elec_certificate = trim(($_POST['elec_certificate']));
if($elec_name == '') { $errors[] = 'Course name field is missing'; }
if($elec_chr == '') { $errors[] = 'Credit hours field is missing'; }
if($elec_semester == '') { $errors[] = 'Semester field is missing'; }


if ( empty($errors) ) {
$query = "INSERT INTO elective
SET EID='".$_SESSION['pos_id']."', name='".$elec_name."', chr='".$elec_chr."', semester='".$elec_semester."', grade='".$elec_grade."', certification='".$elec_certificate."'";
$result = mysqli_query($connection,$query);
if ($result) {
$message = "The profile was successfully updated.";
} else {
$message = "The profile could not be updated.";
$message .= "<br />" . mysqli_error($connection);
}
} else {
if (count($errors) == 1) {
$message = "There was 1 error in the form.";
} else { $message = "There were " . count($errors) . " errors in the form."; }
}
}

if (!empty($_GET["elid"])){
$elid= trim(($_GET["elid"]));

$delresult=mysqli_query($connection, "DELETE FROM elective WHERE ELID = '".$_GET['elid']."'");
if ($delresult){$message = "The record successfuly deleted";}

}



//****************************************************************Submit the POS for Approval tab-5***************************************************************\\

if (array_key_exists('submit-approval', $_POST)) {
$errors = array();
$errors="";
$message ="";


if ( empty($errors) ) {
$query = "UPDATE member
SET possubmitted=1
WHERE EID='".$_SESSION['pos_id']."'";
$result = mysqli_query($connection,$query);
if ($result) {
$message = "You successfully submit your POS for approval";
} else {
$message = "The POS couldn't be submitted.";
$message .= "<br />" . mysqli_error($connection);
}
} else {
if (count($errors) == 1) {
$message = "There was 1 error in the form.";
} else { $message = "There were " . count($errors) . " errors in the form."; }
}
}
?>



<?php include('includes/header.php'); ?>


<div class="main-container">
<div class="form-container">
<div class="form-header">
<h2>Master of Science in Engineering Management</h2>
<!-- <h4>PROGRAM CODE: EMGT</h4>
<h6>School of Engineering Technology, Eastern Michigan University</h6> -->
</div>
<?php
$_SESSION['pos_id']=$_SESSION['user_id'];
$row = getmember($_SESSION['pos_id']);
?>



<div
class="status-message <?= $row['possubmitted'] ? 'submitted' : '' ?> <?= $row['posapproved'] ? 'approved' : '' ?>">
<?php
if ($row['possubmitted'] == 1) {
echo "<p>1. Your POS has been submitted for approval</p>";
} else {
echo "<p>1. You haven't submitted your POS for approval yet</p>";
}

if ($row['posapproved'] == 1) {
echo "<p>2. Your POS has been approved</p>";
} else {
echo "<p>2. Your POS hasn't been approved yet</p>";
}
?>

</div>

<div class="tab-container">
<div class="tab-nav">
<button class="tab-button active" data-tab="tab-1">Main Information</button>
<button class="tab-button" data-tab="tab-2">Core Courses</button>
<?php if($row['track'] != 6) { ?>
<button class="tab-button" data-tab="tab-3">Track Courses</button>
<?php } ?>
<button class="tab-button" data-tab="tab-4">Elective Courses</button>
<button class="tab-button" data-tab="tab-5">Review & Submit</button>
</div>

<!-- Tab 1: Main Information -->
<div id="tab-1" class="tab-content active">
<form name="chprofile" action="#" method="post">
<table class="data-table">
<tr>
<th colspan="2">
<b>Plan of Study:</b>
<select name="track" class="textfield" id="track" style="width: 60%; margin-left: 10px;">
<option value="6" selected>New Curriculum Fall 2018
</option>
</select>

</th>
</tr>
<tr>
<td>
<b>Student Name:</b><br />
<div style="display: flex; gap: 10px;">
<input name="firstname" type="text" class="textfield" id="firstname"
value="<?php echo( htmlspecialchars( $row['firstname'] ) ); ?>" />
<input name="lastname" type="text" class="textfield" id="lastname"
value="<?php echo( htmlspecialchars( $row['lastname'] ) ); ?>" />
</div>
</td>
<td>
<b>Student ID:</b><br />
<input name="studentID" type="text" class="textfield" id="studentID"
value="<?php echo( htmlspecialchars( $row['studentID'] ) ); ?>" />
</td>
</tr>
<tr>
<td>
<b>Cell Phone:</b><br />
<input name="phone" type="text" id="phone" class="textfield"
value="<?php echo( htmlspecialchars( $row['phone'] ) ); ?>" />
</td>
<td>
<b>Email:</b><br />
<input name="email" id="email" type="text" class="textfield"
value="<?php echo( htmlspecialchars( $row['email'] ) ); ?>" />
</td>
</tr>
<tr>
<td>
<b>Admit Semester:</b><br />
<input name="bsemester" type="text" class="textfield" id="bsemester"
value="<?php echo( htmlspecialchars( $row['bsemester'] ) ); ?>" />
</td>
<td>
<b>Academic Advisor:</b><br />
<input name="aadvisor" type="text" class="textfield" id="aadvisor"
value="<?php echo( htmlspecialchars( $row['aadvisor'] ) ); ?>" />
</td>
</tr>
<tr>
<td>
<b>Admit Status:</b><br />
<input name="adstatus" type="text" class="textfield" id="adstatus"
value="<?= htmlspecialchars($row['adstatus']) ?>" />
</td>
<td>
<b>Expected Final Semester:</b><br />
<input name="fsemester" type="text" class="textfield" id="fsemester"
value="<?= htmlspecialchars($row['fsemester']) ?>" />
</td>
</tr>
</table>

<div class="navigation-buttons">
<div>
<input class="btn" type="submit" name="submit" value="Save" />
</div> <!-- Empty div for spacing -->
<button type="button" class="btn_move" onclick="openTab('tab-2')">Next: Core Courses</button>
</div>

<input type="hidden" name="chprofile" value="1" />
</form>
</div>

<!-- Tab 2: Core Courses -->
<div id="tab-2" class="tab-content">
<form name="chcore" action="#" method="post">
<table class="data-table">
<tr>
<th>Course Prefix and Name</th>
<th class="text-center">Credit Hours</th>
<th class="text-center">Semester</th>
<th class="text-center">Course Grade</th>
<th class="text-center"> (O: Optional)
<br />(R: Required)</th>
</tr>
<tr>
<th colspan="5"><b>EM Program Core (Hours Required: <?php echo ($row['track'] == 6) ? '18' : '21'; ?>
hrs)</b></th>
</tr>
<?php
$pos_id=$_SESSION['pos_id'];

if($row['track'] == 6) {
// New Curriculum Fall 2018
echo getcname('EM505',$pos_id);
echo getcname('EM509',$pos_id);
echo getcname('EM520',$pos_id);
echo getcname('EM540',$pos_id);
echo getcname('EM531',$pos_id);
echo getcname('EM620',$pos_id);
} else {
// All other tracks
echo getcname('EM505',$pos_id);
echo getcname('EM509',$pos_id);
echo getcname('EM520',$pos_id);
echo getcname('EM540',$pos_id);
echo getcname('EM570',$pos_id);
echo getcname('EM580',$pos_id);
echo getcname('EM695',$pos_id);
}
?>
</table>

<div class="navigation-buttons">
<input class="btn" type="submit" name="submit" value="Save" />
<button type="button" class="btn_move btn-secondary" onclick="openTab('tab-1')">Back</button>
<?php if($row['track'] != 6) { ?>
<button type="button" class="btn_move" onclick="openTab('tab-3')">Next: Track Courses</button>
<?php } else { ?>
<button type="button" class="btn_move" onclick="openTab('tab-4')">Next: Elective Courses</button>
<?php } ?>
</div>

<input type="hidden" name="chcore" value="1" />
</form>
</div>

<!-- Tab 3: Track Courses -->
<?php if($row['track'] != 6) { ?>
<div id="tab-3" class="tab-content">
<form name="chtrack" action="#" method="post">
<table class="data-table">
<tr>
<th colspan="5">
<b><?php
if($row['track']==1) echo "Design and Manufacturing Track F2007";
if($row['track']==2) echo "Lean Enterprise Systems Track F2007";
if($row['track']==3) echo "Project/Program Management Track 2007";
if($row['track']==4) echo "Quality Certificate Track F2007";
if($row['track']==5) echo "R & D (Development Project) Track F2007";
?> (Hours Required: 18 hrs)</b>
</th>
</tr>

<?php
$pos_id=$_SESSION['pos_id'];

if($row['track']==1){
echo getcname('EM511', $pos_id);
echo getcname('EM558', $pos_id);
echo getcname('EM620', $pos_id);
echo getcname('EM636', $pos_id);
echo getcname('EM649', $pos_id);
echo getcname('EM670', $pos_id);
}
if($row['track']==2){
echo getcname('EM556', $pos_id);
echo getcname('EM558', $pos_id);
echo getcname('EM620', $pos_id);
echo getcname('EM649', $pos_id);
echo getcname('EM659', $pos_id);
echo getcname('EM669', $pos_id);
}
if($row['track']==3){
echo getcname('EM519', $pos_id);
echo getcname('EM547', $pos_id);
echo getcname('EM556', $pos_id);
echo getcname('EM609', $pos_id);
echo getcname('EM620', $pos_id);
echo getcname('EM649', $pos_id);
}
if($row['track']==5){
echo getcname('EM547', $pos_id);
echo getcname('EM620', $pos_id);
echo getcname('QUAL647', $pos_id);
echo getcname('EM691', $pos_id);
echo getcname('EM690', $pos_id);
echo getcname('QUAL551', $pos_id);
echo getcname('QUAL557', $pos_id);
echo getcname('QUAL651', $pos_id);
}

if($row['track']==4){ //Quality track elective style input
?>
<tr>
<td>Course Name<br /><input name='elec_name' type='text' class='textfield' id='elec_name' /></td>
<td class='text-center'>Hours<br /><input name='elec_chr' type='text' class='textfield' id='elec_chr'
size='3' /></td>
<td class='text-center'>Semester<br /><input name='elec_semester' type='text' class='textfield'
id='elec_semester' size='5' /></td>
<td class='text-center'>Grade<br /><input name='elec_grade' type='text' class='textfield' id='elec_grade'
size='2' /></td>
<td class='text-center'>Certification<br /><input name='elec_certificate' type='text' class='textfield'
id='elec_certificate' size='5' /></td>
</tr>
<tr>
<td colspan='5' style='text-align: right;'>
<input type='submit' name='submit' class='btn' value='Add Course' />
</td>
</tr>
<tr>
<th colspan='5'><b>Quality Track Courses (Hours Required: 18 hrs)</b></th>
</tr>
<?php
$eid = $_SESSION['pos_id'];
$result = mysqli_query($connection,"SELECT * FROM elective WHERE elective.EID='".$eid."' AND elective.qualitytrack='1' ");
while($courseRow = mysqli_fetch_assoc($result)){
echo "<tr>";
echo "<td class='text-center'>".$courseRow['name']."</td>";
echo "<td class='text-center'>".$courseRow['chr']."</td>";
echo "<td class='text-center'>".$courseRow['semester']."</td>";
echo "<td class='text-center'>".$courseRow['grade']."</td>";
echo "<td class='text-center'>".$courseRow['certification']."</td>";
echo "<td class='text-center'><a href='submit-pos.php?elid=".$courseRow['ELID']."#tab-3'>Delete</a></td>";
echo "</tr>";
}
}
?>
</table>

<div class="navigation-buttons">
<button type="button" class="btn btn-secondary" onclick="openTab('tab-2')">Back</button>
<button type="button" class="btn" onclick="openTab('tab-4')">Next: Elective Courses</button>
</div>

<input type="hidden" name="chtrack" value="1" />
</form>
</div>
<?php } ?>

<!-- Tab 4: Elective Courses -->

<div id="tab-4" class="tab-content">
<form name="chelective" action="#" method="post">
<table class="data-table">
<tr>
<td>Course Name<br /><input name="elec_name" type="text" class="textfield" id="elec_name" /></td>
<td class="text-center">Hours<br /><input name="elec_chr" type="text" class="textfield" id="elec_chr"
size="3" /></td>
<td class="text-center">Semester<br /><input name="elec_semester" type="text" class="textfield"
size="5" /></td>
<td class="text-center">Grade<br /><input name="elec_grade" type="text" class="textfield" id="elec_grade"
size="2" /></td>
<td class="text-center">Certification<br /><input name="elec_certificate" type="text" class="textfield"
id="elec_certificate" size="5" /></td>
<td size="3">
<input type="submit" class="btn" name="submit" value="Add Course" />
</td>
</tr>

<tr>
<th colspan="6"><b>Elective Courses</b></th>
</tr>
<?php
$eid=$_SESSION['pos_id'];
$result = mysqli_query($connection,"SELECT * FROM elective WHERE elective.EID='".$eid."' AND elective.qualitytrack=0");
while($elecRow = mysqli_fetch_assoc($result)){
echo "<tr><td class='text-center'>".$elecRow['name']."</td>";
echo "<td class='text-center'>".$elecRow['chr']."</td>";
echo "<td class='text-center'>".$elecRow['semester']."</td>";
echo "<td class='text-center'>".$elecRow['grade']."</td>";
echo "<td class='text-center'>".$elecRow['certification']."</td>";
echo "<td class='text-center'><a href='submit-pos.php?elid=".$elecRow['ELID']."#tab-4'>Delete</a></td></tr>";
}
?>
</table>

<div class="navigation-buttons">
<?php if($row['track'] != 6) { ?>
<button type="button" class="btn btn-secondary" onclick="openTab('tab-3')">Back</button>
<?php } else { ?>
<button type="button" class="btn btn-secondary" onclick="openTab('tab-2')">Back</button>
<?php } ?>
<button type="button" class="btn" onclick="openTab('tab-5')">Next: Review & Submit</button>
</div>

<input type="hidden" name="chelective" value="1" />
</form>
</div>

<!-- Tab 5: Review & Submit -->

<div id="tab-5" class="tab-content">
<script type="text/javascript">
function printSelection(node) {
var content = node.innerHTML
var pwin = window.open('', 'print_content', 'width=100,height=100');
pwin.document.open();
pwin.document.write('<html><body onload="window.print()">' + content + '</body></html>');
pwin.document.close();
setTimeout(function() {
pwin.close();
}, 1000);
}
</script>

<button class="print-btn" onclick="printSelection(document.getElementById('print-content'));return false">
Print POS
</button>

<div id="print-content">
<?php $row = getmember($_SESSION['pos_id']);?>
<div style="text-align: center; margin-bottom: 30px;">
<h2>Master of Science in Engineering Management</h2>
<h4>PROGRAM CODE: EMGT</h4>
<h6>School of Engineering Technology, Eastern Michigan University</h6>
</div>

<table class="data-table">
<!-- Student information table content -->
<tr>
<th colspan="2">
<b>Plan of Study:</b>
<?php
if($row['track']==1){ echo "Design and Manufacturing Track F2007";}
if($row['track']==2) {echo "Lean Enterprise Systems Track F2007"; }
if($row['track']==3) {echo "Project/Program Management Track 2007"; }
if($row['track']==4) {echo "Quality Certificate Track F2007";}
if($row['track']==5) {echo "R & D (Development Project) Track F2007"; }
if($row['track']==6) {echo "New Curriculum Fall 2018"; }
?>
</th>
</tr>
<tr>
<td><b>Student
Name:</b> <?php echo( htmlspecialchars( $row['firstname'] ) ); ?>
<?php echo( htmlspecialchars( $row['lastname'] ) ); ?>
</td>
<td><b>Student ID:</b> <?php echo( htmlspecialchars( $row['studentID'] ) ); ?></td>
</tr>
<tr>
<td><b>Cell Phone:</b> <?php echo( htmlspecialchars( $row['phone'] ) ); ?></td>
<td><b>Email:</b> <?php echo( htmlspecialchars( $row['email'] ) ); ?></td>
</tr>
<tr>
<td><b>Admit Semester:</b> <?php echo( htmlspecialchars( $row['bsemester'] ) ); ?></td>
<td><b>Academic Advisor:</b> <?php echo( htmlspecialchars( $row['aadvisor'] ) ); ?></td>
</tr>
<tr>
<td><b>Admit Status:</b> <?php echo( htmlspecialchars( $row['adstatus'] ) ); ?></td>
<td><b>Expected Final Semester:</b> <?php echo( htmlspecialchars( $row['fsemester'] ) ); ?></td>
</tr>
</table>

<br />

<table class="data-table">
<!-- Course information table content -->
<tr>
<th>Course Prefix and Name</th>
<th class="text-center">Credit Hours</th>
<th class="text-center">Semester</th>
<th class="text-center">Course Grade</th>
<th class="text-center">Certification</th>
</tr>
<tr>
<th colspan="5"><b>EM Program Core (Hours Required: <?php echo ($row['track'] == 6) ? '18' : '21'; ?>
hrs)</b></th>
</tr>
<?php
$pos_id=$_SESSION['pos_id'];

if($row['track'] == 6) {
// New Curriculum Fall 2018
echo reportpos('EM505',$pos_id);
echo reportpos('EM509',$pos_id);
echo reportpos('EM520',$pos_id);
echo reportpos('EM540',$pos_id);
echo reportpos('EM531',$pos_id);
echo reportpos('EM620',$pos_id);
} else {
// All other tracks
echo reportpos('EM505',$pos_id);
echo reportpos('EM509',$pos_id);
echo reportpos('EM520',$pos_id);
echo reportpos('EM540',$pos_id);
echo reportpos('EM570',$pos_id);
echo reportpos('EM580',$pos_id);
echo reportpos('EM695',$pos_id);
}
?>

<?php if($row['track'] != 6) { ?>
<!--*****Track Section Summary******-->
<tr>
<th colspan="5"><b>Track Courses (Hours Required: 18 hrs)</b></th>
</tr>
<?php
if($row['track']==1){
echo reportpos('EM511',$pos_id);
echo reportpos('EM558',$pos_id);
echo reportpos('EM620',$pos_id);
echo reportpos('EM636',$pos_id);
echo reportpos('EM649',$pos_id);
echo reportpos('EM670',$pos_id);
}
if($row['track']==2){
echo reportpos('EM556',$pos_id);
echo reportpos('EM558',$pos_id);
echo reportpos('EM620',$pos_id);
echo reportpos('EM649',$pos_id);
echo reportpos('EM659',$pos_id);
echo reportpos('EM669',$pos_id);
}
if($row['track']==3){
echo reportpos('EM519',$pos_id);
echo reportpos('EM547',$pos_id);
echo reportpos('EM556',$pos_id);
echo reportpos('EM609',$pos_id);
echo reportpos('EM620',$pos_id);
echo reportpos('EM649',$pos_id);
}
if($row['track']==5){
echo reportpos('EM547',$pos_id);
echo reportpos('EM620',$pos_id);
echo reportpos('QUAL647',$pos_id);
echo reportpos('EM691',$pos_id);
echo reportpos('EM690',$pos_id);
echo reportpos('QUAL551',$pos_id);
echo reportpos('QUAL557',$pos_id);
echo reportpos('QUAL651',$pos_id);
}
if($row['track']==4){//Quality track elective courses
$eid=$_SESSION['pos_id'];
$result = mysqli_query($connection,"SELECT * FROM elective WHERE elective.EID='".$eid."' AND elective.qualitytrack='1' ");
while($trackRow = mysqli_fetch_assoc($result)){
echo "<tr><td class='text-center'>".$trackRow['name']."</td>";
echo "<td class='text-center'>".$trackRow['chr']."</td>";
echo "<td class='text-center'>".$trackRow['semester']."</td>";
echo "<td class='text-center'>".$trackRow['grade']."</td>";
echo "<td class='text-center'>".$trackRow['certification']."</td></tr>";
}
}
?>
<?php } ?>

<tr>
<th colspan="5"><b>Elective Courses</b></th>
</tr>
<?php
$eid=$_SESSION['pos_id'];
$result = mysqli_query($connection,"SELECT * FROM elective WHERE elective.EID='".$eid."' AND elective.qualitytrack=0");
while($elecRow = mysqli_fetch_assoc($result)){
echo "<tr><td class='text-center'>".$elecRow['name']."</td>";
echo "<td class='text-center'>".$elecRow['chr']."</td>";
echo "<td class='text-center'>".$elecRow['semester']."</td>";
echo "<td class='text-center'>".$elecRow['grade']."</td>";
echo "<td class='text-center'>".$elecRow['certification']."</td></tr>";
}
?>
</table>
</div>

<form name="submit-approval" method="post" enctype="multipart/form-data" action="#">
<table class="data-table">
<tr>
<th colspan="6">Submit your Program of Study</th>
<td>
<input type="submit" name="submit" class="btn" value="Submit for Approval" />
</td>
</tr>
</table>

<div class="navigation-buttons">
<button type="button" class="btn btn-secondary" onclick="openTab('tab-4')">Back</button>
<div></div>
</div>

<input type="hidden" name="submit-approval" value="1" />
</form>
</div>

</div>
</div>
<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
<?php if (!empty($errors)) { display_errors($errors); } ?>

<style>
body {
font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
background-color: #f5f7fa;
}

/* Main container styling */
.main-container {
display: flex;
justify-content: center;
padding: 20px;
}

/* Form container styling */
.form-container {
width: 100%;
max-width: 1200px;
background: white;
border-radius: 8px;
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
padding: 30px;
margin: 20px 0;
}

/* Header styling */
.form-header {
text-align: center;
margin-bottom: 30px;
border-bottom: 1px solid #eaeaea;
padding-bottom: 20px;
}

.form-header h2 {
color: #2c3e50;
margin-bottom: 5px;
}

.form-header h4 {
color: #7f8c8d;
margin-top: 0;
margin-bottom: 5px;
}

.form-header h6 {
color: #95a5a6;
margin-top: 0;
}

/* Tab styling */
.tab-container {
width: 100%;
}

.tab-nav {
display: flex;
border-bottom: 2px solid #eaeaea;
margin-bottom: 25px;
}

.tab-nav button {
padding: 12px 25px;
background: transparent;
border: none;
cursor: pointer;
font-weight: 600;
font-size: 15px;
color: #7f8c8d;
transition: all 0.3s;
position: relative;
margin-right: 5px;
}

.tab-nav button:hover {
color: #81d789;
}

.tab-nav button.active {
color: #81d789;
}

.tab-nav button.active::after {
content: '';
position: absolute;
bottom: -2px;
left: 0;
width: 100%;
height: 3px;
background-color: #81d789;
}

.tab-content {
display: none;
animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
from {
opacity: 0;
}

to {
opacity: 1;
}
}

.tab-content.active {
display: block;
}

/* Table styling */
.data-table {
width: 100%;
border-collapse: separate;
border-spacing: 0;
margin-bottom: 25px;
box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
border-radius: 6px;
overflow: hidden;
}

.data-table th {
background-color: #81d789;
color: white;
font-weight: 600;
padding: 12px 15px;
text-align: left;
}

.data-table td {
padding: 12px 15px;
border-bottom: 1px solid #eaeaea;
vertical-align: middle;
}

.data-table tr:last-child td {
border-bottom: none;
}

.data-table tr:hover {
background-color: #f8f9fa;
}

.data-table .text-center {
text-align: center;
}

/* Form element styling */
.textfield {
padding: 8px 12px;
border: 1px solid #ddd;
border-radius: 4px;
width: 100%;
font-size: 14px;
transition: border-color 0.3s;
}

.textfield:focus {
border-color: #81d789;
outline: none;
box-shadow: 0 0 0 2px rgba(129, 215, 137, 0.2);
}

select.textfield {
padding: 8px 12px;
height: 36px;
}

/* Button styling */
.btn {
padding: 10px 20px;
background-color: #81d789;
color: white;
border: none;
border-radius: 4px;
cursor: pointer;
font-weight: 600;
font-size: 14px;
transition: background-color 0.3s;
text-transform: uppercase;
letter-spacing: 0.5px;
}

.btn:hover {
background-color: #6bc074;
}

.btn_move {
padding: 10px 20px;
background-color: #b0b0b0;
/* light gray */
color: white;
border: none;
border-radius: 4px;
cursor: pointer;
font-weight: 600;
font-size: 14px;
transition: background-color 0.3s;
text-transform: uppercase;
letter-spacing: 0.5px;
}

.btn_move:hover {
background-color: #909090;
/* darker gray on hover */
}

.btn-secondary {
background-color: #6c757d;
}

.btn-secondary:hover {
background-color: #5a6268;
}

/* Navigation buttons */
.navigation-buttons {
display: flex;
justify-content: space-between;
margin-top: 30px;
}

/* Status message */
.status-message {
padding: 15px 20px;
margin-bottom: 25px;
border-radius: 6px;
background-color: #f8f9fa;
border-left: 4px solid #6c757d;
font-size: 15px;
}

.status-message p {
margin: 5px 0;
}

.status-message.approved {
border-left-color: #28a745;
background-color: #e8f5e9;
}

.status-message.submitted {
border-left-color: #17a2b8;
background-color: #e2f3f7;
}

/* Print button */
.print-btn {
background: #6c757d;
color: white;
padding: 10px 20px;
border: none;
border-radius: 4px;
cursor: pointer;
margin-bottom: 20px;
font-weight: 600;
transition: background-color 0.3s;
}

.print-btn:hover {
background: #5a6268;
}

/* Responsive adjustments */
@media (max-width: 768px) {
.form-container {
padding: 15px;
}

.tab-nav button {
padding: 10px 15px;
font-size: 14px;
}

.data-table th,
.data-table td {
padding: 8px 10px;
font-size: 14px;
}
}
</style>

<script>
// Tab navigation functionality
function openTab(tabId) {
// Hide all tab contents
const tabContents = document.getElementsByClassName('tab-content');
for (let i = 0; i < tabContents.length; i++) {
tabContents[i].classList.remove('active');
}

// Deactivate all tab buttons
const tabButtons = document.getElementsByClassName('tab-button');
for (let i = 0; i < tabButtons.length; i++) {
tabButtons[i].classList.remove('active');
}

// Activate the selected tab
document.getElementById(tabId).classList.add('active');

// Find and activate the corresponding button
const buttons = document.getElementsByClassName('tab-button');
for (let i = 0; i < buttons.length; i++) {
if (buttons[i].getAttribute('data-tab') === tabId) {
buttons[i].classList.add('active');
break;
}
}

// Scroll to the top of the tab
window.scrollTo(0, document.getElementById(tabId).offsetTop - 20);
}

// Add click event listeners to tab buttons
const tabButtons = document.getElementsByClassName('tab-button');
for (let i = 0; i < tabButtons.length; i++) {
tabButtons[i].addEventListener('click', function() {
openTab(this.getAttribute('data-tab'));
});
}
</script>

<?php include('includes/footer.php'); ?>