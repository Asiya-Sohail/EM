<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();?>
<?php //check_supperuser();?>

<?php
	include_once("includes/form_functions.php");
//	echo $_SESSION['user_id'];
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.

		$errors = array();

    $question = trim(($_POST['question']));
    $answer = trim(($_POST['answer']));
    $gname = trim(($_POST['gname']));




    //echo  $question . $answer . $gname;
    //echo "form is submitted";

  if($question == '') { $errors[] = 'Question is missing'; }
  if($answer == '') { $errors[] = 'Answer is missing'; }
  if($gname == '') { $errors[] = 'Course name is missing'; }
		

  //search for existing term

	$user_id = $_SESSION['user_id'];
		if ( empty($errors) ) {
			//$eid=$_SESSION['user_id'];
			$query = "INSERT INTO faq (
							gname,question,answer,EID
						) VALUES (
							'$gname','$question','$answer','$user_id'
						)";
			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "The Question/Answer is successfully added.";
			} else {
				$message = "The FAQ could not be created.";
				$message .= "<br/>" . mysqli_error($connection);
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}

		}


	} else { // Form has not been submitted.
    $EMCID="";
    $question="";
    $answer="";
    $errors="";
    $message="";
 	}
?>


 <?php include('includes/header.php'); ?>
 </br>
 <h3> Add Question and Answer page </h3>

 <form action="addfaq.php" method="post">
 <table align='left'>
 <tr>
 <th width="300">Course Name</th>
 <td>
 <?php
     $result = mysqli_query($connection,"SELECT DISTINCT gname FROM emcourse order by gname asc");
     echo "<select name=gname value=''><option value=''>-----Select one-----</option>";
      while($nt=mysqli_fetch_assoc($result)){echo "<option value=$nt[gname]>$nt[gname]</option>";}
      echo "</select>";
?>
 </td></tr>
  <tr>
      <th width="300">Question</th> <td width="300"><input name="question" type="text" class="textfield" id="question" /></td>
  </tr>
  </br></br> <tr></tr>
 <tr>
      <th width="300">Answer</th> <td><textarea name="answer" cols="40" rows="5" id="answer"> </textarea></td>
 </tr>
   <tr></tr><td>&nbsp;</td>
   <tr>
     <td>&nbsp;</td>
      <td colspan="2"><input type="submit" name="submit" value="Submit" /></td>
    </tr>
    

<tr>
 </br>
 </br>

       <?php//you should use tab otherwise your template doesn't work ?>
       <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
       <?php if (!empty($errors)) { display_errors($errors); } ?>
</tr>
 </table>

</form>

       
<?php include('includes/footer.php'); ?>