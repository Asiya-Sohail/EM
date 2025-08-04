<?php require_once("includes/session.php");?>
<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php confirm_logged_in();?>

<?php include("includes/header.php");?>
<?php
     //will connect to member to retrieve username and other informatin for greating and picture   getmember is a function to get this information
     $str ="";
     $eid=$_SESSION['user_id'];
     $row_1 = getmember($eid);
	 #print_r($row_1);
     $str .= '<table><tr> <td><h3> Welcome '.$row_1['firstname'].'-'.$row_1['lastname'].' </h3></td> <td><img align = "right" src="'.getimage($eid).'"></td></tr></table></br>';
	//$str .=  "<a href='http://emuem.org/em/member.php'>Back to EM coursese</a>";
	  echo $str;
	  
	  //echo "<a href='http://emuem.org/em/member.php'>Back to EM coursese</a>";
?>


<div id="tabs">
	<ul>
    <li><a href="#tabs-1">EM Courses</a></li>
		<li><a href="#tabs-2">My Biography</a></li>
		<li><a href="#tabs-3">POS</a></li>
	</ul>
 

<div id="tabs-1"><!-------------------------------Begining of the tab-1 My Courses ------------------------------->

 <h3> List of Engineering Management Courses </h3>
       <?php
     $str ="";
     $str .="SELECT * FROM emcourse";
     $eid = $_SESSION['user_id'];
     $result = mysqli_query($connection,$str);

     $tbstr ="";
     $tbstr .= "<table border= '2' align='center'>";
     $tbstr .= "<tr><th><b>Course Name</b></th><th><b>Course number</b></th></tr>";
     while($row = mysqli_fetch_assoc($result))
  {
     $tbstr .= "<tr><td>";
     //if the course is active, it should be hyperlink to the course
     
        $tbstr .= "<a href=coursepage.php?emcid=". $row['EMCID'] .">". $row['cname'] ."</a>";
     
     $tbstr .= "</td><td>";
     $tbstr .= $row['title'];
     $tbstr .= "</td>";
  }
  $tbstr .= "</table>";
  echo $tbstr; 
?>
	
	
	<?php
     /*$str ="";
     $str .="SELECT emcourse.cname, course.year, course.semester, course.status, emcourse.face, course.EMCID FROM coursemember, course, emcourse WHERE coursemember.EID = {$_SESSION['user_id']} AND course.CID = coursemember.CID AND course.EMCID = emcourse.EMCID ORDER BY course.year, emcourse.cname";
     $eid = $_SESSION['user_id'];
     $result = mysql_query($str);

     $tbstr ="";
     $tbstr .= "<table border= '2' align='center'>";
     $tbstr .= "<tr><th><b>Course Name</b></th><th><b>Year</b></th><th><b>Semester</b></th><th><b>Active</b></th></tr>";
     while($row = mysql_fetch_array($result))
  {
     $tbstr .= "<tr><td>";
     //if the course is active, it should be hyperlink to the course
     if ($row['3']==1){
        $tbstr .= "<a href=coursepage.php?emcid=". $row[EMCID] .">". $row[cname] ."</a>";
     }else{ $tbstr .=$row['cname'];}
     $tbstr .= "</td><td>";
     $tbstr .= $row['1'];
     $tbstr .= "</td><td>";
     $tbstr .= $row['2'];
     $tbstr .= "</td><td>";
     if($row['3']==1){$tbstr .= "YES";}else{$tbstr .= "NO";}
     $tbstr .= "</td></tr>";
  }
  $tbstr .= "</table>";
  echo $tbstr; 
  */
?>

</div><!-------------------------------End of the tab-1 My Courses ------------------------------->

<div id="tabs-2"><!-------------------------------Begining of the tab-2 My Biography ------------------------------->
<?php
$eid=$_SESSION['user_id'];
$bio = getbiography($eid);
$biostr ="<h3> Introduction section</h3>";

$biostr .= "<table border= '1' align='center' width= '50%'>";
$biostr .= "<tr><th><b> 1. Undergraduate information:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['undergrad'];
$biostr .= "</td></tr>";
$biostr .= "<tr><th><b> 2. Graduate information:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['graduate'];
$biostr .= "</td></tr>";
$biostr .= "<tr><th><b> 3. Work experience:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['exp1'];
$biostr .= "</td></tr>";
$biostr .= "<tr><th><b> 4. any related certifications, professional registrations, and/or licenses that you may have:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['exp2'];
$biostr .= "</td></tr>";
$biostr .= "</table>";
echo $biostr;
?>
</div><!-------------------------------End of the tab-2 biography ------------------------------->

<div id="tabs-3"><!-------------------------------Begining of the tab-3 My POS ------------------------------->


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

 
<a href="" onclick="printSelection(document.getElementById('print'));return false"><img src="style/images/print.jpg" /></a> <br/>
 
    <div id="print"> <!-- Print area-->


	
	
     <!--*****main Section Summery******-->
     <?php   $row = getmember($_SESSION['user_id']);?>
     <div align= 'center'> <br/>
         <h2 >Master of Science in Enginnering Management</h2>
         <h4>PROGRAM CODE: EMGT</h4>
         <h6>School Of Engineering Technology EASTERN MICHIGAN UNIVERSITY</h6>
         <table border= "1" cellspacing="0">
                <th colspan="5"><b>Plan of Study:<?if($row['track']==1){echo "Design and Manufacturing Track F2007";} if( $row['track']==2){echo "Lean Enterprise Systems Track F2007";} if( $row['track']==3){echo "Project/Program Management Track 2007";} if( $row['track']==4){echo "Quality Certificate Track F2007";}if( $row['track']==5){echo "R & D (Development Project) Track F2007";}?></b></th></tr>
                <tr><td><b>Student Name :<b/><br/><?php echo( htmlspecialchars( $row['firstname'] ) ); ?><?php echo( htmlspecialchars( $row['lastname'] ) ); ?></td><td><b>Student ID :<b/><br/><?php echo( htmlspecialchars( $row['studentID'] ) ); ?></td></tr>
                <tr><td><b>Cell phone : <b/><br/><?php echo( htmlspecialchars( $row['phone'] ) ); ?></td><td><b>Email:<b/><br/> <?php echo( htmlspecialchars( $row['email'] ) ); ?></td></tr>
                <tr><td><b>Admit Semester :<b/><br/> <?php echo( htmlspecialchars( $row['bsemester'] ) ); ?></td><td><b>Academic Advisor :<b/> <br/><?php echo( htmlspecialchars( $row['aadvisor'] ) ); ?></td></tr>
                <tr><td><b>Admit Status : <b/><br/><?php echo( htmlspecialchars( $row['adstatus'] ) ); ?></td><td><b>Expected Final Semester :<b/> <br/><?php echo( htmlspecialchars( $row['fsemester'] ) ); ?></td></tr>
         </table><br/>
     </div>

      <!--*****Core Section Summery******-->

      <?$pos_id=$_SESSION['user_id'];?>
     <div align= 'center'> <br/>
      <table border= "1" cellspacing="0">
         <tr><td>Course Prefix and Name</td><td>Credit <br/> Hours</td><td>Semester</td><td>Course<br/> Grade</td><td>Certification</td></tr>
         <tr colspan="6"><th colspan="6"><b>Core Courses (Hours Required 21 hrs)</b></th></tr>
         <!-- <tr><th colspan="2"><b>EM Program Core(Hours Required 21 hrs)</b></th><th>F,W,Sp,Su <br/>and Year</b></th><th>(A-E,I)</th><th>(O: Optional)<br/> (R: Required)</th></tr> -->
		<?php echo reportpos('EM505',$pos_id); echo reportpos('EM509',$pos_id); echo reportpos('EM520',$pos_id); echo reportpos('EM540',$pos_id); echo reportpos('EM570',$pos_id); echo reportpos('EM580',$pos_id); echo reportpos('EM695',$pos_id); ?>



    <!--*****Track Section Summery******-->
    <tr colspan="6"><th colspan="6"><b>Track Courses (Hours Required 18 hrs)</b></th></tr>
          <?$pos_id=$_SESSION['user_id'];?>
          <?php if($row['track']==1){ echo reportpos(EM511,$pos_id); echo reportpos(EM558,$pos_id); echo reportpos(EM620,$pos_id); echo reportpos(EM636,$pos_id); echo reportpos(EM649,$pos_id); echo reportpos(EM670,$pos_id);}?>
          <?php if($row['track']==2){ echo reportpos(EM556,$pos_id); echo reportpos(EM558,$pos_id); echo reportpos(EM620,$pos_id); echo reportpos(EM649,$pos_id); echo reportpos(EM659,$pos_id); echo reportpos(EM669,$pos_id);}?>
          <?php if($row['track']==3){ echo reportpos(EM519,$pos_id); echo reportpos(EM547,$pos_id); echo reportpos(EM556,$pos_id); echo reportpos(EM609,$pos_id); echo reportpos(EM620,$pos_id); echo reportpos(EM649,$pos_id);}?>
          <?php if($row['track']==5){ echo reportpos(EM547,$pos_id); echo reportpos(EM620,$pos_id); echo reportpos(QUAL647,$pos_id); echo reportpos(EM691,$pos_id); echo reportpos(EM690,$pos_id); echo reportpos(QUAL551,$pos_id); echo reportpos(QUAL557,$pos_id);echo reportpos(QUAL651,$pos_id);}?>

          <?php if($row['track']==4){//this is quality track that is looklike elective classes
                 $str="";
                 //$str .= "<tr colspan='6'><th colspan='6'><b>Restricted Quality Track Courses(Hours Required 18 hrs)</b></th></tr>";
                 $eid=$_SESSION['user_id'];
                 $result = mysqli_query($connection,"SELECT * FROM elective WHERE elective.EID='".$eid."' AND elective.qualitytrack='1'");
                 //$str="";
                 while($row = mysqli_fetch_assoc($result)){
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
          <tr colspan="6"><th colspan="6"><b>Elective Courses(Hours Required 18 hrs)</b></th></tr>
          <?php
          $eid=$_SESSION['user_id'];
          $result = mysqli_query($connection,"SELECT * FROM elective WHERE elective.EID='".$eid."' AND elective.qualitytrack=0");
          $str="";
          while($row = mysqli_fetch_assoc($result)){
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








</div><!-------------------------------End of the tabs ------------------------------->


<?php include("includes/footer.php");?>
