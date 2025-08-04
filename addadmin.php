<?php
require_once('includes/session.php');
require_once("includes/connection.php");
require_once('includes/functions.php');
confirm_logged_in();
include_once("includes/form_functions.php");
check_supperuser();
?>


<?php
$errors = array();
$searchData = '';
$message = "";
if (array_key_exists('chprofile', $_POST)) {
    $errors = array();
    $errors = "";
    $message = "";
    $studentID = trim(($_POST['studentID']));
   	$firstname = trim(($_POST['firstname']));
    $lastname = trim(($_POST['lastname']));
		$phone = trim(($_POST['phone']));
    $email = trim(($_POST['email']));
    $track = trim(($_POST['track']));
    $bsemester = trim(($_POST['bsemester']));
    $fsemester = trim(($_POST['fsemester']));
    $adstatus = trim(($_POST['adstatus']));
    $aadvisor = trim(($_POST['aadvisor']));
    $seid = trim(($_POST['seid']));
  if($studentID == '') { $errors[] = 'StudentID missing'; }
  if($firstname == '') { $errors[] = 'First name missing'; }
  if($lastname == '') { $errors[] = 'Last name missing'; }
  if($email == '') { $errors[] = 'email is missing'; }
  
    if ( empty($errors) ) {
  		$query = "UPDATE member
                       SET studentID='$studentID', firstname='$firstname', lastname='$lastname', phone='$phone', email='$email', track='$track',bsemester='$bsemester', fsemester='$fsemester',aadvisor='$aadvisor',adstatus='$adstatus'
						           WHERE EID='$seid'";
       $result = mysqli_query($connection,$query);
			if ($result) {
				$message = "The profile was successfully updated.";
			} else {
				$message = "The profile could not be updated.";
				$message .= "<br />" . mysqli_error($connection);
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {  $message = "There were " . count($errors) . " errors in the form.";	}
		}
}
if (array_key_exists('search', $_POST)) {
    //echo $_SESSION['pos_id'];
    //$_SESSION['pos_id']="";
    $errors = array();
    $searchtxt = trim(($_POST['searchtxt']));


    if ($searchtxt == '') {
        $errors[] = 'Enter First name, or Last name, or email, or Student ID in the search field';
    }
    if (empty($errors)) {
        $qry = "SELECT EID, firstname, lastname, username, email,achievements,graduated FROM member WHERE (username LIKE '%$searchtxt%' OR firstname LIKE '%$searchtxt%' OR lastname LIKE '%$searchtxt%' OR email LIKE '%$searchtxt%' OR studentID LIKE '%$searchtxt%') AND (supperuser=1 OR faculty=1)";
        $result = mysqli_query($connection,$qry);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['pos_id'] = $row['EID'];
                }   //if the search found just one record
                else {
                    $_SESSION['pos_id'] = "";
                    $str = "";
                    $str .= "<table><tr><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>Edit</th><th>Delete</th></tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $str .="<tr><td>" . $row['firstname'] . "</td><td>" . $row['lastname'] . "</td><td>" . $row['username'] . "</td><td>" . $row['email'] . "</td><td><a href=addadmin.php?eid=" . $row['EID'] . ">Edit</a></td><td><a href=addadmin.php?deleteeid=" . $row['EID'] . " id='deleteeid'>Delete</a></td></tr>";
                    }
                    $str .="</table>";
                    $searchData = $str;
                }
            } else {
                $message = "Sorry, there is no field with this name.";
            }
        } else {
            die("Query failed");
        }
    }
} else if (isset($_REQUEST['deleteeid']) && $_REQUEST['deleteeid'] != '') {
    //$deleserData = mysql_query("DELETE from member where EID = ".$_REQUEST['deleteeid']);
    header("Location: http://www.emuem.org/em/addadmin.php");
} else {
    $str = "";
    $searchtxt = "";
//$message="";
//$errors="";
//$_SESSION['pos_id']="";
}


if (array_key_exists('adminprofile', $_POST)) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $member_type = $_POST['member_type'];
    $superuser = 0;
    $faculty = 0;
    if($member_type == 0){
        $superuser = 1;
        $faculty = 1;
    }
    else if($member_type == 1){
        $superuser = 0;
        $faculty = 1;
    }
    else if($member_type == 2){
        $superuser = 0;
        $faculty = 0;
    }
    /* if (is_uploaded_file($_FILES['pic']['tmp_name'])) {
      echo "<h1>" . "File ". $_FILES['pic']['name'] ." uploaded successfully." . "</h1>";
      echo "<h2>Displaying contents:</h2>";
      readfile($_FILES['filename']['tmp_name']);
      } */
    $newFileName = '';
    if (isset($_FILES['pic']['tmp_name']) && $_FILES['pic']['tmp_name'] != '') {
        $newFileName = mt_rand(10000, 99999) . $_FILES['pic']['name'];
        move_uploaded_file($_FILES['pic']['tmp_name'], "images/" . $newFileName);
    }

    $sql = "INSERT INTO member (firstname,lastname,email,phone,username,password,imageid,supperuser,faculty) VALUES ('" . $fname . "','" . $lname . "','" . $email . "','" . $phone . "','" . $username . "','" . sha1($password) . "','" . $newFileName . "',1,1)";
    $result1 = mysqli_query($connection,$sql);
    if (!$result1) {
        print_r(mysqli_error($connection));
        exit;
    }
    $user_id = mysqli_insert_id($connection);
}
?> 

<?php include('includes/header.php'); ?>

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Search</a></li>
        <li><a href="#tabs-2">Add Admin</a></li>
    </ul>
    <div id="tabs-2">
        <h3>Add an Admin</h3>
        <div>
            <form name="hofform" method="post" action="" enctype="multipart/form-data">
                <table width="300" border="1" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                        <th width="124">First Name</th>  <td width="168"><input name="fname" type="text" class="textfield" id="name" value="" /></td>
                    </tr>

                    <tr>
                        <th>Last Name</th>      <td><input name="lname" type="text" class="textfield" id="title" value=""/></td>
                    </tr>
                    <tr>
                        <th width="124">Email</th>  <td width="168"><input name="email" type="text" class="textfield" id="certification" value="" required=""/></td>
                    </tr>
                    <tr>
                        <th width="124">Phone</th>  <td width="168"><input name="phone" type="text" class="textfield" id="certification" value=""/></td>
                    </tr>
                    <tr>
                        <th>Username</th>        <td><input name="username" type="text" class="textfield" id="companyname" value="" required=""/></td>
                    </tr>

                    <tr>
                        <th>Password</th>        <td><input name="password" type="password" class="textfield" id="companyname" value="" required=""/></td>
                    </tr>
                    
                    <tr>
                        <th>Member Type</th>        <td><input type="radio" name="member_type" value="0" checked="">&nbsp;&nbsp;Admin&nbsp;&nbsp;<input type="radio" name="member_type" value="1" >&nbsp;&nbsp;Instructor&nbsp;&nbsp;<input type="radio" name="member_type" value="2" >&nbsp;&nbsp;Student&nbsp;&nbsp;</td>
                    </tr>

                    <tr>
                        <th width="200">Upload Picture</th>  <td width="168"><input name="pic" type="file" class="textfield" id="pic" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><input type="submit" name="submit" value="Add" /></td>
                    </tr>
                </table>
                <input type="hidden" name="adminprofile" value="1"/>
            </form>

        </div>
    </div>
    <div id="tabs-1">
        <h3>Search Admins</h3>
        <div>
            <form name="admins" method="post" action="" enctype="multipart/form-data">
                <input name="searchtxt" type="text" class="textfield" id="searchtxt" value="<?php echo $_POST['searchtxt']; ?>"/>
                <input type="submit" name="submit" value="search" /></td>
                <input type="hidden" name="search" value="1"/>
                <?php
                if (isset($searchData) && $searchData != '') {
                    echo $searchData;
                }
                ?>
            </form>
            <?php if (isset($_REQUEST['eid']) && $_REQUEST['eid'] != '') {
                 $row = getmember($_REQUEST['eid']);
                ?>
                <form name="chprofile" action="addadmin.php#tabs-1" method="post">
                    <div align= 'center'> <br/>
                        <table border= "1" cellspacing="0">

                            <tr><td><b>Admin Name :<b/><br/><input name="firstname" type="text" class="textfield" id="firstname" size= "15" value="<?php echo( htmlspecialchars($row['firstname']) ); ?>"/><input name="lastname" type="text" class="textfield" id="lastname" size= "15"value="<?php echo( htmlspecialchars($row['lastname']) ); ?>"/> </td><td><b>Student ID :<b/><br/> <input name="studentID" type="text" class="textfield" id="studentID" size= "30"value="<?php echo( htmlspecialchars($row['studentID']) ); ?>"/></td></tr>
                            <tr><td><b>Cell phone : <b/><br/><input name="phone" type="text" class="textfield" id="phone" size= "30" value="<?php echo( htmlspecialchars($row['phone']) ); ?>"/></td><td><b>Email:<b/><br/> <input name="email" type="text" class="textfield" id="email" size= "30" value="<?php echo( htmlspecialchars($row['email']) ); ?>"/></td></tr>
                            <tr><td><b>Admit Semester :<b/><br/> <input name="bsemester" type="text" class="textfield" id="bsemester" size= "30" value="<?php echo( htmlspecialchars($row['bsemester']) ); ?>"/></td><td><b>Academic Advisor :<b/> <br/><input name="aadvisor" type="text" class="textfield" id="aadvisor" size= "30" value="<?php echo( htmlspecialchars($row['aadvisor']) ); ?>"/></td></tr>
                            <tr><td><b>Admit Status : <b/><br/><input name="adstatus" type="text" class="textfield" id="adstatus" size= "30" value="<?php echo( htmlspecialchars($row['adstatus']) ); ?>"/></td><td><b>Expected Final Semester :<b/> <br/><input name="fsemester" type="text" class="textfield" id="fsemester" size= "30" value="<?php echo( htmlspecialchars($row['fsemester']) ); ?>"/></td></tr>
                            
                            <tr colspan="2"><td colspan="2" align="right"><input type="submit" name="submit" value="Submit" />&nbsp;&nbsp;&nbsp;<input type="button" id="cancel" value="Cancel" /></td></tr>
                        </table><br/>
                        <input type="hidden" name="chprofile" value="1"/>
                        <input type="hidden" name="seid" value="<?php echo $row['EID']; ?>" />
                    </div>
                </form>
            <?php }
            ?>
            
        </div>
    </div>
    <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
    <script>
        $(document).ready(function() {
            $('#deleteeid').click(function() {
                if (!confirm("Are you sure want to delete the member?"))
                    return false;
            });
            $('#cancel').click(function(){
                location.href='addadmin.php';
            })
        });
    </script>
    <?php include('includes/footer.php'); ?>