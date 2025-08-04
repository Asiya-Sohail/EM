<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php //confirm_logged_in(); ?>

<?php
	include_once("includes/form_functions.php");

	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.

		$errors = array();
    $email = trim(($_POST['email']));
    if($email == '') { $errors[] = 'email is missing'; }


  //chech for existing username
  if($email != '' and empty($errors)) {
    //$qry = "SELECT * FROM member WHERE email='$email'";
		$result = mysqli_query($connection,"SELECT * FROM member WHERE email='$email'");
	  $row = mysqli_fetch_array($result);
		$username = $row['username'];
		if($result) {
			if(mysqli_num_rows($result) > 0) {
			  
        $pass=generatePassword();
        $hashpass= sha1($pass);
        //echo $pass;
        $result = mysqli_query($connection,"UPDATE member SET password='$hashpass'  WHERE email='$email'");

        //sending email
         $to = $email;
         $subject = "Retrive password!";
         $body = "Hello,\n\n  and welcome to Engineering Management website. Your password is changed to  $pass  please change your password after loging in to, http://emuem.org/em/index.php. @).";
         if (mail($to, $subject, $body)) {
         $message ="<p>Your password changed, please sign into your EMU's email (or to the email that you have submitted at admissions) and try to log in with your new password!</p>";
         } else {
        $message ="<p>Message delivery failed...</p>";
         }

      	// 5. Close connection
       	mysqli_close($connection);
      }
      else {
      $errors[] = ' There is no such an email exist in our database !!!';
      }
		}
		else {
			die("Query failed11111111111111");
		}
	}


   // echo $username, $password, $hashed_password;
    /*
		if ( empty($errors) ) {
			$query = "INSERT INTO member (
							studentID,firstname,lastname,phone,username, password
						) VALUES (
							'{$studentID}','{$firstname}','{$lastname}','{$phone}','{$username}', '{$hashed_password}'
						)";
			$result = mysql_query($query, $connection);
			if ($result) {
				$message = "The user was successfully created.";
			} else {
				$message = "The user could not be created.";
				$message .= "<br />" . mysql_error();
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}*/

	} else { // Form has not been submitted.
		$email = "";
  }
?>



<?php include("includes/header.php");?>

			<h2>Retrieve password page</h2>

  <form action="retrievepass.php" method="post">
  <table  border="0" align="center" cellpadding="2" cellspacing="0">
      <tr>
      <th >Please enter your EMU's email address (or to the email that you have submitted at admissions) </th>  <td width="168"><input name="email" type="text" class="textfield" id="email" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><input type="submit" name="submit" value="retrieve" /></td>
    </tr>
  </table>
</form>

<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
<?php if (!empty($errors)) { display_errors($errors); } ?>


<?php

/*
 $to = "mj.esmaeili@gmail.com";
 $subject = "Retrive password!";
 $body = "Hi,\n\nHow are you?";
 if (mail($to, $subject, $body)) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }*/

/*
 require_once "Mail.php";

 $from = "Sandra Sender <sender@example.com>";
 $to = "Ramona Recipient <mj.esmaeili@yahoo.com>";
 $subject = "Hi!";
 $body = "Hi,\n\nHow are you?";

 $host = "mail.example.com";
 $username = "smtp_username";
 $password = "smtp_password";

 $headers = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject);
 $smtp = Mail::factory('smtp',
   array ('host' => $host,
     'auth' => true,
     'username' => $username,
     'password' => $password));

 $mail = $smtp->send($to, $headers, $body);

 if (PEAR::isError($mail)) {
   echo("<p>" . $mail->getMessage() . "</p>");
  } else {
   echo("<p>Message successfully sent!</p>");
  }    */
 ?>


<?php include("includes/footer.php"); ?>



  
