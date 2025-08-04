<?php require_once('includes/session.php'); 
 require_once("includes/connection.php"); 
 require_once('includes/functions.php'); 
 confirm_logged_in();
 include_once("includes/form_functions.php");
 check_supperuser();
?>

<!--------------------------------------Header------------------------------------->
<?php include('includes/header.php'); ?>
<!--------------------------------------form--------------------------------------->
<h3>Class forecasting</h3>
<hr /><br/><br/>
<form name="searchteam" action="studentlist.php" method="POST">
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

<!--------------------------------This section will be used for adding the students to the selected team-------------------------------------->
<h3>List of the students in this class</h3>

<table align='center'>
	<tr><th>Row</th><th>First Name</th><th>Last Name</th><th>E-mail</th></tr>
			<?php
					//echo $_POST['EMCID'].$_POST['courseyear'].$_POST['coursesemester'];
			    $str ="";
     			$str .="SELECT * FROM course, coursemember,member WHERE course.EMCID = ".$_POST['EMCID']." AND course.year=".$_POST['courseyear']." AND course.semester='".$_POST['coursesemester']."' AND coursemember.CID=course.CID AND member.EID=coursemember.EID";
     			$num=0;
	 			$result = mysqli_query($connection,$str);
                while($nt=mysqli_fetch_assoc($result)){
					 $num= $num+1;
					 echo "<tr><td>".$num."</td><td>".$nt['firstname']."</td><td>".$nt['lastname']."</td><td>".$nt['email']."</td></tr>";
					 

                 }
				 ?>

</table>


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