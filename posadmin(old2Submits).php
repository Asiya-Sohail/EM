<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();?>
<?php check_supperuser();?>
<?php include_once("includes/form_functions.php");?>

<?//$pos_id=$_SESSION['pos_id'];?>
<?php
//****************************************************************changing the main profile tab-1***************************************************************\\
if (array_key_exists('chprofile', $_POST)) {
    $errors = array();
    $errors = "";
    $message = "";
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
    $graduated = trim(($_POST['graduated']));
    $achievements = trim(($_POST['achievements']));
  if($studentID == '') { $errors[] = 'StudentID missing'; }
  if($firstname == '') { $errors[] = 'First name missing'; }
  if($lastname == '') { $errors[] = 'Last name missing'; }
  if($email == '') { $errors[] = 'email is missing'; }
  
    if ( empty($errors) ) {
  		$query = "UPDATE member
                       SET studentID='{$studentID}', firstname='{$firstname}', lastname='{$lastname}', phone='{$phone}', email='{$email}', track='{$track}',bsemester='{$bsemester}', fsemester='{$fsemester}',aadvisor='{$aadvisor}',adstatus='{$adstatus}',graduated='{$graduated}',achievements='{$achievements}'
						           WHERE EID='{$_SESSION['pos_id']}'";
       $result = mysql_query($query, $connection);
			if ($result) {
				$message = "The profile was successfully updated.";
			} else {
				$message = "The profile could not be updated.";
				$message .= "<br />" . mysql_error();
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {  $message = "There were " . count($errors) . " errors in the form.";	}
		}
}

//****************************************************************changing the Core Courses profile tab-2***************************************************************\\
if (array_key_exists('chcore', $_POST)) {
    $errors = array();
    $errors="";
    addcore2($_POST['semester_EM505'], $_POST['year_EM505'],$_POST['grade_EM505'],$_POST['certification_EM505'],'EM505');
    addcore2($_POST['semester_EM509'], $_POST['year_EM509'],$_POST['grade_EM509'],$_POST['certification_EM509'],'EM509');
    addcore2($_POST['semester_EM520'], $_POST['year_EM520'],$_POST['grade_EM520'],$_POST['certification_EM520'],'EM520');
    addcore2($_POST['semester_EM540'], $_POST['year_EM540'],$_POST['grade_EM540'],$_POST['certification_EM540'],'EM540');
    addcore2($_POST['semester_EM570'], $_POST['year_EM570'],$_POST['grade_EM570'],$_POST['certification_EM570'],'EM570');
    addcore2($_POST['semester_EM580'], $_POST['year_EM580'],$_POST['grade_EM580'],$_POST['certification_EM580'],'EM580');
	addcore2($_POST['semester_EM695'], $_POST['year_EM695'],$_POST['grade_EM695'],$_POST['certification_EM695'],'EM695');
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
                       SET EID='{$_SESSION['pos_id']}', name='{$elec_name}', chr='{$elec_chr}', semester='{$elec_semester}', grade='{$elec_grade}', certification='{$elec_certificate}', qualitytrack=1";
           $result = mysql_query($query, $connection);
			if ($result) {
           $message = "The profile was successfully updated.";
			} else {
			   	$message = "The profile could not be updated.";
			   	$message .= "<br />" . mysql_error();
			}
	  	} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {  $message = "There were " . count($errors) . " errors in the form.";	}
		}


    }
	
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
                       SET EID='{$_SESSION['pos_id']}', name='{$elec_name}', chr='{$elec_chr}', semester='{$elec_semester}', grade='{$elec_grade}', certification='{$elec_certificate}', qualitytrack=1";
           $result = mysql_query($query, $connection);
			if ($result) {
           $message = "The profile was successfully updated.";
			} else {
			   	$message = "The profile could not be updated.";
			   	$message .= "<br />" . mysql_error();
			}
	  	} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {  $message = "There were " . count($errors) . " errors in the form.";	}
		}


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
                       SET EID='{$_SESSION['pos_id']}', name='{$elec_name}', chr='{$elec_chr}', semester='{$elec_semester}', grade='{$elec_grade}', certification='{$elec_certificate}'";
       $result = mysql_query($query, $connection);
			if ($result) {
				$message = "The profile was successfully updated.";
			} else {
				$message = "The profile could not be updated.";
				$message .= "<br />" . mysql_error();
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {  $message = "There were " . count($errors) . " errors in the form.";	}
		}
}

   if (!empty($_GET["elid"])){
   $elid= trim(($_GET["elid"]));
   
   $delresult=mysql_query( "DELETE FROM elective WHERE ELID = '{$_GET['elid']}'");
   if ($delresult){$message = "The record successfuly deleted";}

   }
?>



<?php include('includes/header.php'); ?>
























<?/////////////////////////////*********************************************form******************************************\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\?>
<h2 >Master of Science in Engineering Management</h2><br/>
 <br/>
 <h3> Search Student </h3>

<form action="posadmin.php" method="post">
 <input name="searchtxt" type="text" class="textfield" id="searchtxt" />
 <input type="submit" name="submit" value="search" /></td>
 <input type="hidden" name="search" value="1"/>
</form>
 <br/> <br/>
<form action="posadmin.php" method="post">
 <select name="courseyears" value="" id="courseyears"><option value="">-----Select one-----</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option></select>
 <input type="submit" name="submit" value="List All Graduated Students" /></td>
 <input type="hidden" name="listall" value="1"/>
</form>
  <br/> <br/>

<!--******************************************************************search engin ****************************************************-->
<?php
if (array_key_exists('listall', $_POST)) {

    

    if ( empty($errors) ){
        $yearS = $_POST['courseyears'];
    $qry = "SELECT EID, firstname, lastname, username, email,achievements,graduated FROM member WHERE graduated='yes' AND fsemester LIKE '%$yearS%'";
		$result = mysql_query($qry);
		if($result) {
			if(mysql_num_rows($result) > 0) {
       if (mysql_num_rows($result) == 1){$row = mysql_fetch_array( $result ); $_SESSION['pos_id'] = $row['EID'];}   //if the search found just one record
       else{
       $_SESSION['pos_id']="";
       $str ="";
       $str .= "<table><tr><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>Program Of Study</th></tr>";
       while($row = mysql_fetch_array( $result ))
       {
        $str .="<tr><td>".$row['firstname']."</td><td>".$row['lastname']."</td><td>".$row['username']."</td><td>".$row['email']."</td><td><a href=posadmin.php?eid=". $row['EID'] ." target='_blank'>Click here</a></td></tr>";
       }
       $str .="</table>";
       echo $str;
       }
      }else {$message = "Sorry, there is no field with this name.";}
		}

		else {
			die("Query failed");
		}
	}
}
  //$_SESSION['pos_id']="";

	//if (isset($_POST['submit'])) { // Form has been submitted.
if (array_key_exists('search', $_POST)) {
    //echo $_SESSION['pos_id'];
    //$_SESSION['pos_id']="";
		//$errors = array();
    $searchtxt = trim(($_POST['searchtxt']));


    if($searchtxt == '') { $errors[] = 'Enter First name, or Last name, or email, or Student ID in the search field'; }

    if ( empty($errors) ){
    $qry = "SELECT EID, firstname, lastname, username, email,achievements,graduated FROM member WHERE username LIKE '%$searchtxt%' OR firstname LIKE '%$searchtxt%' OR lastname LIKE '%$searchtxt%' OR email LIKE '%$searchtxt%' OR studentID LIKE '%$searchtxt%'";
		$result = mysql_query($qry);
		if($result) {
			if(mysql_num_rows($result) > 0) {
       if (mysql_num_rows($result) == 1){$row = mysql_fetch_array( $result ); $_SESSION['pos_id'] = $row['EID'];}   //if the search found just one record
       else{
       $_SESSION['pos_id']="";
       $str ="";
       $str .= "<table><tr><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>Program Of Study</th></tr>";
       while($row = mysql_fetch_array( $result ))
       {
        $str .="<tr><td>".$row['firstname']."</td><td>".$row['lastname']."</td><td>".$row['username']."</td><td>".$row['email']."</td><td><a href=posadmin.php?eid=". $row['EID'] .">Click here</a></td></tr>";
       }
       $str .="</table>";
       echo $str;
       }
      }else {$message = "Sorry, there is no field with this name.";}
		}

		else {
			die("Query failed");
		}
	}
}else{
$str="";
$searchtxt="";
//$message="";
//$errors="";
//$_SESSION['pos_id']="";
}
if (!empty($_GET["eid"])){
    $_SESSION['pos_id']=$_GET["eid"];
    
}
?>

<?php
     //$pos_id=$_SESSION['pos_id'];
     $row = getmember($_SESSION['pos_id']);
?>
<!--******************************************************************POS****************************************************-->
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Main</a></li>
		<li><a href="#tabs-2">Core Courses</a></li>
		<li><a href="#tabs-3">Track Courses</a></li>
		<li><a href="#tabs-4">Elective Courses</a></li>
		<li><a href="#tabs-5">Summery</a></li>
	</ul>


	<div id="tabs-1"><!--**********************************Main Section- tab-1 *************************************************-->
	 <form name="chprofile" action="posadmin.php#tabs-1" method="post">
     <div align= 'center'> <br/>
         <table border= "1" cellspacing="0">
                <tr colspan="2"><th colspan="2"><b>Plan of Study:</b><select name="track" type="text" class="textfield" id="track" ><option value=""></option><option value="1" <?if($row['track']==1){echo "selected='selected'";}?>>Design and Manufacturing Track F2007</option><option value="2" <?if($row['track']==2){echo "selected='selected'";}?>>Lean Enterprise Systems Track F2007</option><option value="3"<?if($row['track']==3){echo "selected='selected'";}?>>Project/program Management Track 2007</option><option value="4" <?if($row['track']==4){echo "selected='selected'";}?>>Quality Certificate Track F2007</option><option value="5" <?if($row['track']==5){echo "selected='selected'";}?>>R & D (development Project) Track F2007</option><option value="6" <?if($row['track']==6){echo "selected='selected'";}?>>New Curriculum Fall 2018</option></select></th></tr>
                <tr><td><b>Student Name :<b/><br/><input name="firstname" type="text" class="textfield" id="firstname" size= "15" value="<?php echo( htmlspecialchars( $row['firstname'] ) ); ?>"/><input name="lastname" type="text" class="textfield" id="lastname" size= "15"value="<?php echo( htmlspecialchars( $row['lastname'] ) ); ?>"/> </td><td><b>Student ID :<b/><br/> <input name="studentID" type="text" class="textfield" id="studentID" size= "30"value="<?php echo( htmlspecialchars( $row['studentID'] ) ); ?>"/></td></tr>
                <tr><td><b>Cell phone : <b/><br/><input name="phone" type="text" class="textfield" id="phone" size= "30" value="<?php echo( htmlspecialchars( $row['phone'] ) ); ?>"/></td><td><b>Email:<b/><br/> <input name="email" type="text" class="textfield" id="email" size= "30" value="<?php echo( htmlspecialchars( $row['email'] ) ); ?>"/></td></tr>
                <tr><td><b>Admit Semester :<b/><br/> <input name="bsemester" type="text" class="textfield" id="bsemester" size= "30" value="<?php echo( htmlspecialchars( $row['bsemester'] ) ); ?>"/></td><td><b>Academic Advisor :<b/> <br/><input name="aadvisor" type="text" class="textfield" id="aadvisor" size= "30" value="<?php echo( htmlspecialchars( $row['aadvisor'] ) ); ?>"/></td></tr>
                <tr><td><b>Admit Status : <b/><br/><input name="adstatus" type="text" class="textfield" id="adstatus" size= "30" value="<?php echo( htmlspecialchars( $row['adstatus'] ) ); ?>"/></td><td><b>Expected Final Semester :<b/> <br/><input name="fsemester" type="text" class="textfield" id="fsemester" size= "30" value="<?php echo( htmlspecialchars( $row['fsemester'] ) ); ?>"/></td></tr>
                <tr><td><b>Graduated : <b/><br/><input type="radio" name="graduated" value="yes" id="grady" <?php if(isset($row['graduated']) && $row['graduated'] =='yes' ) echo "checked='checked'"; ?>/>&nbsp;Yes&nbsp;&nbsp;<input type="radio" name="graduated" value="no" id="gradn" <?php if(isset($row['graduated']) && $row['graduated'] =='no' ) echo "checked='checked'"; ?> />&nbsp;No</td><td><b>Achievements :<b/> <br/><input name="achievements" type="text" class="textfield" id="achievements" size= "30" value="<?php echo( htmlspecialchars( $row['achievements'] ) ); ?>"/></td></tr>
				<tr><td><b>Personal Email :<b/><br/><input name="personalemail" type="text" class="textfield" id="personalemail" size= "30"></td><td> </td></tr>
                <tr colspan="2"><td colspan="2" align="right"><input type="submit" name="submit" value="Submit" /></td></tr>
         </table><br/>
         <input type="hidden" name="chprofile" value="1"/>
     </div>
   </form>
	</div>
 <div>
 <div id="tabs-2"><!--**********************************Core Courses *************************************************-->
 <form name="chcore" action="posadmin.php#tabs-2" method="post">
  <div align= 'center'> <br/>
    <table border= "1" cellspacing="0">
	<tr><td>Course Prefix and Name</td><td>Credit <br/> Hours</td><td>Semester</td><td>Course<br/> Grade</td><td>Certification</td></tr>
         <tr><th colspan="2"><b>EM Program Core(Hours Required 18/21 hrs)</b></th><th>F,W,Sp,Su <br/>and Year</b></th><th>(A-F,I)</th><th>(O: Optional)<br/> (R: Required)</th></tr>
	<?php if($row['track']==6){//2018 track elective classes
          
         $pos_id=$_SESSION['pos_id'];
          echo getcname(EM505,$pos_id);
         echo getcname(EM509,$pos_id);
	       echo getcname(EM520,$pos_id);
	       echo getcname(EM531,$pos_id);
	       echo getcname(EM540,$pos_id);
	       echo getcname(EM620,$pos_id);
        echo "<tr colspan='5'><td colspan='5' align='right'><input type='submit' name='submit' value='Submit' /></td></tr>";
               }else{ echo $pos_id=$_SESSION['pos_id'];
         echo getcname(EM505,$pos_id);
         echo getcname(EM509,$pos_id);
	       echo getcname(EM520,$pos_id);
	       echo getcname(EM540,$pos_id);
	       echo getcname(EM570,$pos_id);
	       echo getcname(EM580,$pos_id);
	       echo getcname(EM695,$pos_id);
         echo "<tr colspan='5'><td colspan='5' align='right'><input type='submit' name='submit' value='Submit' /></td></tr>"; }
               ?>
         
     </table>
     <input type="hidden" name="chcore" value="1"/>
    </div>
   </form>
 </div>
 </div>

	<div id="tabs-3"><!--**********************************Track Concentration Courses *************************************************-->
  <form name="chtrack" action="posadmin.php#tabs-3" method="post">
  <div align= 'center'> <br/>
    <table border= "1" cellspacing="0">
         <tr><th colspan="5"><b><?if($row['track']==1){echo "Design and Manufacturing Track F2007";} if( $row['track']==2){echo "Lean Enterprise Systems Track F2007";} if( $row['track']==3){echo "Project/Program Management Track 2007";} if( $row['track']==4){echo "Quality Certificate Track F2007";}if( $row['track']==5){echo "R & D (Development Project) Track F2007";}if( $row['track']==6){echo "New Curriculum Fall 2018";}?> (Hours Required 18 hrs)</b></th></tr>

          <?$pos_id=$_SESSION['pos_id'];?>
          <?php if($row['track']==1){ echo getcname(EM511,$pos_id); echo getcname(EM558,$pos_id); echo getcname(EM620,$pos_id); echo getcname(EM636,$pos_id); echo getcname(EM649,$pos_id); echo getcname(EM670,$pos_id);}?>
          <?php if($row['track']==2){ echo getcname(EM556,$pos_id); echo getcname(EM558,$pos_id); echo getcname(EM620,$pos_id); echo getcname(EM649,$pos_id); echo getcname(EM659,$pos_id); echo getcname(EM669,$pos_id);}?>
          <?php if($row['track']==3){ echo getcname(EM519,$pos_id); echo getcname(EM547,$pos_id); echo getcname(EM556,$pos_id); echo getcname(EM609,$pos_id); echo getcname(EM620,$pos_id); echo getcname(EM649,$pos_id);}?>
          <?php if($row['track']==5){ echo getcname(EM547,$pos_id); echo getcname(EM620,$pos_id); echo getcname(QUAL647,$pos_id); echo getcname(EM691,$pos_id); echo getcname(EM690,$pos_id); echo getcname(QUAL551,$pos_id); echo getcname(QUAL557,$pos_id);echo getcname(QUAL651,$pos_id);}?>

          <?php if($row['track']==4){//this is quality track that is looklike elective classes
                $str="";
                $str .= "<table border= '1' cellspacing='0'>";
                $str .= "<tr><td>Course Name<br/><input name='elec_name' type='text' class='textfield' id='elec_name' /></td><td>Hours<br/><input name='elec_chr' type='text' class='textfield' id='elec_chr' size= '3' /></td><td>Semester<br/><input name='elec_semester' type='text' class='textfield' id='elec_semester' size= '3'/></td><td>Grade<br/><input name='elec_grade' type='text' class='textfield' id='elec_grade' size= '3'/></td><td>Certification<br/><input name='elec_certificate' type='text' class='textfield' id='elec_certificate'  size= '10'/></td><td size= '3'>Action</td></tr>";
                $str .= "<tr colspan='6'><td colspan='6' align='right'><input type='submit' name='submit' value='Submit' /></td></tr>";
                $str .= "<tr colspan='6'><th colspan='6'><b>Restricted Quality Track Courses(Hours Required 18 hrs)</b></th></tr>";
                 $eid=$_SESSION['pos_id'];
                 $result = mysql_query("SELECT * FROM elective WHERE elective.EID='{$eid}' AND elective.qualitytrack='1' ");
                 //$str="";
                 while($row = mysql_fetch_array($result)){
                            $str .="<tr><td>".$row['name']."</td>";
                            $str .="<td>".$row['chr']."</td>";
                            $str .="<td>".$row['semester']."</td>";
                            $str .="<td>".$row['grade']."</td>";
                            $str .="<td>".$row['certification']."</td>";
                            $str .="<td><a href=posadmin.php?elid=". $row['ELID'] ."#tabs-3>Delete</a></td>";
                 }
                 echo $str;
                 //mysql_close($connection);
               }else{ echo "<tr colspan='5'><td colspan='5' align='right'><input type='submit' name='submit' value='Submit' /></td></tr>"; }
               ?>
		<?php if($row['track']==6){//2018 track elective classes
                $str="";
                $str .= "<table border= '1' cellspacing='0'>";
                $str .= "<tr><td>Course Name<br/><input name='elec_name' type='text' class='textfield' id='elec_name' /></td><td>Hours<br/><input name='elec_chr' type='text' class='textfield' id='elec_chr' size= '3' /></td><td>Semester<br/><input name='elec_semester' type='text' class='textfield' id='elec_semester' size= '3'/></td><td>Grade<br/><input name='elec_grade' type='text' class='textfield' id='elec_grade' size= '3'/></td><td>Certification<br/><input name='elec_certificate' type='text' class='textfield' id='elec_certificate'  size= '10'/></td><td size= '3'>Action</td></tr>";
				$str .= "<tr colspan='6'><th colspan='6'><b>Restricted Quality Track Courses(Hours Required 18 hrs)</b></th></tr>";
                 $eid=$_SESSION['pos_id'];
                 $result = mysql_query("SELECT * FROM elective WHERE elective.EID='{$eid}' AND elective.qualitytrack='1' ");
                 //$str="";
                 while($row = mysql_fetch_array($result)){
                            $str .="<tr><td>".$row['name']."</td>";
                            $str .="<td>".$row['chr']."</td>";
                            $str .="<td>".$row['semester']."</td>";
                            $str .="<td>".$row['grade']."</td>";
                            $str .="<td>".$row['certification']."</td>";
                            $str .="<td><a href=posadmin.php?elid=". $row['ELID'] ."#tabs-3>Delete</a></td>";
                 }
                 echo $str;
                 //mysql_close($connection);
               }else{ echo "<tr colspan='5'><td colspan='5' align='right'><input type='submit' name='submit' value='Submit' /></td></tr>"; }
               ?>
     </table>
     <input type="hidden" name="chtrack" value="1"/>
     </div>
   </form>
	</div>

  <div id="tabs-4"><!--**********************************Elective Courses *************************************************-->

    <form name="chelective" action="posadmin.php#tabs-4" method="post">
  <div align= 'center'> <br/>
    <table border= "1" cellspacing="0">
         <tr><td>Course Name<br/><input name="elec_name" type="text" class="textfield" id="elec_name" /></td><td>Hours<br/><input name="elec_chr" type="text" class="textfield" id="elec_chr" size= "3" /></td><td>Semester<br/><input name="elec_semester" type="text" class="textfield" id="elec_semester" size= "3"/></td><td>Grade<br/><input name="elec_grade" type="text" class="textfield" id="elec_grade" size= "3"/></td><td>Certification<br/><input name="elec_certificate" type="text" class="textfield" id="elec_certificate"  size= "10"/></td><td size= "3">Action</td></tr>

         <tr colspan="6"><td colspan="6" align="right"><input type="submit" name="submit" value="Submit" /></td></tr>
         
         <tr colspan="6"><th colspan="6"><b> Elective Courses</pre></b></th></tr>
          <?php
          $eid=$_SESSION['pos_id'];
          $result = mysql_query("SELECT * FROM elective WHERE elective.EID='{$eid}' AND elective.qualitytrack=0");
          $str="";
          while($row = mysql_fetch_array($result)){
             $str .="<tr><td>".$row['name']."</td>";
             $str .="<td>".$row['chr']."</td>";
             $str .="<td>".$row['semester']."</td>";
             $str .="<td>".$row['grade']."</td>";
             $str .="<td>".$row['certification']."</td>";
             $str .="<td><a href=posadmin.php?elid=". $row['ELID'] ."#tabs-4>Delete</a></td></tr>";
          }
          echo $str;
          ////////////////mysql_close($connection);

          ?>
     </table>
     <input type="hidden" name="chelective" value="1"/>
     </div>
   </form>
	</div>

 <div id="tabs-5"><!--**********************************Summery *************************************************-->
 
 <script type="text/javascript">

function printSelection(node){

  var content=node.innerHTML
  var pwin=window.open('','print_content','width=100,height=100');

  pwin.document.open();
  pwin.document.write('<html><body onload="window.print()">'+content+'</body></html>');
  pwin.document.close();
 
  setTimeout(function(){pwin.close();},1000);

}
</script>

 
<a href="" onclick="printSelection(document.getElementById('test'));return false"><img src="style/images/print.jpg" /></a> <br/>
 
    <div id="test">
     <!--*****main Section Summery******-->
     <?php $row = getmember($_SESSION['pos_id']);?>
     <div align= 'center'>	 
	 
	
		<h2 >Master of Science in Engineering Management</h2>
         <h4>PROGRAM CODE: EMGT</h4>
         <h6>School Of Engineering Technology EASTERN MICHIGAN UNIVERSITY</h6>
         <table border= "1" cellspacing="0">
                <th colspan="5"><b>Plan of Study:<?if($row['track']==1){echo "Design and Manufacturing Track F2007";} if( $row['track']==2){echo "Lean Enterprise Systems Track F2007";} if( $row['track']==3){echo "Project/Program Management Track 2007";} if( $row['track']==4){echo "Quality Certificate Track F2007";}if( $row['track']==5){echo "R & D (Development Project) Track F2007";}?></th></tr>
                <tr><td><b>Student Name :<b/><?php echo( htmlspecialchars( $row['firstname'] ) ); ?><?php echo( htmlspecialchars( $row['lastname'] ) ); ?></td><td><b>Student ID :<b/><?php echo( htmlspecialchars( $row['studentID'] ) ); ?></td></tr>
                <tr><td><b>Cell phone : <b/><?php echo( htmlspecialchars( $row['phone'] ) ); ?></td><td><b>Email:<b/> <?php echo( htmlspecialchars( $row['email'] ) ); ?></td></tr>
                <tr><td><b>Admit Semester :<b/> <?php echo( htmlspecialchars( $row['bsemester'] ) ); ?></td><td><b>Academic Advisor :<b/> <?php echo( htmlspecialchars( $row['aadvisor'] ) ); ?></td></tr>
                <tr><td><b>Admit Status : <b/><?php echo( htmlspecialchars( $row['adstatus'] ) ); ?></td><td><b>Expected Final Semester :<b/> <?php echo( htmlspecialchars( $row['fsemester'] ) ); ?></td></tr>
         </table>
     </div><br/>

      <!--*****Core Section Summery******-->
      <?$pos_id=$_SESSION['$pos_id'];?>
      
     <div align= 'center'>
      <table border= "1" cellspacing="0">
         <tr><td>Course Prefix and Name</td><td>Credit <br/> Hours</td><td>Semester</td><td>Course<br/> Grade</td><td>Certification</td></tr>
         <tr><th colspan="2"><b>EM Program Core (Hours Required 18/21 hrs) </b></th><th>F,W,Sp,Su <br/>and Year</b></th><th>(A-F,I)</th><th>(O: Optional)<br/> (R: Required)</th></tr>
         <?$pos_id=$_SESSION['pos_id'];?>
         <? echo reportpos(EM505,$pos_id); echo reportpos(EM509,$pos_id); echo reportpos(EM520,$pos_id); echo reportpos(EM540,$pos_id); echo reportpos(EM570,$pos_id); echo reportpos(EM580,$pos_id); echo reportpos(EM695,$pos_id); ?>

    <!--*****Track Section Summery******-->
          <tr colspan='6'><th colspan='6'><b>Track Courses(Hours Required 18 hrs)</b></th></tr>
          <?$pos_id=$_SESSION['pos_id'];?>
          <?php if($row['track']==1){ echo reportpos(EM511,$pos_id); echo reportpos(EM558,$pos_id); echo reportpos(EM620,$pos_id); echo reportpos(EM636,$pos_id); echo reportpos(EM649,$pos_id); echo reportpos(EM670,$pos_id);}?>
          <?php if($row['track']==2){ echo reportpos(EM556,$pos_id); echo reportpos(EM558,$pos_id); echo reportpos(EM620,$pos_id); echo reportpos(EM649,$pos_id); echo reportpos(EM659,$pos_id); echo reportpos(EM669,$pos_id);}?>
          <?php if($row['track']==3){ echo reportpos(EM519,$pos_id); echo reportpos(EM547,$pos_id); echo reportpos(EM556,$pos_id); echo reportpos(EM609,$pos_id); echo reportpos(EM620,$pos_id); echo reportpos(EM649,$pos_id);}?>
          <?php if($row['track']==5){ echo reportpos(EM547,$pos_id); echo reportpos(EM620,$pos_id); echo reportpos(QUAL647,$pos_id); echo reportpos(EM691,$pos_id); echo reportpos(EM690,$pos_id); echo reportpos(QUAL551,$pos_id); echo reportpos(QUAL557,$pos_id);echo reportpos(QUAL651,$pos_id);}?>
          <?php if($row['track']==4){//this is quality track that is looklike elective classes
                 $str="";
                 //$str .= "<tr colspan='6'><th colspan='6'><b>No Track Courses(Hours Required 18 hrs)</b></th></tr>";
                 $eid=$_SESSION['pos_id'];
                 $result = mysql_query("SELECT * FROM elective WHERE elective.EID='{$eid}' AND elective.qualitytrack='1' ");
                 //$str="";
                 while($row = mysql_fetch_array($result)){
                            $str .="<tr><td>".$row['name']."</td>";
                            $str .="<td>".$row['chr']."</td>";
                            $str .="<td>".$row['semester']."</td>";
                            $str .="<td>".$row['grade']."</td>";
                            $str .="<td>".$row['certification']."</td>";
                            //$str .="<td><a href=posadmin.php?elid=". $row['ELID'] ."#tabs-3>Delete</a></td>";
                 }
                 echo $str;
                 //mysql_close($connection);
               }
               ?>
		
     <!--*****Elective Section Summery******-->
          <tr colspan="6"><th colspan="6"><b>Elective Courses</b></th></tr>
          <?php
          $eid=$_SESSION['pos_id'];
          $result = mysql_query("SELECT * FROM elective WHERE elective.EID='{$eid}' AND elective.qualitytrack=0");
          $str="";
          while($row = mysql_fetch_array($result)){
             $str .="<tr><td>".$row['name']."</td>";
             $str .="<td>".$row['chr']."</td>";
             $str .="<td>".$row['semester']."</td>";
             $str .="<td>".$row['grade']."</td>";
             $str .="<td>".$row['certification']."</td>";
          }
          echo $str;
          ////////////////mysql_close($connection);

          ?>
     </table>
     </div>
     
 </div>
 </div>
</div>

			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			
<?php include('includes/footer.php'); ?>