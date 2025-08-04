<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>


<?php include_once("includes/form_functions.php");?>


<?/////////////////////////////*********************************************form******************************************\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\?>
<h2 >Find a Match </h2><br/>
 <br/>
 <h3> Search by Name </h3>

<form action="meetothers.php" method="post">
 <input name="searchtxt" type="text" class="textfield" id="searchtxt" />
 <input type="submit" name="submit" value="search" />
 <input type="hidden" name="search" value="1"/>
</form>


<!--******************************************************************search engin ****************************************************-->
<?php

  //$_SESSION['pos_id']="";

	//if (isset($_POST['submit'])) { // Form has been submitted.
if (array_key_exists('search', $_POST)) {
    //echo $_SESSION['pos_id'];
    //$_SESSION['pos_id']="";
		//$errors = array();
    $searchtxt = trim(($_POST['searchtxt']));


    if($searchtxt == '') { $errors[] = 'Enter First name, or Last name, or email, or Student ID in the search field'; }

    if ( empty($errors) ){
    $qry = "SELECT EID, firstname, lastname, username, email FROM member WHERE username LIKE '%$searchtxt%' OR firstname LIKE '%$searchtxt%' OR lastname LIKE '%$searchtxt%' OR email LIKE '%$searchtxt%' OR studentID LIKE '%$searchtxt%'";
		$result = mysqli_query($connection,$qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
       if (mysqli_num_rows($result) == 1){$row = mysqli_fetch_assoc( $result ); $_SESSION['pos_id'] = $row['EID'];}   //if the search found just one record
       else{
       $_SESSION['pos_id']="";
       $str ="";
       $str .= "<table><tr><th>Pic</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Biography</th></tr>";
       while($row = mysqli_fetch_assoc( $result ))
       {
        $str .="<tr><td><img  width= '50px' Height='50px' src=".getimage($row['EID'])."></td><td>".$row['firstname']."</td><td>".$row['lastname']."</td><td>".$row['email']."</td><td><a href=meetothers.php?eid=". $row['EID'] .">Click here</a></td></tr>";
       }
       $str .="</table>";
       echo $str;
       }
      }else {$message = "Sorry, there is no field with this name.";}
		}

		else {
			die("Query failed");
		}
	}
}else{
$str="";
$searchtxt="";
//$message="";
//$errors="";
//$_SESSION['pos_id']="";
}
if (!empty($_GET["eid"])){$bio = getbiography($_GET["eid"]); $row = getmember($_GET["eid"]);

$biostr ="<h3> Meet your Match</h3>";

$biostr .= "<table border= '2' align='left' width= '50%'>";

$biostr .= "<tr><th><b> 1. Name:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $row['firstname'] .$row['lastname'];
$biostr .= "<img  align= 'right' width= '300px' Height='300px' src=".getimage($_GET["eid"])."></td></tr>";


$biostr .= "<tr><th><b> 4. Height, Age and Education:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['exp1'];
$biostr .= "</td></tr>";
$biostr .= "<tr><th><b> 5. Job and Years in the job:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['exp2'];
$biostr .= "</td></tr>";
$biostr .= "<tr><th><b> 6. Nationality:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['undergrad'];
$biostr .= "</td></tr>";
$biostr .= "<tr><th><b> 7. Looking for ______  in their mathch?:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['graduate'];
$biostr .= "</td></tr>";
$biostr .= "<tr><th><b> 4. Work experience:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['exp1'];
$biostr .= "</td></tr>";
$biostr .= "<tr><th><b> 5. any related certifications, professional registrations, and/or licenses that you may have:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['exp2'];

$biostr .= "<tr><th><b> 2. Parent's Name:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['undergrad'];
$biostr .= "</td></tr>";
$biostr .= "<tr><th><b> 3. Parent's Heritage and Number of Siblings:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['graduate'];
$biostr .= "</td></tr>";
$biostr .= "</td></tr>";
$biostr .= "</table>";
echo $biostr;









}

?>





