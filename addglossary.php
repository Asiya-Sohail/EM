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

    $term = trim(($_POST['term']));
    $definition = trim(($_POST['definition']));
    $EMCID = trim(($_POST['EMCID']));




    //echo  $term . $definition . $EMCID;
    //echo "form is submitted";

  if($term == '') { $errors[] = 'Term is missing'; }
  if($definition == '') { $errors[] = 'Definition is missing'; }
  if($EMCID == '') { $errors[] = 'Course name is missing'; }


  //search for existing term


		if ( empty($errors) ) {
			$query = "INSERT INTO glossary (
							EMCID,term,definition
						) VALUES (
							'$EMCID','$term','$definition'
						)";
			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "The term was successfully added.";
			} else {
				$message = "The term could not be created.";
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
    $term="";
    $definition="";
    $errors="";
 	}
?>


 <?php include('includes/header.php'); ?>
 </br>
 <h3> Add Glossary page </h3>

 <form action="addglossary.php" method="post">
 <table align='left'>
 <tr>
 <th width="300">Course Name</th>
 <td>
 <?php
     $result = mysqli_query("SELECT * FROM emcourse order by cname asc");
     echo "<select name=EMCID value=''><option value=''>-----Select one-----</option>";
      while($nt=mysqli_fetch_assoc($result)){echo "<option value=".$nt['EMCID'].">".$nt['cname']."</option>";}
      echo "</select>";
?>
 </td></tr>
  <tr>
      <th width="300">Term</th> <td width="300"><input name="term" type="text" class="textfield" id="term" /></td>
  </tr>
  </br></br> <tr></tr>
 <tr>
      <th width="300">Definition</th> <td><textarea name="definition" cols="40" rows="5" id="definition"> </textarea></td>
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
<?php if (!empty($errors)) { display_errors($errors); }?>
    
    </tr>

 </table>







</form>

       
<?php include('includes/footer.php'); ?>