<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php check_supperuser();?>


<?php
     include_once("includes/form_functions.php");

//in this page we have three different form with three hidden file to keep track of which form is posted

//////////////////////*********************************Add Team***********************************\\\\\\\\\\\\\\\\\\\\\\\\\\
if (array_key_exists('addteam', $_POST)) {
//echo "you are trying to change profile";

    $errors = array();

    $tname = trim(($_POST['tname']));
   	$description = trim(($_POST['description']));
    $code = trim(($_POST['code']));
    $maxidea = trim(($_POST['maxidea']));	
	$q1 = trim(($_POST['q1']));
    $min1 = trim(($_POST['min1']));
	$max1 = trim(($_POST['max1']));
	
	$q2 = trim(($_POST['q2']));
    $min2 = trim(($_POST['min2']));
	$max2 = trim(($_POST['max2']));
	
	$q3 = trim(($_POST['q3']));
    $min3 = trim(($_POST['min3']));
	$max3 = trim(($_POST['max3']));
	
	$startdate= trim(($_POST['startdate']));
	$enddate= trim(($_POST['enddate']));
	//echo $tname,$description,$code,$maxidea,$q1,$min1,$max1,$q2,$min2,$max2,$q3,$min3,$max3;
  
  
  //***************************************************Errors***********************************************\\
  
  if($tname == '') { $errors[] = 'Team name is missing'; }
  if($description == '') { $errors[] = 'Description is missing'; }
  if($code == '') { $errors[] = 'Team code is missing'; }
  if($maxidea == '') { $errors[] = 'Maximum number of idea is missing'; }
  if($q1 == '') { $errors[] = 'First evaluation quesiton is missing'; }
  if($min1 == '') { $errors[] = 'Minimum evaluation criteria for question one is missing'; }
  if($max1 == '') { $errors[] = 'Maximum evaluation criteria for question one is missing'; }
  
  
  	//check for an existing team name, if the team exists the program should give an error
    if($tname != '') {
    $qry = "SELECT * FROM team WHERE tname='$tname'";
		$result = mysqli_query($connection,$qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				$errors[] = 'Team name is already in use, Please chose another Team name';
      }
		}
		else {
			die("Query failed");
		}
	}
	
	  	//check for an Code for team, if the Code exists the program should give an error
    if($tname != '') {
    $qry = "SELECT * FROM team WHERE code='$code'";
		$result = mysqli_query($connection,$qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				$errors[] = 'The code should be unique, the cureent code is been used for another team, Please choose another code';
      }
		}
		else {
			die("Query failed");
		}
	}
  

  //***************************************************************Action**************************************************\\
    
		if ( empty($errors) ) {
			$query = "INSERT INTO team (
							tname,description,code,maxidea,q1, min1, max1,q2,min2,max2,q3,min3,max3,startdate,enddate
						) VALUES (
							'".$tname."','".$description."','".$code."','".$maxidea."','".$q1."', '".$min1."', '".$max1."','".$q2."', '".$min2."', '".$max2."','".$q3."', '".$min3."', '".$max3."','".$startdate."','".$enddate."'
						)";
			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "The user was successfully created.";
			} else {
				$message = "The user could not be created.";
				$message .= "<br />" . mysqli_error($connection);
			}
		}
}
//////////////////////*****************************Editting the team section*****************************\\\\\\\\\\\\\\\\\\\\\\\\\\

if (array_key_exists('editteam', $_POST)) {
//echo "you are trying to change profile";

    $errors = array();

    $tname = trim(($_POST['tname']));
   	$description = trim(($_POST['description']));
    $code = trim(($_POST['code']));
    $maxidea = trim(($_POST['maxidea']));	
	$q1 = trim(($_POST['q1']));
    $min1 = trim(($_POST['min1']));
	$max1 = trim(($_POST['max1']));
	
	$q2 = trim(($_POST['q2']));
    $min2 = trim(($_POST['min2']));
	$max2 = trim(($_POST['max2']));
	
	$q3 = trim(($_POST['q3']));
    $min3 = trim(($_POST['min3']));
	$max3 = trim(($_POST['max3']));
	$startdate= trim(($_POST['startdate']));
	$enddate= trim(($_POST['enddate']));
	//echo $tname,$description,$code,$maxidea,$q1,$min1,$max1,$q2,$min2,$max2,$q3,$min3,$max3;
  
  
  //***************************************************Errors***********************************************\\
  
  if($tname == '') { $errors[] = 'Team name is missing'; }
  if($description == '') { $errors[] = 'Description is missing'; }
  if($code == '') { $errors[] = 'Team code is missing'; }
  if($maxidea == '') { $errors[] = 'Maximum number of idea is missing'; }
  if($q1 == '') { $errors[] = 'First evaluation quesiton is missing'; }
  if($min1 == '') { $errors[] = 'Minimum evaluation criteria for question one is missing'; }
  if($max1 == '') { $errors[] = 'Maximum evaluation criteria for question one is missing'; }
  
  //***************************************Action**************************************************\\
    
		if ( empty($errors) ) {
			$query = "UPDATE team
                       SET tname='".$tname."', description='".$description."', code='".$code."', maxidea='".$maxidea."', q1='".$q1."', min1='".$min1."',max1='".$max1."', q2='".$q2."',min2='".$min2."',max2='".$max2."', q3='".$q3."',min3='".$min3."',max3='".$max3."',startdate='".$startdate."',enddate='".$enddate."'
						           WHERE TID='".$_SESSION['team_id']."'";
			$result = mysql_query($connection,$query);
			if ($result) {
				$message = "The Team was successfully updated.";
			} else {
				$message = "The user could not be created.";
				$message .= "<br />" . mysqli_error($connection);
			}
		}
}




//////////////////////******************fill the editable field team section********************\\\\\\\\\\\\\\\\\\\\\\\\\\

if (array_key_exists('fill', $_POST))  {
	//echo "you are trying to change team";
		$tid = trim(($_POST['tid']));
		//echo $tid;
		if($tid == '') { $errors[] = 'You have to select a team to edit'; }
		
    if ( empty($errors) ){
		$_SESSION['team_id']=$tid;
		
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {  $message = "There were " . count($errors) . " errors in the form.";	}
		}
}

//////////////////////********************Earasing the variables**************************\\\\\\\\\\\\\\\\\\\\\\\\\\
if (!(array_key_exists('addteam', $_POST)) AND !(array_key_exists('editteam', $_POST))AND !(array_key_exists('fill', $_POST))) {
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
		$_SESSION['team_id']="";

}
?>
<?php include("includes/header.php");?>

<!--/////////////////////////////********************form**************************\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\?>-->
	<br/><h3> Team Addition and Edition</h3><br/><br/>

	        <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>

			
						

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Add Team</a></li>
		<li><a href="#tabs-2">Edit Team</a></li>
	</ul>
	
	
	<div id="tabs-1">

		<!--This form is designed to create new teams-->
		<h5> You can create new team with section</h5>
  <form name="addteam" method="post" action="teamadmin.php#tabs-1">
	<table width="300" border="1" align="center" cellpadding="2" cellspacing="0">
		<tr>
			<th width="30%">Team Name</th>  <td width="70%"><input name="tname" type="text" class="textfield" id="tname" /></td>
		</tr>
		<tr>
			<th width="30%">Description</th> <td width="70%"><textarea name="description" cols="50%" rows="5" id="description" />  </textarea></td>
		</tr>
		<tr>
			<th width="30%">Code </th> <td width="70%"><input name="code" type="text" class="textfield" id="code" /></td>
		</tr>
		<tr>
			<th width="30%">Maximum Nember of Ideas to submit </th><td width="70%"><input name="maxidea" type="text" class="textfield" id="maxidea" /></td>
		</tr>
    
		<!--// Evaluation question 1 -->
		<tr>
			<th width="30%">First Evaluation Question</th><td width="70%"><textarea name="q1" cols="50%" rows="1" id="q1" />  </textarea></td>
		</tr>
		<tr>
			<th width="30%">Minimum Criteria </th><td width="70%"><input name="min1" type="text" class="textfield" id="min1" /></td>
		</tr>
		<tr>
			<th width="30%">Maximum Criteria </th><td width="70%"><input name="max1" type="text" class="textfield" id="max1" /></td>
		</tr>
	
		<!--//Evaluation question 2-->
		<tr>
			<th width="30%">Second Evaluation Question</th><td width="70%"><textarea name="q2" cols="50%" rows="1" id="q2" />  </textarea></td>
		</tr>
		<tr>
			<th width="30%">Minimum Criteria </th><td width="70%"><input name="min2" type="text" class="textfield" id="min2" /></td>
		</tr>
		<tr>
			<th width="30%">Maximum Criteria </th><td width="70%"><input name="max2" type="text" class="textfield" id="max2" /></td>
		</tr>
	
		<!--Evaluation quesiton 3-->
		<tr>
			<th width="30%">Third Evaluation Question</th><td width="70%"><textarea name="q3" cols="50%" rows="1" id="q3" />  </textarea></td>
		</tr>
		<tr>
			<th width="30%">Minimum Criteria </th><td width="70%"><input name="min3" type="text" class="textfield" id="min3" /></td>
		</tr>
		<tr>
			<th width="30%">Maximum Criteria </th><td width="70%"><input name="max3" type="text" class="textfield" id="max3" /></td>
		</tr>
	
		<!--//start and end date for team to be activated-->
		<tr>
			<th width="30%">Start Date </th><td width="70%"><input name="startdate" type="text" class="textfield" id="startdate" /></td>
		</tr>
		<tr>
			<th width="30%">End Date</th><td width="70%"><input name="enddate" type="text" class="textfield" id="enddate" /></td>
		</tr>
	
		<tr>
			<td colspan="2" align="right"><input type="submit" name="submit" value="Submit" /></td>
		</tr>
	</table>
	<input type="hidden" name="addteam" value="1"/>
   </form>
	</div>
	     <!--End of the profile change -->
	
	
	
	
	<div id="tabs-2"> <!---------------------This form is designed to Edit and existing teams---------------------------->
		<h2> You can Edit an existing team in this section</h2> <br/>
		
	
	
	
	<form action="teamadmin.php#tabs-2" method="post">
			<table>
				<tr>
					<td><h4> Select a Team Name to edit</h4> </td>
					<td>
	
					<?php
						$result = mysqli_query($connection,"SELECT * FROM  team");
						echo "<select name=tid value=''><option value=''>-----Select one-----</option>";
						while($nt=mysqli_fetch_assoc($result)){echo "<option value=$nt[TID]>$nt[tname]</option>";}
						echo "</select></td>";
					?>
					<td><input type="submit" name="submit" value="Edit" /></td>
				</tr>
			</table>
		<input type="hidden" name="fill" value="1"/>
	</form>
	
	
	
	<?php $row = getteam($_SESSION['team_id']); ?>
	
  <form name="editteam" method="post" action="teamadmin.php#tabs-2">
  <br/>
	<table width="300" border="1" align="center" cellpadding="2" cellspacing="0">
		<tr>
			<th width="30%">Team Name</th>  <td width="70%"><input name="tname" ReadOnly="True" type="text" class="textfield" id="tname" value="<?php echo( htmlspecialchars( $row['tname'] ) ); ?>" /></td>
		</tr>
		<tr>
			<th width="30%">Description</th> <td width="70%"><textarea name="description" cols="50%" rows="5" id="description" /> <?php echo( htmlspecialchars( $row['description'] ) ); ?> </textarea></td>
		</tr>
		<tr>
			<th width="30%">Code </th> <td width="70%"><input name="code" type="text" class="textfield" id="code" value="<?php echo( htmlspecialchars( $row['code'] ) ); ?>"/></td>
		</tr>
		<tr>
			<th width="30%">Maximum Nember of Ideas to submit </th><td width="70%"><input name="maxidea" type="text" class="textfield" id="maxidea" value="<?php echo( htmlspecialchars( $row['maxidea'] ) ); ?>"/></td>
		</tr>
    
		<!--// Evaluation question 1 -->
		<tr>
			<th width="30%">First Evaluation Question</th><td width="70%"><textarea name="q1" cols="50%" rows="1" id="q1" /> <?php echo( htmlspecialchars( $row['q1'] ) ); ?> </textarea></td>
		</tr>
		<tr>
			<th width="30%">Minimum Criteria </th><td width="70%"><input name="min1" type="text" class="textfield" id="min1" value="<?php echo( htmlspecialchars( $row['min1'] ) ); ?>"/></td>
		</tr>
		<tr>
			<th width="30%">Maximum Criteria </th><td width="70%"><input name="max1" type="text" class="textfield" id="max1" value="<?php echo( htmlspecialchars( $row['max1'] ) ); ?>"/></td>
		</tr>
	
		<!--//Evaluation question 2-->
		<tr>
			<th width="30%">Second Evaluation Question</th><td width="70%"><textarea name="q2" cols="50%" rows="1" id="q2" />  <?php echo( htmlspecialchars( $row['q2'] ) ); ?></textarea></td>
		</tr>
		<tr>
			<th width="30%">Minimum Criteria </th><td width="70%"><input name="min2" type="text" class="textfield" id="min2" value="<?php echo( htmlspecialchars( $row['min2'] ) ); ?>"/></td>
		</tr>
		<tr>
			<th width="30%">Maximum Criteria </th><td width="70%"><input name="max2" type="text" class="textfield" id="max2" value="<?php echo( htmlspecialchars( $row['max2'] ) ); ?>"/></td>
		</tr>
	
		<!--Evaluation quesiton 3-->
		<tr>
			<th width="30%">Third Evaluation Question</th><td width="70%"><textarea name="q3" cols="50%" rows="1" id="q3" /> <?php echo( htmlspecialchars( $row['q3'] ) ); ?> </textarea></td>
		</tr>
		<tr>
			<th width="30%">Minimum Criteria </th><td width="70%"><input name="min3" type="text" class="textfield" id="min3" value="<?php echo( htmlspecialchars( $row['min3'] ) ); ?>"/></td>
		</tr>
		<tr>
			<th width="30%">Maximum Criteria </th><td width="70%"><input name="max3" type="text" class="textfield" id="max3" value="<?php echo( htmlspecialchars( $row['max3'] ) ); ?>"/></td>
		</tr>
	
		<!--//start and end date for team to be activated-->
		<tr>
			<th width="30%">Start Date </th><td width="70%"><input name="startdate" type="text" class="textfield" id="startdate" value="<?php echo( htmlspecialchars( $row['startdate'] ) ); ?>"/></td>
		</tr>
		<tr>
			<th width="30%">End Date</th><td width="70%"><input name="enddate" type="text" class="textfield" id="enddate" value="<?php echo( htmlspecialchars( $row['enddate'] ) ); ?>"/></td>
		</tr>
	
		<tr>
			<td colspan="2" align="right"><input type="submit" name="submit" value="Submit" /></td>
		</tr>
	</table>
	<input type="hidden" name="editteam" value="1"/>
   </form>
	</div>
	     <!--End of the Edit Team -->
	
	

</div> <!--End of the tabs div -->


<?php include("includes/footer.php"); ?>




