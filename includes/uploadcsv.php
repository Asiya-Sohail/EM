<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();?>
<?php check_supperuser();?>

<?php
	include_once("includes/form_functions.php");
	
//*************************************************************FAQ*****************************************************************\\
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

       /////check for redundant recorde, so replace the redundant recorde\\\\\\
      ///Delete all of the record and replace with new one\\\
      //////////////\\\\\/////\\\\\\\\\\\\\\
      $delquery="DELETE FROM faq   WHERE gname='$gname'";
      $delresult = mysqli_query($connection,$delquery);


    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;

    /////////////////open database\\\\\\\\\\\\\\
    if ( empty($errors) ) {
      $query = "INSERT INTO faq (
							gname,question,answer,approved
						) VALUES (
							'".$gname."','".$data[0]."','".$data[1]."',1
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
 $str="";
 }
 



 

//*************************************************************Glossary*****************************************************************\\
if (array_key_exists('MAX_FILE_SIZE_GLOSSARY', $_POST)) { // Form has been submitted.
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


       /////check for redundant recorde, so replace the redundant recorde\\\\\\
      ///Delete all of the record and replace with new one\\\
      //////////////\\\\\/////\\\\\\\\\\\\\\
      $delquery="DELETE FROM glossary   WHERE gname='".$gname."'";
      $delresult = mysqli_query($connection,$delquery);



    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;

    /////////////////open database\\\\\\\\\\\\\\
    if ( empty($errors) ) {

     $query = "INSERT INTO glossary (
							gname,term,definition
						) VALUES (
							'".$gname."','".$data[0]."','".$data[1]."'
						)";
			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "<h5>The Glossary file is successfully uploaded.</h5>";
			} else {
				$message = "The Glossary could not be created.";
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
 }


 //*************************************************************Resource*****************************************************************\\
if (array_key_exists('MAX_FILE_SIZE_RESOURCE', $_POST)) { // Form has been submitted.

	$errors = array();
  $gname = trim(($_POST['gname']));

	/////////////////////////////////////////upload the CSV file \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 $target = "upload/";
 $target = $target . basename( $_FILES['uploadedfile']['name']) ;

 $ok=1;
 //
 if ($gname == ""){$errors[] ="You need to select the course before uploading the csv file";}

 if ($target == ""){$errors[] ="you need to select a csv file that contains: (Resource name, resource type (1 for Journals, 2 for Websites, and 3 for Software), reource link)";}

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
       /////check for redundant recorde, so replace the redundant recorde\\\\\\
      ///Delete all of the record and replace with new one\\\
      //////////////\\\\\/////\\\\\\\\\\\\\\
      $delquery="DELETE FROM resource   WHERE gname='".$gname."'";
      $delresult = mysqli_query($connection,$delquery);


    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;

    /////////////////open database\\\\\\\\\\\\\\
    if ( empty($errors) ) {
      $query = "INSERT INTO resource (
							gname,rname,rtype,rlink
						) VALUES (
							'".$gname."','".$data[0]."','".$data[1]."','".$data[2]."'
						)";
			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "<h5>The resource file is successfully uploaded.</h5>";
			} else {
				$message = "The resource could not be created.";
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

 }
 else{
 $errors="";
 $messages="";
 $str="";
 }

//*************************************************************Students' Courses*****************************************************************\\
if (array_key_exists('MAX_FILE_SIZE_STUDENTS-COURSES', $_POST)) { // Form has been submitted.

	$errors = array();
  $year = trim(($_POST['courseyear']));
  $semester = trim(($_POST['coursesemester']));
  //echo $year.$semester;

	/////////////////////////////////////////upload the CSV file \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 $target = "upload/";
 $target = $target . basename( $_FILES['uploadedfile']['name']) ;

 $ok=1;
 //
 if ($year == ""){$errors[] ="You need to select the year before uploading the csv file";}
 if ($semester == ""){$errors[] ="You need to select the semester before uploading the csv file";}

 if ($target == ""){$errors[] ="you need to select a csv file that contains: (EID, student name, email, course, and live/online (1/0))";}

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
      $query = "SELECT username From member WHERE username= '".$data[0]."'";
      $result = mysqli_query($connection,$query);
	 
      if (mysqli_num_rows($result)==0){
		echo 'inside if';
         $name = explode(",",$data[1]);

         $query = "INSERT INTO member (
							studentID,username,lastname,firstname,email
						) VALUES (
							'".$data[0]."','".$data[0]."','".$name[0]."','".$name[1]."','".$data[2]."'
						)";
		echo $query;
		$result = mysqli_query($connection,$query);
				
      	}
		
      	
      //check for the existing course in the course table
      $gname= "EM".$data[3];
      $result = mysqli_query($connection,"Select * From emcourse WHERE gname='".$gname."' AND face='".$data[4]."' LIMIT 1");
      $row = mysqli_fetch_assoc($result);


      $result2 = mysqli_query($connection,"SELECT * From course WHERE EMCID='".$row['EMCID']."' AND year='".$year."' AND semester= '".$semester."'");

      if (mysqli_num_rows($result2)==0){
         $query1 = "INSERT INTO course (
							EMCID,year,semester, status
						) VALUES (
							'".$row['EMCID']."','".$year."','".$semester."','1'
						)";

			    $result = mysqli_query($connection,$query1);
      	}
      	
      ///under the construction\\\
      //////////////\\\\\/////\\\\\\\\\\\\\\
	  $result = mysqli_query($connection,"SELECT EID From member WHERE username= '".$data[0]."'");
      $member = mysqli_fetch_assoc($result);
	
	  

      $result = mysqli_query($connection,"Select CID From course WHERE course.EMCID = (SELECT EMCID FROM emcourse WHERE gname='".$gname."' 
         AND face='".$data[4]."' LIMIT 1) AND year='".$year."' AND semester= '".$semester."' ");
      $course = mysqli_fetch_assoc($result);

	//echo "course.CID=" . $course[CID];
      $q = "Select CID From course WHERE course.EMCID = (SELECT EMCID FROM emcourse WHERE gname='".$gname."' 
         AND face='".$data[4]."' LIMIT 1) AND year='".$year."' AND semester= '".$semester."' ";
      $coursemember = mysqli_query($connection,"Select * From coursemember WHERE coursemember.EID ='".$member['EID']."' AND coursemember.CID='".$course['CID']."' ");
       if (mysqli_num_rows($coursemember)==0){
      
      $query = "INSERT INTO coursemember (EID,CID) VALUES ('".$member['EID']."', '".$course['CID']."')";

			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "<h5>The resource file is successfully uploaded.</h5>";
			} else {
				$message = "The resource could not be created.";
				$message .= "<br/>" . mysqli_error($connection);
			}
			
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

 }


 else{
 $errors="";
 $messages="";
 $str="";
 }
 
 
 //*************************************************************TextBook*****************************************************************\\
if (array_key_exists('MAX_FILE_SIZE_TEXTBOOK', $_POST)) { // Form has been submitted.
  $errors = array();
  //$gname = trim(($_POST['gname']));

	/////////////////////////////////////////upload the CSV file \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 $target = "upload/";
 $target = $target . basename( $_FILES['uploadedfile']['name']) ;

 $ok=1;
 //
 //if ($gname == ""){$errors[] ="You need to select the course before uploading the csv file";}

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

      /////check for redundant recorde, so replace the redundant recorde\\\\\\
      ///Delete all of the record and replace with new one\\\
      //////////////\\\\\/////\\\\\\\\\\\\\\
      //$delquery="DELETE FROM textbook   WHERE gname='".$gname."'";
      echo $gname;
      $delresult = mysqli_query($connection,"DELETE FROM textbook");
      
      
      
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;

    /////////////////open database\\\\\\\\\\\\\\
    if ( empty($errors) ) {
      $query = "INSERT INTO textbook (
							gname,txtbook,required
						) VALUES (
							'".$data[0]."','".$data[1]."','".$data[2]."'
						)";
			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "<h5>The Textbook file is successfully uploaded.</h5>";
			} else {
				$message = "The Textbook could not be created.";
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
 }

?>













<?php include('includes/header.php'); ?>

<?/////////////////////////////**********************************form********************************************\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\?>


 <?php
     //will connect to member to retrieve username and other informatin for greating and picture   getmember is a function to get this information
     $str ="";
     $str .= '<table ><tr> <td><h2> Upload Comma Seprated Value (CSV) file </h2></td></tr><tr><td></td></tr></table><br/><br/>';
     echo $str;

?>

	    <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>



<div id="tabs">
	<ul>
    <li><a href="#tabs-1">FAQ</a></li>
		<li><a href="#tabs-2">Glossary</a></li>
		<li><a href="#tabs-3">Resource</a></li>
		<li><a href="#tabs-4">Students</a></li>
		<li><a href="#tabs-5">TextBook</a></li>
		<li><a href="#tabs-6">Help</a></li>
	</ul>


<div id="tabs-1"><!-------------------------------Begining of the tab-1 uploading F.A.Q ------------------------------->
<form name="uploadcsv" enctype="multipart/form-data" method="post" action="uploadcsv.php#tabs-1">

        <h3> Add F.A.Q page </h3>

        <table width="300" border="1" align="center" cellpadding="2" cellspacing="0">

               <tr>
               <th><h6>First select the Course Name</h6></th>
               <td>
               <?php
                    $result = mysqli_query($connection,"SELECT DISTINCT gname FROM emcourse order by gname asc");
                    echo "<select name=gname value=''><option value=''>-----Select one-----</option>";
                    while($nt=mysqli_fetch_assoc($result)){echo "<option value=$nt[gname]>$nt[gname]</option>";}
                    echo "</select>";
               ?>
               </td>
               </tr>
               
               <tr>
               <input type="hidden" name="MAX_FILE_SIZE" value="100000" /><br />
               <th> <h6>Then choose a CSV file to upload: </h6></th><td><input name="uploadedfile" type="file" /><br /><br /></td>
               </tr>

               <tr>
                   <td colspan="2" align="right"><input type="submit" value="Upload File" /> </td>
               </tr>

        </table>
        <br/>
        Download a <a href="general/faq.csv" target="_BLANK">FAQ.CSV</a> Example
</form>
</div> <!-------------------------------end of the tab-1 uploading F.A.Q ------------------------------->


<div id="tabs-2"><!-------------------------------Begining of the tab-2 uploading Glossary ------------------------------->
<form name="uploadcsv" enctype="multipart/form-data" method="post" action="uploadcsv.php#tabs-2">

        <h3> Add Glossery page </h3>

        <table width="300" border="1" align="center" cellpadding="2" cellspacing="0">

               <tr>
               <th><h6>First select the Course Name</h6></th>
               <td>
               <?php
                    $result = mysqli_query($connection,"SELECT DISTINCT gname FROM emcourse order by gname asc");
                    echo "<select name=gname value=''><option value=''>-----Select one-----</option>";
                    while($nt=mysqli_fetch_assoc($result)){echo "<option value=".$nt['gname'].">".$nt['gname']."</option>";}
                    echo "</select>";
               ?>
               </td>
               </tr>

               <tr>
               <input type="hidden" name="MAX_FILE_SIZE_GLOSSARY" value="100000" /><br />
               <th> <h6>Then choose a CSV file to upload: </h6></th><td><input name="uploadedfile" type="file" /><br /><br /></td>
               </tr>

               <tr>
                   <td colspan="2" align="right"><input type="submit" value="Upload File" /> </td>
               </tr>

        </table>
        <br/><br/>
        Download a <a href="general/glossary.csv" target="_BLANK">Glossary.CSV</a> Example
</form>
</div> <!-------------------------------end of the tab-3 uploading Glossary------------------------------->


<div id="tabs-3"><!-------------------------------Begining of the tab-3 uploading resource ------------------------------->

<form name="uploadresource" enctype="multipart/form-data" method="post" action="uploadcsv.php#tabs-3">

        <h3> Add Resources </h3>

        <table width="300" border="1" align="center" cellpadding="2" cellspacing="0">

               <tr>
               <th><h6>First select the Course Name</h6></th>
               <td>
               <?php
                    $result = mysqli_query($connection,"SELECT DISTINCT gname FROM emcourse order by gname asc");
                    echo "<select name=gname value=''><option value=''>-----Select one-----</option>";
                    while($nt=mysqli_fetch_assoc($result)){echo "<option value=".$nt['gname'].">".$nt['gname']."</option>";}
                    echo "</select>";
               ?>
               </td>
               </tr>

               <tr>
               <input type="hidden" name="MAX_FILE_SIZE_RESOURCE" value="100000" /><br />
               <th> <h6>Then choose a CSV file to upload: </h6></th><td><input name="uploadedfile" type="file" /><br /><br /></td>
               </tr>

               <tr>
                   <td colspan="2" align="right"><input type="submit" value="Upload File" /> </td>
               </tr>

        </table>
         <br/><br/>
        Download a <a href="general/resource.csv" target="_BLANK">Resource.CSV</a> Example
</form>

</div> <!-----------------------------------------end of the tab-3 resource------------------------------------->



<div id="tabs-4"><!-------------------------------Begining of the tab-4 Students-Courses ------------------------------->

<form name="uploadstudents-courses" enctype="multipart/form-data" method="post" action="uploadcsv.php#tabs-4">

        <h3> Upload the Students' Courses </h3>

        <table width="300" border="1" align="center" cellpadding="2" cellspacing="0">

               <tr>
                   <th><h6>First select the year</h6></th>
                   <td><?echo dropyear();?></td>
               </tr>

               <tr>
                   <th><h6>Second select the Semester</h6></th>
                   <td><?echo dropsemester();?></td>

               </tr>

               <tr>
               <input type="hidden" name="MAX_FILE_SIZE_STUDENTS-COURSES" value="100000" /><br />
               <th> <h6>Then choose a CSV file to upload: </h6></th><td><input name="uploadedfile" type="file" /><br /><br /></td>
               </tr>

               <tr>
                   <td colspan="2" align="right"><input type="submit" value="Upload File" /> </td>
               </tr>

        </table>
         <br/><br/>
        Download a <a href="general/StudentsCourses.csv" target="_BLANK">Students-Courses.CSV</a> Example
</form>


</div> <!-------------------------------end of the tab-4 Students-Courses------------------------------->



<div id="tabs-5"><!-------------------------------Begining of the tab-5 uploading TextBook ------------------------------->
<form name="uploadcsv" enctype="multipart/form-data" method="post" action="uploadcsv.php#tabs-5">

        <h3> Upload TextBooks </h3>

        <table width="300" border="1" align="center" cellpadding="2" cellspacing="0">

               <tr>
               <input type="hidden" name="MAX_FILE_SIZE_TEXTBOOK" value="100000" /><br />
               <th> <h6>Then choose a CSV file to upload: </h6></th><td><input name="uploadedfile" type="file" /><br /><br /></td>
               </tr>

               <tr>
                   <td colspan="2" align="right"><input type="submit" value="Upload File" /> </td>
               </tr>

        </table>
        <br/>
        Download a <a href="general/textbook.csv" target="_BLANK">TEXTBOOK.CSV</a> Example
</form>
</div> <!-------------------------------end of the tab-5 uploading Textbook ------------------------------->



<div id="tabs-6"><!-------------------------------Begining of the tab-5 Help ------------------------------->
<p>
<p>
1. Upload FAQ :<br/> In order to create the CSV file for this part you need a table that has two columns witout header. In the first column you put the question and the second column should contain the answer.

<table width="300" border="1" align="center" cellpadding="2" cellspacing="0">Example <tr><td>How  can I change my password?</td><td>Click on Students tab, Select Edit my profil, then go to change password section</td></tr></table>
</p>
<br/><br/><br/>

<p>
2. Upload Glossary : <br/> In order to create the CSV file for this part you need a table that has two columns witout header. In the first column you put the term and the second column should contain definition.

<table width="300" border="1" align="center" cellpadding="2" cellspacing="0">Example <tr><td>4 Ms</td><td>Man/ woman, machine, material, and method (p-29)</td></tr></table>
</p>
<br/><br/><br/>

<p>
3. Upload Resource : <br/> In order to create the CSV file for this part you need a table that has three columns witout header. In the first column you need to put the resource name and the second column should contain resource type ( 1 for Journals, 2 for Websites, and 3 for Software). Finally, the third Column should have the Resource link.

<table width="300" border="1" align="center" cellpadding="2" cellspacing="0">Example <tr><td>Lean Management Journal</td><td>1</td><td>http://www.leanmj.com/</td></tr><tr><td>Lean Manufacturing Software</td><td>3</td><td>http://www.qad.com/lean-manufacturing.html</td></tr></table>
</p>

<br/><br/><br/>

<p>
4. Upload Students and their classes : <br/> In order to create the CSV file for this part you need a table that has five columns witout header. In the first column you need to put the Student ID (Exxxxxxxx) and the second column should contain lastname, firstname. The third column should have the students' EMU email account and the fourth column should contain the course name without EM (e.g. 520). Finaly the last column should have the the type of the class. (  0 for online and  1 for face to face class).

<table width="300" border="1" align="center" cellpadding="2" cellspacing="0">Example <tr><td>E00000000</td><td>Smith,Brian</td><td>Bsmith@emich.edu</td><td>505</td><td>1</td></tr><tr><td>E00000000</td><td>Smith,Brian</td><td>Bsmith@emich.edu</td><td>505</td><td>0</td></tr></table>
</p>

<p>
5. Upload Books : <br/> In order to create the CSV file for this part you need a table that has three columns witout header. In the first column you need to put the Course name (such as EM520) and the second column should contain Book information. Finally, the third Column should have the code to define if the book is required or optional (1 for requird and 0 for optional).

<table width="300" border="1" align="center" cellpadding="2" cellspacing="0">Example <tr><td>EM520</td><td>Applied economic analysis for technologists, engineers, and managers, By: Michael S. Bowman, Upper Saddle River, NJ: Prentice Hall., 2nd. ed., 2003 ISBN: 0-13-094511-0</td><td>1</td></tr><tr><td>EM520</td><td>Taking Sides: Clashing Views in Business Ethics and Society (Paperback) By: Lisa Newton,  Elaine Englehardt , Michael Pritchard McGraw-Hill/Dushkin; 11 edition ISBN-10: 0073527319</td><td>0</td></tr></table>
</p>

<br/><br/><br/>


</div> <!-------------------------------end of the tab-5 Help------------------------------->



</div> <!-------------------------------end of the tabs uploading------------------------------->

<?php include('includes/footer.php');?>