<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();?>
<?php check_supperuser();?>
<?php
     include_once("includes/form_functions.php");

     // START FORM PROCESSING
     if (isset($_POST['submit'])) { // Form has been submitted.
     $errors = array();
     
     //error handling
     
     $EMCID = $_POST['EMCID'];
     $courseyear = $_POST['courseyear'];
     $coursesemester = $_POST['coursesemester'];
     //echo $EMCID, $courseyear, $coursesemester;
     if($EMCID == '') { $errors[] = 'You need to select a course'; }
     if($courseyear == '') { $errors[] = 'You need to select a year'; }
     if($coursesemester == '') { $errors[] = 'you need to select a semester'; }
     

     if (empty($errors)){

         $result = mysqli_query($connection,"SELECT * FROM course WHERE EMCID='".$EMCID."'AND year='".$courseyear."' AND semester='".$coursesemester."'");
         if (mysqli_num_rows($result)>0){

         //when the course, year, and semester exists
         
         $result = mysqli_query($connection,"UPDATE course SET status='1'  WHERE  EMCID='".$EMCID."'AND year='".$courseyear."' AND semester='".$coursesemester."'");
    	   if ($result) {$message="You activate one course";}
         } else{

           //when the course, year, and semester doesn't exists and we should insert it into our course table
           
           $query = "INSERT INTO course (
					 		EMCID,year,semester,status
					   	) VALUES (
					    		'".$EMCID."','".$courseyear."','".$coursesemester."','1'
					   	)";
		    	$result = mysqli_query($connection,$query);
		     	if ($result) {$message="You add and activate one course"; }
         }

      }
     } else{
      $message="";
      $EMCID="";
      $courseyear ="";
      $coursesemester ="";
     }
     
     //deactivation side when admin click on the deactivation link in front of each course
     
     if (!empty($_GET["cid"])){
     $cid = $_GET["cid"];
     $result = mysqli_query($connection,"UPDATE course SET status='0'  WHERE CID='".$cid."'");
     $cid = '';
     $message=" you just deactivate one course";
     }
?>
<?php include('includes/header.php'); ?>
 </br>
 <h3> Course activation section </h3>
 </br>
 
 <form action="courseactivation.php" method="post">
 <table align='center'>
 <tr>
 <td>
<?php
     $result = mysqli_query($connection,"SELECT * FROM emcourse order by cname asc");
     echo "Course Name <select name=EMCID value=''><option value=''>-----Select one-----</option>";
      while($nt=mysqli_fetch_assoc($result)){echo "<option value=".$nt['EMCID'].">".$nt['cname']."</option>";}
      echo "</select>";
?>
 </td>


 <td>
 <?echo dropyear();?>
</td>
<td>Semester<select name="coursesemester" type="text" class="textfield" id="coursesemester"><option value="">-----Select one-----</option><option value="Fall">Fall</option><option value="Winter">Winter</option><option value="Spring">Spring</option><option value="Summer">Summer</option></select> </td>
</td>

 <td>  <input type="submit" name="submit" value="Activate" /> </td>
 </tr>
</table>
</br>
</br>
</form>

       <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
       <?php if (!empty($errors)) { display_errors($errors); } ?>

<?php


//show active courses in the table

echo "
<h2> Active Courses</h2>
<table border='1' align='center'>
<tr>
<th>Course Name</th>
<th>Semester</th>
<th>Year</th>
<th>Status</th>
<th>Face to Face</th>
<th>Title</th>
<th>Action</th>
</tr>";
$result = mysqli_query($connection,"SELECT * FROM course, emcourse WHERE status='1' AND  course.EMCID = emcourse.EMCID  ORDER BY cname");
while($row = mysqli_fetch_assoc($result))
  {
  echo "<tr>";
  echo "<td>" . $row['cname'] . "</td>";
  echo "<td>" . $row['semester'] . "</td>";
  echo "<td>" . $row['year'] . "</td>";
  echo "<td>" . $row['status'] . "</td>";
  
  if($row['face']==0){
  echo "<td>Online </td>";
  }else{
  echo "<td>Live </td>";
  }
  
  
  //echo "<td>" . $row['face'] . "</td>";
  echo "<td>" . $row['title'] . "</td>";
  echo "<td><a href=courseactivation.php?cid=". $row['CID'] .">Deactive</a></td>";
  echo "</tr>";
  }
echo "</table>";
mysqli_close($connection);
?>

<?php include('includes/footer.php'); ?>