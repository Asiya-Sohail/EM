<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>


<?php include_once("includes/form_functions.php");?>
<?php include("includes/header.php");?>

<?/////////////////////////////*********************************************form******************************************\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\?>
<h2 >Meet other students at Engineering Mangement Program</h2><br/>
 <br/>
 <h3> Search other Students </h3>

<form action="list.php" method="post">
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
    //$qry = "SELECT EID, firstname, lastname, username, email FROM member WHERE username LIKE '%$searchtxt%' OR firstname LIKE '%$searchtxt%' OR lastname LIKE '%$searchtxt%' OR email LIKE '%$searchtxt%' OR studentID LIKE '%$searchtxt%'";
	//$qry="SELECT * FROM member, coursemember, emcourse, course  WHERE coursemember.EID=member.EID and emcourse.EMCID=course.EMCID and course.CID=coursemember.CID order by member.EID";
	$qry="SELECT * FROM member order by track,lastname";
		$result = mysqli_query($connection,$qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
       if (mysqli_num_rows($result) == 1){$row = mysqli_fetch_assoc( $result ); $_SESSION['pos_id'] = $row['EID'];}   //if the search found just one record
       else{
       $_SESSION['pos_id']="";
       $str ="";
       $str .= "<table><tr><th>Pic</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Track</th>";
	   
	   /*
	   $coqry="SELECT DISTINCT(gname) FROM emcourse order by gname asc";
		$coresult = mysql_query($coqry);
		while($corow = mysql_fetch_array( $coresult )){
			$str .= "<th>".$corow['gname']."</th>";
		}
		*/
	   $str .= "</tr>";
       while($row = mysqli_fetch_assoc( $result ))
       {
	    $track="";
		if ($row['track'] == 1){$track="Design and Manufacturing";} if ($row['track'] == 2){$track="Lean Enterprise System";} if ($row['track'] == 3){$track="Project and Program Management";} if ($row['track'] == 4){$track="Quality Certificate Program";} if ($row['track'] == 5){$track="Research and Development";}
        $str .="<tr><td><img  width= '50px' Height='50px' src=".getimage($row['EID'])."></td><td>".$row['firstname']."</td><td>".$row['lastname']."</td><td>".$row['email']."</td><td>".$track."</td>";
       
		$qry2="SELECT * FROM coursemember, emcourse, course  WHERE coursemember.EID='".$row[EID]."' and coursemember.CID= course.CID and emcourse.EMCID=course.EMCID order by gname asc";
		$result2 = mysqli_query($connection,$qry2);
		while($row2 = mysqli_fetch_assoc( $result2 )){
			
			/*$tqry="SELECT DISTINCT(gname) FROM emcourse order by gname asc";
			$tresult = mysql_query($tqry);
			while($trow = mysql_fetch_array( $tresult )){
				if ($trow['gname']==$row2['gname']){$str .="<td>".$row2['gname']."</td>";} else{$str .="<td></td>";}
			}*/
		$str .="<td>".$row2['gname']."--".$row2['year']."-".$row2['semester']."</td>";	
			
		
		}
	   
	   }
      	
	  $str .="</tr></table>";
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

$biostr ="<h3> Introduction section</h3>";

$biostr .= "<table border= '1' align='center' width= '50%'>";

$biostr .= "<tr><th><b> 1. Name:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $row['firstname'].$row['lastname'];
$biostr .= "<img  align= 'right' width= '50px' Height='50px' src=".getimage($_GET["eid"])."></td></tr>";

$biostr .= "<tr><th><b> 2. Undergrade information:</b></th></tr>";
$biostr .= "<tr><td>";
$biostr  .= $bio['undergrad'];
$biostr .= "</td></tr>";
$biostr .= "<tr><th><b> 3. Graduate information:</b></th></tr>";
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
$biostr .= "</td></tr>";
$biostr .= "</table>";
echo $biostr;









}

?>

<?php include("includes/footer.php"); ?>




