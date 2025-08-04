<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();?>
<?php //check_supperuser();?>

<?php
	include_once("includes/form_functions.php");

	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.

		$errors = array();

    $gname = trim(($_POST['gname']));




    //echo  $question . $answer . $gname;
    //echo "form is submitted";


  if($gname == '') { $errors[] = 'Course name is missing'; }


  //search for existing term


		if ( empty($errors) ) {
		$_SESSION['gname']=$gname;
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}

		}


	} else { // Form has not been submitted.
    $gname="";
	$_SESSION['gname']="";
    $errors="";
    $message="";
 	}
	
	if (!empty($_GET["fid"])){
     $fid = $_GET["fid"];
     $result = mysqli_query($connection,"UPDATE faq SET approved='1'  WHERE FID='".$fid."'");
     $fid = '';
     $message=" you just Approved one FAQs";
     }
	 
	 if (!empty($_GET["fiddelet"])){
     $fiddelet = $_GET["fiddelet"];
     //$delquery="DELETE FROM glossary   WHERE gname='{$gname}'";
     
	 $delresult = mysqli_query($connection,"DELETE FROM faq   WHERE fid='".$fiddelet."'");
	 
	 //$result = mysql_query("UPDATE faq SET approved='1'  WHERE FID='{$fid}'");
     $fiddelete = '';
     $message=" The selecte FAQs id deleted successfully";
     }
	
?>


 <?php include('includes/header.php'); ?>
 </br>
 
 <!--*******************************************************FORM**************************************************-->
 
 <h3> Approve FAQ </h3>
 
	   

 <form action="approvefaq.php" method="post">
 
 <table align='left'>
 <tr>
 <td width="300">Select a Course Name to Activate its FAQs</td>
 <td>
 <?php
     $result = mysqli_query($connection,"SELECT DISTINCT gname FROM faq order by gname asc");
     echo "<select name=gname value=''><option value=''>-----Select one-----</option>";
      while($nt=mysqli_fetch_assoc($result)){echo "<option value=".$nt['gname'].">".$nt['gname']."</option>";}
      echo "</select>";
?>
 </td>
 <td>  <input type="submit" name="submit" value="Show unapproved FAQs" /> </td>
 
 </tr>
 </table>

</form>
 
 
 <!--THis is the section that we can see unapproved faqs from each course-->
<table>
<tr>
<th>Question</th>
<th>Answer</th>
<th>Name</th>
<th colspan="2" align="center">Action</th>
</tr>

<?php
if(!empty($_SESSION['gname'])){
$result = mysqli_query($connection,"SELECT * FROM faq WHERE gname='".$_SESSION['gname']."' AND  approved=0");
if(mysqli_num_rows($result) > 0) {

while($row = mysqli_fetch_assoc($result))
  {
  $row2 = getmember($row['EID']);
  echo "<tr>";
  echo "<td>" . $row['question'] . "</td>";
  echo "<td>" . $row['answer'] . "</td>";
  echo "<td>" . $row2['firstname'] ."  ". $row2['lastname'] . "</td>";

  echo "<td><a href=approvefaq.php?fid=". $row['FID'] .">Approve</a></td>";
  echo "<td><a href=approvefaq.php?fiddelet=". $row['FID'] .">Delete</a></td>";
  echo "</tr>";
  }
  }else{
  
	$message = "There is no unapproved FAQs left in this course";
  
  }
  }
?>
</table>

 

 
       <?php//you should use tab otherwise your template doesn't work ?>
       <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
       <?php if (!empty($errors)) { display_errors($errors); } ?>
	          
<?php include('includes/footer.php'); ?>