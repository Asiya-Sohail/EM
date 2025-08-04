<?php require_once('includes/session.php'); 
 require_once("includes/connection.php"); 
 require_once('includes/functions.php'); 
 confirm_logged_in();
 include_once("includes/form_functions.php");
 check_supperuser();
?>
<?		if(!empty($_GET["CID"]) and !empty($_GET["CTID"])){
			$_SESSION['CTID']=$_GET['CTID'];
			$_SESSION['CID']=$_GET['CID'];
		}		
?>
<!--------------------------------------Header------------------------------------->
<?php include('includes/header.php'); ?>
<!--------------------------------------form--------------------------------------->
<h3>Step1. Select a team</h3>
<hr /><br/><br/>
<form name="searchteam" action="peerreport.php" method="POST">
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
	$_SESSION['CTID']="";
	$_SESSION['CID']="";
    $str ="";
    $str ="SELECT * FROM course, courseteam WHERE course.EMCID = ".$_POST['EMCID']." AND courseteam.CID = course.CID AND course.year='".$_POST['courseyear']."' AND course.semester='".$_POST['coursesemester']."' AND course.CID=courseteam.CID  ORDER BY courseteam.ctname";
    $result = mysqli_query($connection,$str);
    $tbstr ="";
    $tbstr .= "<table border= '0' align='center'>";
    while($row = mysqli_fetch_assoc($result)){
		$tbstr .= "<tr><th>";
		$tbstr .= $row['ctname'].$row['CTID'];
		$tbstr .= "</th></tr><tr><td>";	
		
		// bring the student names who are in this team
		
     	$stquery ="SELECT * FROM cmteam, member WHERE cmteam.CTID = ".$row['CTID']." AND member.EID=cmteam.EID";
		$stresult = mysqli_query($connection,$stquery);
		$tbstr .= "<table border= '1' align='center'>";
     	$tbstr .= "<tr><th><b>Student Name</b></th><th><b>Ave</b></th><th><b>rate1</b></th><th><b>rate2</b></th><th><b>rate3</b></th><th><b>rate4</b></th><th><b>rate5</b></th><th><b>rate6</b></th><th><b>rate7</b></th><th><b>rate8</b></th><th><b>rate9</b></th></tr>";
		     while($srow = mysqli_fetch_assoc($stresult)){
				$tbstr .= "<tr><td>";
				$tbstr .= $srow['firstname'].'--'.$srow['lastname'];
				//create the evaluation statistics for each students
				$evalresult = mysqli_query($connection,"SELECT * FROM peerevaluation WHERE CMTID = ".$srow['CMTID']."");
				 $rate1=0; $rate2=0; $rate3=0; $rate4=0; $rate5=0; $rate6=0; $rate7=0; $rate8=0; $rate9=0; $total=0;
				 while($evalrow = mysqli_fetch_assoc($evalresult)){
					 $rate1 = $rate1 + $evalrow['rate1'];
					 $rate2 = $rate2 + $evalrow['rate2'];
					 $rate3 = $rate3 + $evalrow['rate3'];
					 $rate4 = $rate4 + $evalrow['rate4'];
					 $rate5 = $rate5 + $evalrow['rate5'];
					 $rate6 = $rate6 + $evalrow['rate6'];
					 $rate7 = $rate7 + $evalrow['rate7'];
					 $rate8 = $rate8 + $evalrow['rate8'];
					 $rate9 = $rate9 + $evalrow['rate9'];
					 $total= ($rate1 +$rate2 +$rate3 +$rate4 +$rate5 +$rate6 +$rate7 +$rate8+$rate9)/9;				 
				 }
				$tbstr .="<td>".$total."</td><td>".$rate1."</td><td>".$rate2."</td><td>".$rate3."</td><td>".$rate4."</td><td>".$rate5."</td><td>".$rate6."</td><td>".$rate7."</td><td>".$rate8."</td><td>".$rate9."</td></tr>";
		 	}
		  	$tbstr .= "</table><br/>";
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

<?php include('includes/footer.php'); ?>