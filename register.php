<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php //confirm_logged_in(); ?>


<?php
	include_once("includes/form_functions.php");

	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
	
	echo "form is submited";
		$errors = array();

		// perform validations on the form data
    //$required_fields = array('username', 'password');
  	//$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

     
		//$fields_with_lengths = array('username' => 30, 'password' => 30);
		//$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

    //$studentID = trim(($_POST['studentID']));
   	$firstname = trim(($_POST['firstname']));
    $lastname = trim(($_POST['lastname']));
    $username = trim(($_POST['username']));
		$password = trim(($_POST['password']));
		$cpassword = trim(($_POST['cpassword']));
		$phone = trim(($_POST['phone']));
    $email = trim(($_POST['email']));
    $email1 = '';
    //$email1 = trim(($_POST['email1']));
		$hashed_password = sha1($password);

   // echo   $studentID,$firstname,$lastname,$username,$password,$cpassword,$phone,$hashed_password;

  if($username == '') { $errors[] = 'username missing'; }
  //if($studentID == '') { $errors[] = 'StudentID missing'; }
  if($firstname == '') { $errors[] = 'Ffirst name missing'; }
  if($lastname == '') { $errors[] = 'Last name missing'; }
  if($email == '') { $errors[] = 'email is missing'; }
  if($password == '') { $errors[] = 'Password missing'; }
  
  if( strcmp($password, $cpassword) != 0 ) { $errors[]="passwords don't match";}


  //chech for existing username
  if($username != '') {
    //$connection = mysql_connect(mysql.emuem.org,emuem001_chandu,7349851666);

    //$db_select = mysql_select_db(emuem,$connection);
    
    
    $qry = "SELECT * FROM member WHERE username='$username'";
		$result = mysqli_query($connection,$qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				$errors[] = 'Username already in use, Please chose another username';
      	// 5. Close connection
       	mysqli_close($connection);
      }
		}
		else {
			die("Query failed");
		}
	}


   // echo $username, $password, $hashed_password;

		if ( empty($errors) ) {
			$query = "INSERT INTO member (
							firstname,lastname,phone,username, password, email,email1
						) VALUES (
							'".$firstname."','".$lastname."','".$phone."','".$username."', '".$hashed_password."', '".$email."','".$email1."'
						)";
			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "The user was successfully created.";
			} else {
				$message = "The user could not be created.";
				$message .= "<br />" . mysqli_error($connection);
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}

	} else { // Form has not been submitted.
		$username = "";
		$password = "";
 	}
?>



<?php include("includes/header.php");?>


			<h2>Create New User</h2>



  <form action="register.php" method="post">
  <table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
      <tr>
      <th width="124">Student E Number (eg. Exxxxxxxx)</th>  <td width="168"><input name="username" type="text" class="textfield" id="username" /></td>
    </tr>
    <!--
	<tr>
      <th width="124">Student ID</th> <td width="168"><input name="studentID" type="text" class="textfield" id="studentID" /></td>
    </tr>
	-->
    <tr>
      <th>First Name </th>      <td><input name="firstname" type="text" class="textfield" id="firstname" /></td>
    </tr>
    <tr>
      <th>Last Name </th>        <td><input name="lastname" type="text" class="textfield" id="lastname" /></td>
    </tr>
      <tr>
      <th>Password</th>          <td><input name="password" type="password" class="textfield" id="password" /></td>
    </tr>
    <tr>
      <th>Confirm Password </th> <td><input name="cpassword" type="password" class="textfield" id="cpassword" /></td>
    </tr>
    <tr>

    <tr>
      <th width="124">Phone</th>  <td width="168"><input name="phone" type="text" class="textfield" id="phone" /></td>
    </tr>
    <tr>
      <th width="124">Email</th>  <td width="168"><input name="email" type="text" class="textfield" id="email" /></td>
    </tr>
<!--
<tr>
      <th width="124">Other Email</th>  <td width="168"><input name="email1" type="text" class="textfield" id="email1" /></td>
    </tr>
-->
      <td>&nbsp;</td>
      <td colspan="2"><input type="submit" name="submit" value="register" /></td>
    </tr>
  </table>
</form>

			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			
			
<?php include("includes/footer.php"); ?>