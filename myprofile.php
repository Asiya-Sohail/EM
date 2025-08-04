<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>


<?php
     include_once("includes/form_functions.php");

//in this page we have three different form with three hidden file to keep track of which form is posted

//////////////////////changing profile\\\\\\\\\\\\\\\\\\\\\\\\\\
if (array_key_exists('chprofile', $_POST)) {
//echo "you are trying to change profile";

    $errors = array();

    //$studentID = trim(($_POST['studentID']));
   	$firstname = trim(($_POST['firstname']));
    $lastname = trim(($_POST['lastname']));
    $username = trim(($_POST['username']));
		//$password = trim(($_POST['password']));
		//$cpassword = trim(($_POST['cpassword']));
		$phone = trim(($_POST['phone']));
    $email = trim(($_POST['email']));
    $email1 ='';
    //$email1 = trim(($_POST['email1']));


  if($username == '') { $errors[] = 'username missing'; }
  //if($studentID == '') { $errors[] = 'StudentID missing'; }
  if($firstname == '') { $errors[] = 'First name missing'; }
  if($lastname == '') { $errors[] = 'Last name missing'; }
  if($email == '') { $errors[] = 'email is missing'; }
  

    if ( empty($errors) ) {

  		$query = "UPDATE member
                       SET firstname='".$firstname."', lastname='".$lastname."', phone='".$phone."', username='".$username."',email='".$email."',email1='".$email1."'
						           WHERE EID='".$_SESSION['user_id']."'";
       $result = mysqli_query($connection,$query);
			if ($result) {
				$message = "The profile was successfully updated.";
			} else {
				$message = "The profile could not be updated.";
				$message .= "<br />" . mysqli_error($connection,);
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {  $message = "There were " . count($errors) . " errors in the form.";	}
		}
}

//////////////////////changing passsword\\\\\\\\\\\\\\\\\\\\\\\\\\
if (array_key_exists('chpassword', $_POST)) {
//echo "you are trying to change password";

		$password = trim(($_POST['password']));
		$cpassword = trim(($_POST['cpassword']));
		if($password == '') { $errors[] = 'Password is missing'; }
    $hashed_password = sha1($password);
    if( strcmp($password, $cpassword) != 0 ) { $errors[]="passwords don't match";}
    if ( empty($errors) ){
    $query = "UPDATE member
                       SET password='".$hashed_password."'
						           WHERE EID='".$_SESSION['user_id']."'";
       $result = mysqli_query($connection,$query);
			if ($result) {
				$message = "The password was successfully changed.";
			} else {
				$message = "The password could not be updated.";
				$message .= "<br />" . mysqli_error($connection,);
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {  $message = "There were " . count($errors) . " errors in the form.";	}
		}
}

//////////////////////changing picture\\\\\\\\\\\\\\\\\\\\\\\\\\
if (array_key_exists('chpicture', $_POST)) {
 $errors = array();
//define a maxim size for the uploaded images
 define ("MAX_SIZE","100");
 // define the width and height for the thumbnail
 // note that theese dimmensions are considered the maximum dimmension and are not fixed,
 // because we have to keep the image ratio intact or it will be deformed
 define ("WIDTH","150");
 define ("HEIGHT","100");
 $errors=0;
  //reads the name of the file the user submitted for uploading
   $image=$_FILES['image']['name'];

 	if (!$image){$errors[] = 'You need to select a picture to upload';}
 	// if it is not empty
 	if ($image)
 	{
 		// get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['image']['name']);

 		// get the extension of the file in a lower case format
 	 	$extension = getExtension($filename);
 		$extension = strtolower($extension);
 		// if it is not a known extension, we will suppose it is an error, print an error message
 		//and will not upload the file, otherwise we continue
 		if (($extension != "jpg")  && ($extension != "jpeg") && ($extension != "png"))
 		{
       $errors[] = 'Unknown extension! The valid extensions are jpg, jpeg, png';
       //echo '<h1>Unknown extension!</h1>';
 			$errors=1;
 		}
 		else
 		{
 			// get the size of the image in bytes
 			// $_FILES[\'image\'][\'tmp_name\'] is the temporary filename of the file in which
			//the uploaded file was stored on the server
 			$size=getimagesize($_FILES['image']['tmp_name']);
 			$sizekb=filesize($_FILES['image']['tmp_name']);

 			//compare the size with the maxim size we defined and print error if bigger
 			if ($sizekb > MAX_SIZE*1024)
 			{
 				//echo '<h1>You have exceeded the size limit!</h1>';
 				$errors[] = 'You have exceeded the size limit!';
 				$errors=1;
 			}

  			//we will give an unique name, for example the time in unix time format

       //$imageid= time();
       $image_name=time().'.'.$extension;
	     //$image_name=$_SESSION['user_id'].'.'.$extension;
 			//the new name will be containing the full path where will be stored (images folder)
 		 	$newname="images/".$image_name;
 			$copied = copy($_FILES['image']['tmp_name'], $newname);
      //$copied= move_uploaded_file ( string $filename , string $destination );
      //$copied= move_uploaded_file ( $_FILES['image']['tmp_name'], $newname);
 			//we verify if the image has been uploaded, and print error instead
 			if (!$copied)
 			{

        // echo '<h1>Copy unsuccessfull!</h1>';
        $errors[] = 'Copy unsuccessfull!';
 				$errors=1;
 			}
 			else  {
 				// the new thumbnail image will be placed in images/thumbs/ folder
 				$thumb_name='images/thumbs/thumb_'.$image_name;
 				// call the function that will create the thumbnail. The function will get as parameters
 				//the image name, the thumbnail name and the width and height desired for the thumbnail
 				$thumb=make_thumb($newname,$thumb_name,WIDTH,HEIGHT);
 				//echo "copy successfully";

 			}

 			///////////////////
 			    if ( empty($errors) ){
     $row = getmember($_SESSION['user_id']);
     //delete previous image
     if (!($row['imageid'])){ unlink($row['imageid']);  }

     // upload the database with the name of the new file
    $query = "UPDATE member SET imageid='".$image_name."' WHERE EID='".$_SESSION['user_id']."'";
       $result = mysqli_query($connection,$query);
			if ($result) {
				$message = "The profile image is successfully changed.";
			} else {
				$message = "The profile image could not be updated.";
				$message .= "<br />" . mysqli_error($connection);
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {$errors = array();  $message = "There were " . count($errors) . " errors in the form.";	}
		}
 			//////////////////
    }
}else{ $errors[] = 'You need to select a picture to upload';}

}

//////////////////////changing Biography \\\\\\\\\\\\\\\\\\\\\\\\\\
if (array_key_exists('chpbio', $_POST)) {
    $errors = array();

    $undergrad = trim(($_POST['undergrad']));
   	$graduate = trim(($_POST['graduate']));
    $exp1 = trim(($_POST['exp1']));
    $exp2 = trim(($_POST['exp2']));

    //if($undergrad == '') { $errors[] = 'Undergrade information is missing'; }
    //if($graduate == '') { $errors[] = 'Graduate information is missing'; }
    //if($exp1 == '') { $errors[] = 'Work experience is name missing'; }
    //if($exp2 == '') { $errors[] = 'Other experience is missing'; }


    if ( empty($errors) ) {

    //CHECK TO SEE IF THE MEMBER HAS BIOID
    $result = mysqli_query($connection,"Select * From biography WHERE EID='".$_SESSION['user_id']."' LIMIT 1");
      if (mysqli_num_rows($result) == 1){

      //if the bio exists we need to update it
      $query = "UPDATE biography
                       SET undergrad='".$undergrad."', graduate='".$graduate."', exp1='".$exp1."', exp2='".$exp2."'
						           WHERE EID='".$_SESSION['user_id']."'";
		$result = mysqli_query($connection,$query);	
		if ($result) {
        $message = "";
        $message = "The Biography is successfully updated.";
		echo "Success";
			} else {
				echo "Failed";
				$message = "The Biography could not be updated.";
				$message .= "<br />" . mysqli_error($connection);
				
			}	
      }else{
      echo "second condition";
      echo $_SESSION['user_id'];
       $query = "INSERT INTO biography (undergrad,graduate,exp1,exp2,EID) VALUES ('".$undergrad."','".$graduate."','".$exp1."','".$exp2."','".$_SESSION['user_id']."')";
	    $result = mysqli_query($connection,$query);
		$bid = mysqli_insert_id($connection);
		echo $bid;
		if ($result) {
        $message = "";
        $message = "The Biography is successfully updated.";
		echo "Success";
			} else {
				echo "Failed";
				$message = "The Biography could not be updated.";
				$message .= "<br />" . mysqli_error($connection);
				
			}
      }
       #$result_1 = mysqli_query($connection,$query);
	   #$bid = mysqli_insert_id($connection);
	   #echo $query;
		
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {  $message = "There were " . count($errors) . " errors in the form.";	}
		}
}

//////////////////////Earasing the variables\\\\\\\\\\\\\\\\\\\\\\\\\\
if (!(array_key_exists('chprofile', $_POST)) AND !(array_key_exists('chpassword', $_POST))AND !(array_key_exists('chpicture', $_POST))) {
//echo "nothing is posted";
		$username = "";
		$password = "";
		$studentID="";
		$username="";
		$firstname="";
		$lastname="";
		$row="";
		$eid="";
		$errors="";
		$message="";


}
?>
<?php include("includes/header.php");?>

<?/////////////////////////////********************form**************************\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\?>


 <?php
     //will connect to member to retrieve username and other informatin for greating and picture   getmember is a function to get this information
     $str ="";
     $eid=$_SESSION['user_id'];
     $row = getmember($eid);
     $str .= '<table ><tr> <td><h3> Edit my profile </h3></td> <td><img align = "right" src="'.getimage($eid).'"></td></tr></table></br>';
     echo $str;
?>
	    <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>


<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Profile</a></li>
		<li><a href="#tabs-2">Password</a></li>
		<li><a href="#tabs-3">Picture</a></li>
		<li><a href="#tabs-4">Biography</a></li>
	</ul>
	
	
	<div id="tabs-1">

  <!--This form is designed to handle profile change -->
<h5> Change profile</h5>
  <form name="chprofile" method="post" action="myprofile.php#tabs-1">
  <table width="300" border="1" align="center" cellpadding="2" cellspacing="0">
      <tr>
      <th width="124">Student E Number </th>  <td width="168"><input name="username" ReadOnly="True" type="text" class="textfield" id="username" value="<?php echo( htmlspecialchars( $row['username'] ) ); ?>"/></td>
    </tr>
    <!--
	<tr>
      <th width="124">Student ID</th> <td width="168"><input name="studentID" type="text" class="textfield" id="studentID" value="<?php echo( htmlspecialchars( $row['studentID'] ) ); ?>"/></td>
    </tr>
	-->
    <tr>
      <th>First Name </th>      <td><input name="firstname" type="text" class="textfield" id="firstname" value="<?php echo( htmlspecialchars( $row['firstname'] ) ); ?>"/></td>
    </tr>
    <tr>
      <th>Last Name </th>        <td><input name="lastname" type="text" class="textfield" id="lastname" value="<?php echo( htmlspecialchars( $row['lastname'] ) ); ?>"/></td>
    </tr>
     <tr>
      <th width="124">Phone</th>  <td width="168"><input name="phone" type="text" class="textfield" id="phone" value="<?php echo( htmlspecialchars( $row['phone'] ) ); ?>"/></td>
    </tr>
    <tr>
      <th width="200">Personal Email (not emich email)</th>  <td width="168"><input name="email" type="text" class="textfield" id="email" value="<?php echo( htmlspecialchars( $row['email'] ) ); ?>"/></td>
    </tr>
    <?php /* 
     <tr>
     
      <th width="200">Email</th>  <td width="168"><input name="email1" type="text" class="textfield" id="email1" value="<?php echo( htmlspecialchars( $row['email1'] ) ); ?>"/></td>
    </tr>
     */ ?>
     <tr>
      <td colspan="2" align="right"><input type="submit" name="submit" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="chprofile" value="1"/>
</form>
	</div>
	     <!--End of the profile change -->
	
	
	<div id="tabs-2"> <!--This form is designed to handle password change -->
<form name="chpassword" method="post" action="myprofile.php#tabs-2">
<h5> Change password</h5>
    <table width="300" border="1" align="center" cellpadding="2" cellspacing="0">
     <tr>
      <th>Password</th>          <td><input name="password" type="password" class="textfield" id="password" /></td>
    </tr>
    <tr>
      <th>Confirm Password </th> <td><input name="cpassword" type="password" class="textfield" id="cpassword" /></td>
    </tr>
    <tr>

   <td colspan="2" align="right"><input type="submit" name="submit" value="Submit" /></td> </tr>
   </table>

   <input type="hidden" name="chpassword" value="1"/>

  </form>
	</div><!--End of the password change -->
	
	
	<div id="tabs-3">	<!--This form is designed to handle picture change -->
  <form name="chpicture" method="post" enctype="multipart/form-data"  action="myprofile.php#tabs-3">
  <h5> Change your profile picture</h5>
  <table width="700" border="1" align="center" cellpadding="2" cellspacing="0">
     <tr>
      <th>Select an image for your profile</th>          <td><input type="file" name="image" ></td>
    </tr>
    <tr>
      <th>Upload your picture </th> <td><input name="Submit" type="submit" value="Upload image"></td>
    </tr>
    <tr>
  </table>
  <p><br/>
  Note:<br/>
  1. Image size cannot be bigger than 1 Mbyte.<br/>
  2. Image name should not have speciall characters (eg. space, ! @ # $ % ^ & _ - etc ...) <br/>
  3. Image extention shoudl be either .jpg, .jpeg, .png
  </p>
  
   <input type="hidden" name="chpicture" value="1"/>
</form>
	
	</div><!--End of the picture change -->

	<div id="tabs-4">	<!--This form is designed to handle Biography or introduction change -->
<?php
$eid=$_SESSION['user_id'];
$bio = getbiography($eid); ?>


<h5>Edit Biography and introduction section</h5>

  <form name="chprofile" method="post" action="myprofile.php#tabs-4">
  <table width="600" border="1" align="center" cellpadding="2" cellspacing="0">

    <tr>  <th colspan="2">Your undergraduate degree(s)</th></tr>
    </tr> <td colspan="2"><textarea name="undergrad" cols="70%" rows="5" id="coursedescription" /><?php echo ($bio['undergrad'] ); ?></textarea><br></td> </tr>

    <tr> <th colspan="2">Your graduate degree(s)</th></tr>
    <tr> <td colspan="2"><textarea name="graduate" cols="70%" rows="5" id="coursedescription" /><?php echo ($bio['graduate']); ?></textarea><br></td> </tr>

    <tr> <th colspan="2">Your work experience</th></tr>
    <tr> <td colspan="2"><textarea name="exp1" cols="70%" rows="5" id="coursedescription" /><?php echo ($bio['exp1']); ?></textarea><br></td> </tr>

    <tr> <th colspan="2">Any related certifications, professional registrations, and/or licenses that you may have</th></tr>
    <tr> <td colspan="2"><textarea name="exp2" cols="70%" rows="5" id="coursedescription" /><?php echo ($bio['exp2']); ?></textarea><br></td> </tr>


    <tr>
      <td colspan="2" align="middle"><input type="submit" name="submit" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="chpbio" value="1"/>

</form>
	</div> <!--End of the Bio change -->

</div> <!--End of the tabs div -->


<?php include("includes/footer.php"); ?>




