<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php

	if (logged_in()) {
		redirect_to("member.php");
	}

	include_once("includes/form_functions.php");

	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();
     //echo "submited";
		// perform validations on the form data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$hashed_password = sha1($password);

		if ( empty($errors) ) {
			// Check database to see if username and the hashed password exist there.
			$query = "SELECT EID, username ";
			$query .= "FROM member ";
			$query .= "WHERE username = '$username' ";
			$query .= "AND password = '$hashed_password' ";
			$query .= "LIMIT 1";
			$result_set = mysqli_query($connection,$query);
			confirm_query($result_set);
			if (mysqli_num_rows($result_set) == 1) {
				// username/password authenticated
				// and only 1 match
				$found_user = mysqli_fetch_assoc($result_set);
				$_SESSION['user_id'] = $found_user['EID'];
				$_SESSION['username'] = $found_user['username'];
				$_SESSION['supperuser'] = $found_user['supperuser'];
        redirect_to("member.php");
			} else {
				// username/password combo was not found in the database
				$message = "Username/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.".$query;
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}

	} else { // Form has not been submitted.
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			$message = "You are now logged out.";
		}
		$username = "";
		$password = "";
	}
	
?>
<?php include("includes/header.php"); ?>

			<h2>Member Login</h2>

			<form action="login.php" method="post">
			<table>
				<tr>
					<td>Your E Number:</td>
					<td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />(eg. E00000000)</td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Login" /></td><td><a href="retrievepass.php">I forgot my password</a></td>
				</tr>
			</table>
			</form>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
<?php include("includes/footer.php"); ?>