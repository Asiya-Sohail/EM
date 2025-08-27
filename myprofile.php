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
//////////////////////changing picture\\\\\\\\\\\\\\\\\\\\\\\\\\
if (array_key_exists('chpicture', $_POST)) {
    $errors = array();  // Initialize as array
    
    // Define maximum size for the uploaded images (1MB = 1000KB)
    define ("MAX_SIZE","1000");
    // Define the width and height for the thumbnail
    define ("WIDTH","150");
    define ("HEIGHT","100");
    
    // Reads the name of the file the user submitted for uploading
    $image = $_FILES['image']['name'];

    // Check if file was selected
    if (empty($image)) {
        $errors[] = 'You need to select a picture to upload';
    } else {
        // Get the original name of the file from the clients machine
        $filename = stripslashes($_FILES['image']['name']);

        // Get the extension of the file in a lower case format
        $extension = getExtension($filename);
        $extension = strtolower($extension);
        
        // Check for valid extensions
        if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png")) {
            $errors[] = 'Unknown extension! The valid extensions are jpg, jpeg, png';
        } else {
            // Get the size of the image in bytes
            $size = getimagesize($_FILES['image']['tmp_name']);
            $sizekb = filesize($_FILES['image']['tmp_name']);

            // Compare the size with the maximum size we defined
            if ($sizekb > MAX_SIZE * 1024) {
                $errors[] = 'You have exceeded the size limit of ' . MAX_SIZE . 'KB!';
            } else {
                // Create directories if they don't exist
                if (!file_exists('images')) {
                    mkdir('images', 0755, true);
                }
                if (!file_exists('images/thumbs')) {
                    mkdir('images/thumbs', 0755, true);
                }

                // Generate unique filename
                $image_name = $_SESSION['user_id'] . '_' . date('Ymd_His') . '.' . $extension;
                
                // Debug output
                echo "<!-- DEBUG: Generated filename: " . $image_name . " -->";
                echo "<!-- DEBUG: Filename length: " . strlen($image_name) . " characters -->";
                
                // The new name will contain the full path where it will be stored (images folder)
                $newname = "images/" . $image_name;
                
                // Copy the uploaded file to the destination
                $copied = copy($_FILES['image']['tmp_name'], $newname);
                
                if (!$copied) {
                    $errors[] = 'Copy unsuccessful! Check folder permissions.';
                } else {
                    echo "<!-- DEBUG: File copied successfully to: " . $newname . " -->";
                    
                    // Create thumbnail
                    $thumb_name = 'images/thumbs/thumb_' . $image_name;
                    
                    // Check if GD extension is available for thumbnail creation
                    if (extension_loaded('gd')) {
                        $thumb = make_thumb($newname, $thumb_name, WIDTH, HEIGHT);
                        echo "<!-- DEBUG: Thumbnail created: " . $thumb_name . " -->";
                    } else {
                        echo "<!-- DEBUG: GD extension not loaded, skipping thumbnail creation -->";
                        // Copy original as thumbnail if GD is not available
                        copy($newname, $thumb_name);
                    }
                }
            }
        }
    }

    // Only proceed if no errors occurred
    if (empty($errors)) {
        $row = getmember($_SESSION['user_id']);

        // Delete previous image if it exists
        if (!empty($row['imageid'])) {
            $old_original = 'images/' . $row['imageid'];
            $old_thumbnail = 'images/thumbs/thumb_' . $row['imageid'];
            
            if (file_exists($old_original)) {
                unlink($old_original);
                echo "<!-- DEBUG: Deleted old original: " . $old_original . " -->";
            }
            if (file_exists($old_thumbnail)) {
                unlink($old_thumbnail);
                echo "<!-- DEBUG: Deleted old thumbnail: " . $old_thumbnail . " -->";
            }
        }

        // Update the database with the new filename
        $query = "UPDATE member SET imageid = ? WHERE EID = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "ss", $image_name, $_SESSION['user_id']);
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            $message = "The profile image is successfully changed.";
            echo "<!-- DEBUG: Database updated with imageid: " . $image_name . " -->";
            
            // Verify what was actually saved
            $verify_row = getmember($_SESSION['user_id']);
            echo "<!-- DEBUG: Verified imageid in database: " . $verify_row['imageid'] . " -->";
        } else {
            $message = "The profile image could not be updated.";
            $message .= "<br />" . mysqli_error($connection);
        }
    } else {
        // Handle errors
        $error_count = count($errors);
        if ($error_count == 1) {
            $message = "There was 1 error in the form.";
        } else {
            $message = "There were " . $error_count . " errors in the form.";
        }
    }
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
    //  $str .= '<table ><tr> <td><h3> Edit my profile </h3></td> <td><img align = "right" src="'.getimage($eid).'"></td></tr></table></br>';
     $str .= '<div class="profile-header">
        <h2>Edit My Profile</h2>
        <div class="profile-image-container">
            <img src="'.getimage($eid).'" alt="Profile Picture" class="profile-image">
        </div>
    </div>';
    //  echo $str;
?>
	    <!-- <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?> -->


	<div class="profile-container">
   <?php echo $str; ?>

    <?php if (!empty($message)): ?>
    <div class="message">
        <i class="fas fa-check-circle"></i> <?php echo $message; ?>
    </div>
    <?php endif; ?>
		<?php if (!empty($errors)) { display_errors($errors); } ?>


    <div class="tabs-system">
        <nav class="tabs-nav">
            <ul>
                <li class="active"><a href="#profile-tab">Profile</a></li>
                <li><a href="#password-tab">Password</a></li>
                <li><a href="#picture-tab">Picture</a></li>
                <li><a href="#bio-tab">Biography</a></li>
            </ul>
        </nav>

        <div class="tabs-content">
            <!-- Profile Tab -->
            <div id="profile-tab" class="tab-pane active">
                <form name="chprofile" method="post" action="">
                    <div class="form-section">
                        <h3>Personal Information</h3>
                        <div class="form-group">
                            <label>Student E Number</label>
                            <input type="text" class="textfield" name="username" value="<?php echo( htmlspecialchars( $row['username'] ) ); ?>" readonly>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="textfield" name="firstname" value="<?php echo( htmlspecialchars( $row['firstname'] ) ); ?>">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="textfield" name="lastname" value="<?php echo( htmlspecialchars( $row['lastname'] ) ); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="textfield" name="phone" value="<?php echo( htmlspecialchars( $row['phone'] ) ); ?>">
                        </div>
                        <div class="form-group">
                            <label>Personal Email (not emich email)</label>
                            <input type="email" class="textfield" name="email" value="<?php echo( htmlspecialchars( $row['email'] ) ); ?>">
                        </div>
                    </div>
                    <div class="form-actions">
                        <!-- <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button> -->
												<input type="submit" class="btn-primary" name="submit" value="Submit" />
                        <input type="hidden" name="chprofile" value="1">
                        <button type="button" class="btn-next" data-tab="password-tab">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Tab -->
            <div id="password-tab" class="tab-pane">
                <form name="chpassword" method="post" action="">
                    <div class="form-section">
                        <h3>Change Password</h3>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="textfield" name="password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="textfield" name="cpassword">
                        </div>
                    </div>
                    <div class="form-actions">
												<input class="btn-primary" type="submit" name="submit" value="Change Password" />
                        <input type="hidden" name="chpassword" value="1">
                        <button type="button" class="btn-prev" data-tab="profile-tab">
                            <i class="fas fa-chevron-left"></i> Back
                        </button>
                        <button type="button" class="btn-next" data-tab="picture-tab">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Picture Tab -->
            <div id="picture-tab" class="tab-pane">
                <form name="chpicture" method="post" action="" enctype="multipart/form-data">
                    <div class="form-section">
                        <h3>Profile Picture</h3>
                        <div class="form-group">
                            <label>Select Image</label>
                            <div class="file-upload">
                                <input type="file" name="image">
                            </div>
                        </div>
                        <div class="form-notes">
                            <h4><i class="fas fa-info-circle"></i> Upload Guidelines</h4>
                            <ul>
                                <li>Maximum file size: 1 MB</li>
                                <li>Allowed formats: JPG, JPEG, PNG</li>
                                <li>Avoid special characters in filename (eg. space, ! @ # $ % ^ & _ - etc ...)</li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-actions">
												<input class="btn-primary" name="Submit" type="submit" value="Upload image">
                        <input type="hidden" name="chpicture" value="1">
                        <button type="button" class="btn-prev" data-tab="password-tab">
                            <i class="fas fa-chevron-left"></i> Back
                        </button>
                        <button type="button" class="btn-next" data-tab="bio-tab">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Biography Tab -->
            <div id="bio-tab" class="tab-pane">
						<?php
							$eid=$_SESSION['user_id'];
							$bio = getbiography($eid); 
						?>
                <form name="chprofile" method="post" action="">
                    <div class="form-section">
                        <h3>Professional Biography</h3>
                        <div class="form-group">
                            <label>Undergraduate Degree(s)</label>
                            <textarea name="undergrad" rows="4" id="coursedescription"><?php echo htmlspecialchars($bio['undergrad'] ); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Graduate Degree(s)</label>
                            <textarea name="graduate" rows="4" id="coursedescription"><?php echo htmlspecialchars($bio['graduate']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Work Experience</label>
                            <textarea name="exp1" rows="4" id="coursedescription"><?php echo htmlspecialchars($bio['exp1']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Certifications & Licenses</label>
                            <textarea name="exp2" rows="4" id="coursedescription"><?php echo htmlspecialchars($bio['exp2']); ?></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
												<input class="btn-primary" type="submit" name="submit" value="Save Biography" />
                        <input type="hidden" name="chpbio" value="1">
                        <button type="button" class="btn-prev" data-tab="picture-tab">
                            <i class="fas fa-chevron-left"></i> Back
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<style>
/* Base Styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.profile-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e0e0e0;
}

.profile-header h2 {
    color: #2c3e50;
    margin: 0;
    font-weight: 600;
}

.profile-image-container {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #81d789;
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.message {
    background-color: #e9f7ec;
    color: #2e7d32;
    padding: 12px 20px;
    border-radius: 4px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.message i {
    font-size: 18px;
}

/* Tabs System */
.tabs-system {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.tabs-nav {
    background: #f8f9fa;
    border-bottom: 1px solid #e0e0e0;
}

.tabs-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
}

.tabs-nav li {
    margin: 0;
}

.tabs-nav a {
    display: block;
    padding: 15px 25px;
    text-decoration: none;
    color: #555;
    font-weight: 500;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}

.tabs-nav li.active a {
    color: #81d789;
    border-bottom-color: #81d789;
    background-color: #fff;
}

.tabs-nav a:hover {
    color: #81d789;
    background-color: #f1f8f2;
}

.tabs-content {
    padding: 30px;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
}

/* Form Styles */
.form-section {
    margin-bottom: 30px;
}

.form-section h3 {
    color: #2c3e50;
    margin-top: 0;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.form-row {
    display: flex;
    gap: 20px;
}

.form-row .form-group {
    flex: 1;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #555;
}

.form-group input[type="text"],
.form-group input[type="password"],
.form-group input[type="email"],
.form-group textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: inherit;
    font-size: 15px;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #81d789;
    box-shadow: 0 0 0 2px rgba(129, 215, 137, 0.2);
}

.form-group textarea {
    min-height: 120px;
    resize: vertical;
}

.file-upload {
    border: 1px dashed #ddd;
    padding: 20px;
    text-align: center;
    border-radius: 4px;
    background-color: #f9f9f9;
}

.form-notes {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 4px;
    margin-top: 20px;
}

.form-notes h4 {
    margin-top: 0;
    color: #555;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-notes ul {
    margin-bottom: 0;
    padding-left: 20px;
}

/* Buttons */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid #eee;
    margin-top: 30px;
}

.btn-primary {
    background-color: #81d789;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #6bc174;
}

.btn-prev, .btn-next {
    background-color: #f8f9fa;
    color: #555;
    border: 1px solid #ddd;
    padding: 10px 20px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}

.btn-prev:hover, .btn-next:hover {
    background-color: #f1f1f1;
    border-color: #ccc;
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .profile-image-container {
        align-self: center;
    }
    
    .tabs-nav ul {
        flex-direction: column;
    }
    
    .tabs-nav a {
        border-bottom: 1px solid #e0e0e0;
    }
    
    .tabs-nav li.active a {
        border-bottom: 3px solid #81d789;
    }
    
    .form-row {
        flex-direction: column;
        gap: 0;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-prev, .btn-next, .btn-primary {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab navigation
    const tabLinks = document.querySelectorAll('.tabs-nav a');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs
            document.querySelectorAll('.tabs-nav li').forEach(li => li.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            // Add active class to clicked tab
            this.parentElement.classList.add('active');
            const tabId = this.getAttribute('href');
            document.querySelector(tabId).classList.add('active');
        });
    });
    
    // Next/Back button functionality
    document.querySelectorAll('.btn-next, .btn-prev').forEach(button => {
        button.addEventListener('click', function() {
            const targetTabId = this.getAttribute('data-tab');
            
            // Remove active class from all tabs
            document.querySelectorAll('.tabs-nav li').forEach(li => li.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            // Add active class to target tab
            document.querySelector(`.tabs-nav a[href="#${targetTabId}"]`).parentElement.classList.add('active');
            document.querySelector(`#${targetTabId}`).classList.add('active');
            
            // Smooth scroll to top of tabs
            document.querySelector('.tabs-system').scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
</script>

<?php include("includes/footer.php"); ?>




