<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

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
	  $row = mysqli_fetch_assoc($result);
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
         $body = "Hello,\n\n  and welcome to Engineering Management website. Your password is changed to  $pass  please change your password after loging in to, http://emuem.org/em/index.php. Your user name is ($username) (Note if you don't have username your username is the first part of your email befor @).";
         if (mail($to, $subject, $body)) {
         $message ="<p>Your password changed, please sign into your email and try to log in through your account with provided email!</p>";
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
	} else { // Form has not been submitted.
		$email = "";
  }
?>

<?php include("includes/header.php");?>

	<h2>Email to all members</h2>

  <form action="massemail.php" method="post">
  <table>
        <tr><th >Please enter your email text</th></tr>
        
        <tr><td><textarea name="email" cols="60%" rows="20" id="email" /></td></tr>
        
        <tr><td><input type="submit" name="submit" value="Send" /></td></tr>

  </table>
  </form>


<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
<?php if (!empty($errors)) { display_errors($errors); } ?>
<?php include("includes/footer.php"); ?>



  
