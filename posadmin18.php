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
    addcore2($_POST['semester_EM531'], $_POST['year_EM531'],$_POST['grade_EM531'],$_POST['certification_EM570'],'EM531');
	addcore2($_POST['semester_EM540'], $_POST['year_EM540'],$_POST['grade_EM540'],$_POST['certification_EM540'],'EM540');
    addcore2($_POST['semester_EM620'], $_POST['year_EM5620'],$_POST['grade_EM620'],$_POST['certification_EM620'],'EM620');
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

<form action="posadmin18.php" method="post">
 <input name="searchtxt" type="text" class="textfield" id="searchtxt" />
 <input type="submit" name="submit" value="search" /></td>
 <input type="hidden" name="search" value="1"/>
</form>
 <br/> <br/>
<form action="posadmin18.php" method="post">
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
        $str .="<tr><td>".$row['firstname']."</td><td>".$row['lastname']."</td><td>".$row['username']."</td><td>".$row['email']."</td><td><a href=posadmin18.php?eid=". $row['EID'] ." target='_blank'>Click here</a></td></tr>";
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
        $str .="<tr><td>".$row['firstname']."</td><td>".$row['lastname']."</td><td>".$row['username']."</td><td>".$row['email']."</td><td><a href=posadmin18.php?eid=". $row['EID'] .">Click here</a></td></tr>";
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
		<!--<li><a href="#tabs-3">Track Courses</a></li>-->
		<li><a href="#tabs-4">Elective Courses</a></li>
		<li><a href="#tabs-5">Summery</a></li>
	</ul>


	<div id="tabs-1"><!--**********************************Main Section- tab-1 *************************************************-->
	 <form name="chprofile" action="posadmin18.php#tabs-1" method="post">
     <div align= 'center'> <br/>
         <table border= "1" cellspacing="0">
                <!--<tr colspan="2"><th colspan="2"><b>Plan of Study:</b><select name="track" type="text" class="textfield" id="track" ><option value=""></option><option value="1" <?if($row['track']==1){echo "selected='selected'";}?>>Design and Manufacturing Track F2007</option><option value="2" <?if($row['track']==2){echo "selected='selected'";}?>>Lean Enterprise Systems Track F2007</option><option value="3"<?if($row['track']==3){echo "selected='selected'";}?>>Project/program Management Track 2007</option><option value="4" <?if($row['track']==4){echo "selected='selected'";}?>>Quality Certificate Track F2007</option><option value="5" <?if($row['track']==5){echo "selected='selected'";}?>>R & D (development Project) Track F2007</option></select></th></tr>-->
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
 <form name="chcore" action="posadmin18.php#tabs-2" method="post">
  <div align= 'center'> <br/>
    <table border= "1" cellspacing="0">
         <tr><td>Course Prefix and Name</td><td>Credit <br/> Hours</td><td>Semester</td><td>Course<br/> Grade</td><td>Certification</td></tr>
         <tr><th colspan="2"><b>EM Program Core(Hours Required 18 hrs)</b></th><th>F,W,Sp,Su <br/>and Year</b></th><th>(A-E,I)</th><th>(O: Optional)<br/> (R: Required)</th></tr>
         <?$pos_id=$_SESSION['pos_id'];?>
         <? echo getcname(EM505,$pos_id);?>
         <?echo getcname(EM509,$pos_id);?>
	       <?echo getcname(EM520,$pos_id);?>
	       <?echo getcname(EM531,$pos_id);?>
	       <?echo getcname(EM540,$pos_id);?>
	       <?echo getcname(EM620,$pos_id);?>
        <tr colspan="5"><td colspan="5" align="right"><input type="submit" name="submit" value="Submit" /></td></tr>
     </table>
     <input type="hidden" name="chcore" value="1"/>
    </div>
   </form>
 </div>
 </div>

	

  <div id="tabs-4"><!--**********************************Elective Courses *************************************************-->

    <form name="chelective" action="posadmin18.php#tabs-4" method="post">
  <div align= 'center'> <br/>
    <table border= "1" cellspacing="0">
         <tr><td>Course Name<br/><input name="elec_name" type="text" class="textfield" id="elec_name" /></td><td>Hours<br/><input name="elec_chr" type="text" class="textfield" id="elec_chr" size= "3" /></td><td>Semester<br/><input name="elec_semester" type="text" class="textfield" id="elec_semester" size= "3"/></td><td>Grade<br/><input name="elec_grade" type="text" class="textfield" id="elec_grade" size= "3"/></td><td>Certification<br/><input name="elec_certificate" type="text" class="textfield" id="elec_certificate"  size= "10"/></td><td size= "3">Action</td></tr>

         <tr colspan="6"><td colspan="6" align="right"><input type="submit" name="submit" value="Submit" /></td></tr>
         
         <tr colspan="6"><th colspan="6"><b>Elective Courses</pre></b></th></tr>
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
             $str .="<td><a href=posadmin18.php?elid=". $row['ELID'] ."#tabs-4>Delete</a></td></tr>";
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
         <tr><th colspan="2"><b>EM Program Core (Hours Required 18 hrs) </b></th><th>F,W,Sp,Su <br/>and Year</b></th><th>(A-E,I)</th><th>(O: Optional)<br/> (R: Required)</th></tr>
         <?$pos_id=$_SESSION['pos_id'];?>
         <? echo reportpos(EM505,$pos_id); echo reportpos(EM509,$pos_id); echo reportpos(EM520,$pos_id); echo reportpos(EM540,$pos_id); echo reportpos(EM570,$pos_id); echo reportpos(EM580,$pos_id); echo reportpos(EM695,$pos_id); ?>

    <!--*****Track Section Summery******-->
          

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