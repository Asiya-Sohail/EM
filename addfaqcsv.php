<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();?>
<?php check_supperuser();?>

<?php

	include_once("includes/form_functions.php");

   if (array_key_exists('MAX_FILE_SIZE', $_POST)) { // Form has been submitted.

	$errors = array();
  $gname = trim(($_POST['gname']));

	/////////////////////////////////////////upload the CSV file \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 $target = "upload/";
 $target = $target . basename( $_FILES['uploadedfile']['name']) ;

 $ok=1;
 //
 if ($gname == ""){$errors[] ="You need to select the course before uploading the csv file";}
 
 if ($target == ""){$errors[] ="you need to select a csv file that contains: (term, definition)";}
 
 //This is our size condition
 if ($uploaded_size > 350000) { $errors[] = 'Your file is too large.<br>'; $ok=0; }

 //This is our limit file type condition
  if(!(end(explode('.', $_FILES['uploadedfile']['name']))=='csv')){ $errors[] = 'The uploaded file is not CSV files<br>'; $ok=0; }


 //Here we check that $ok was not set to 0 by an error
 if ($ok==0) { $errors[] = 'Sorry your file was not uploaded'; }

 //If everything is ok we try to upload it
 else
 {
 if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target))
 {
 $message = "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded <br/>";
 
 
 
 /////////////////////////////Upload CSV to DataBase \\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 $row = 1;
if (($handle = fopen($target, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        
    /////////////////open database\\\\\\\\\\\\\\
    if ( empty($errors) ) {

      /////check for redundant recorde, so replace the redundant recorde\\\\\\\
      ///under the construction\\\
      //////////////\\\\\/////\\\\\\\\\\\\\\
      
      $query = "INSERT INTO gfaq (
							gname,question,answer
						) VALUES (
							'$gname','$data[0]','$data[1]'
						)";
			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "<h5>The Question/Answer is successfully uploaded.</h5>";
			} else {
				$message = "The FAQ could not be created.";
				$message .= "<br/>" . mysqli_error($connection);
			}
		} else { if (count($errors) == 1) {$message = "There was 1 error in the form.";} else {$message = "There were " . count($errors) . " errors in the form.";	}   }
		
    ////////////////close database\\\\\\\\\\\\\\\\\\\\\\\\\
    }
    fclose($handle);
  }
 ///////////////////////////// End of Upload CSV to DataBase \\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 }
 else { $errors[] = 'Sorry, there was a problem uploading your file.'; }
 }
 //////////////////////////////////////end of uploading CSV file \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

 }else{
 $errors="";
 $messages="";
 }
?>
	
	
	
	
	


<?php include('includes/header.php'); ?>

<!-- ////////////////The main form\\\\\\\\\\\\\\\\\ -->

<form name="uploadcsv" enctype="multipart/form-data" method="post" action="addfaqcsv.php">

<h3> Add Glossery page </h3>
 
<table>

 <tr>
 <th ><h6>First select the Course Name</h6></th>
 <td>
 <?php
     $result = mysqli_query($connection,"SELECT DISTINCT gname FROM emcourse order by gname asc");
     echo "<select name=gname value=''><option value=''>-----Select one-----</option>";
     while($nt=mysqli_fetch_assoc($result)){echo "<option value=$nt[gname]>$nt[gname]</option>";}
     echo "</select>";
?>

<tr>
<input type="hidden" name="MAX_FILE_SIZE" value="100000" /><br />
<th> <h6>Then choose a CSV file to upload: </h6></th><td><input name="uploadedfile" type="file" /><br /><br /></td>
</tr>

<tr>
<td><input type="submit" value="Upload File" /> </td>
</tr>




 <tr><td>
         <?php//you should use tab otherwise your template doesn't work ?>
         <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
         <?php if (!empty($errors)) { display_errors($errors); }?>
</td></tr>
</table>

</form>

<?php include('includes/footer.php');?>



