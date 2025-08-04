<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/form_functions.php"); ?>
<?php confirm_logged_in(); 
//I need to check the address bar to make sure that nobody manualy wants to get to the other teams' section
//Adding a clean() function to remove special chars from strings
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}


?>
	
	

<?php //****Form processing section****\\
	if(!empty($_GET["CTID"])){ //****putting the teid in the session for future uses****\\
			$_SESSION['CMTID']=$_GET["CMTID"];
                echo "before trimming" + $CMTID + "<br />";
			$_SESSION['CTID']=$_GET["CTID"];
	}
	//--------------This section is used to handel team evaluation--------------------\\
	if (array_key_exists('ratemember', $_POST)) {
		$errors = array();
			
		$rate1 = trim(($_POST['rate1']));
		$rate2 = trim(($_POST['rate2']));
		$rate3 = trim(($_POST['rate3']));
		$rate4 = trim(($_POST['rate4']));
		$rate5 = trim(($_POST['rate5']));
		$rate6 = trim(($_POST['rate6']));
		$rate7 = trim(($_POST['rate7']));
		$rate8 = trim(($_POST['rate8']));
		$rate9 = trim(($_POST['rate9']));

		$CMTID = trim(($_POST['CMTID']));
        //echo "before cleaning: " . $CMTID . "<br />";
        //echo $CMTID;
        $CMTID = clean ($CMTID);
        //echo "after cleaning: " . $CMTID . "<br />";
        
		$eid = $_SESSION['user_id'];
		
		if(($rate1 == '') OR ($rate2 == '') OR ($rate3 == '')) { $errors[] = 'You have to rate all of the evaluation questions'; }
		if($CMTID == '') { $errors[] = 'The CMTID id is missing'; }
		if ( empty($errors) ) {
			$query = "INSERT INTO peerevaluation (
							CMTID,EID,rate1,rate2,rate3,rate4,rate5,rate6,rate7,rate8,rate9
						) VALUES (
							'$CMTID','$eid', '$rate1','$rate2','$rate3', '$rate4','$rate5','$rate6', '$rate7','$rate8','$rate9'
						)";
			$result = mysqli_query($connection,$query);
			if ($result) {
				$message = "You successfully rate one of your temmate.";
			} else {
				$message = "You cannot rate.";
				$message .= "<br />" . mysqli_error($connection);
			}
		}
	}else{
		$errors="";
		$message="";
		$CMTID="";	
}
?>
<!---------------------------------------------------form--------------------------------------->
<?php include("includes/header.php"); ?>


    <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
	<?php if (!empty($errors)) { display_errors($errors); } ?>
<br/>
<br/>
<h5>You can find your teams in the first tab</h5>
<br/>
<h5>If you haven't complete your peer Evaluation you need to click on the provided link</h5>
<br/>	
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Step1. Select Your teams</a></li>
		<li><a href="#tabs-2">Step2. Rate your teammates</a></li>
		<!--<li><a href="#tabs-3">Your Evaluation report' report</a></li>-->
	</ul>
	
	<div id="tabs-1"> <!------------------tab-1 list of your teams------------------------>	
		 <h3> List of your Teams for different courses </h3><br/><br/>
		<?php  //getting the list of your teams		
			$str="";
			$num=0;
			if (!empty($_SESSION['user_id'])){
				$tmresult = mysqli_query($connection,"Select * From cmteam, courseteam,course,emcourse WHERE cmteam.EID='".$_SESSION['user_id']."' AND cmteam.CTID=courseteam.CTID AND course.CID=courseteam.CID AND emcourse.EMCID=course.EMCID");
				$str .="<table border='1' cellspacing='0'><tr><th>Row</th><th><b>course name</b></th><th><b>Year</b></th><th><b>Semester</b></th><th><b>Team name</b></th></th><th><b>Peer Evaluation</b></th></tr>";
				while ($tmrow = mysqli_fetch_assoc($tmresult)) {
					$num +=1;
					$str .= "<tr><td>".$num."</td><td>".$tmrow['cname']."</td><td>".$tmrow['year']."</td><td>".$tmrow['semester']."</td><td>".$tmrow['ctname']."</td>";
					//check if the member finished peer evaluation for this team
					$num_rows = mysqli_num_rows(mysqli_query($connection,"Select * From peerevaluation,cmteam WHERE peerevaluation.CMTID= cmteam.CMTID AND cmteam.CTID='".$tmrow['CTID']."' AND peerevaluation.EID='".$_SESSION['user_id']."'"));
					//echo $num_rows;
					//echo $tmrow['nummembers'];
					if ($num_rows < $tmrow['nummembers']){
						$str.="<td><a href='memberevaluation.php?CMTID=".$tmrow['CMTID']."&CTID=".$tmrow['CTID']."#tabs-2'>Click here to complete</a></td>";
					}else{$str.= "<td>Complete</td>";}	
					$str.="</tr>";
				}
				$str .= "</table>";
				echo $str;
			}
		?>
	</div> <!--End of the tab-1-->
	<div id="tabs-2"><!--------------------------------Begin of tab-2 ---------------------------------->
		<!-- we have to see the list of unrated ideas and also one of them in the rating chart to rate -->
		<h3> Evaluate the following member in this team<? echo $_SESSION['ctname'];?> </h3>
		<form name="ratemember" method="post" action="memberevaluation.php#tabs-2">
			<?php
			$idea="";
			$iid="";		
			$result = mysqli_query($connection,"Select * From cmteam	WHERE 	CTID= '".$_SESSION['CTID']."'
					");	
					
			While($row = mysql_fetch_assoc($result)){
				//check for the unevaluated members
			$search= mysqli_query($connection,"Select * FROM peerevaluation WHERE EID='".$_SESSION['user_id']."' AND CMTID='".$row['CMTID']."'");
				if($search) {
					if(mysqli_num_rows($search) <= 0) {
						$CMTID=$row['CMTID'];
						$EID=$row['EID'];
						
						$member = getmember($row['EID']);
					}
				}
			}
			//pass the EID to the submission form for recording the evaluation to the peerevaluation
			if(empty($member['lastname'])){$done="You have successfully evaluate all of your teammates.";}
			echo "<table border='3'><tr><th>".$member['firstname'].$member['lastname'].$done." <input type='hidden' name='CMTID' id='CMTID' value=".$CMTID."/></th></tr></table><br/>";
			?>
            
            
			<table width="300" border="1" cellspacing="0">
				<tr><th>1. Rate your teammate on the effort she/he put into researching and gathering background information for the design</th></tr>
                <tr><td><input type="radio" name="rate1" value="1" /> Did not collect any information that relates to the project <br/>
                		<input type="radio" name="rate1" value="2" /> Collected very little information that related to the project <br/>
                        <input type="radio" name="rate1" value="3" /> Collected a reasonable amount of information and most of it related to the project <br/>
                        <input type="radio" name="rate1" value="4" /> Collected a great deal of information and all if it related to the project <br/>           
                </td></tr>
                <tr><th>2.Rate your teammate on how well she/he shares information with the group</th></tr>
                <tr><td><input type="radio" name="rate2" value="1" /> Did not relay any information to other teammates <br/>
                		<input type="radio" name="rate2" value="2" /> Relayed very little information that related to the project to other teammates<br/>
                        <input type="radio" name="rate2" value="3" /> Relayed some information and most of it re lated to the project <br/>
                        <input type="radio" name="rate2" value="4" /> Relayed a great deal of information and all of it related to the project <br/>           
                </td></tr>
                <tr><th>3.Rate your teammate on how punctual she/he was in completing and turning in project assignment</th></tr>
                <tr><td><input type="radio" name="rate3" value="1" /> Did not complete team assignments <br/>
                		<input type="radio" name="rate3" value="2" /> Completed few assignments on time other assignments completed late or not completed<br/>
                        <input type="radio" name="rate3" value="3" /> Completed most of the team assignments on time <br/>
                        <input type="radio" name="rate3" value="4" /> Completed all of the team assignments on time <br/>           
                </td></tr>
                <tr><th>4.Rate your teammate on how well he/she performed their duties relating to their role in the group</th></tr>
                <tr><td><input type="radio" name="rate4" value="1" /> Did not perform any of the duties of the assigned team role <br/>
                		<input type="radio" name="rate4" value="2" /> Performed very few duties<br/>
                        <input type="radio" name="rate4" value="3" /> Performed nearly all duties <br/>
                        <input type="radio" name="rate4" value="4" /> Performed all duties of assigned team role <br/>           
                </td></tr>
                <tr><th>5. Rate your teammate on how well he/she shared the work load</th></tr>
                <tr><td><input type="radio" name="rate5" value="1" /> Always relied on others to do the work <br/>
                		<input type="radio" name="rate5" value="2" /> Rarely did the assigned work – often needed reminding<br/>
                        <input type="radio" name="rate5" value="3" /> Usually did the assigned work – rarely needed reminding <br/>
                        <input type="radio" name="rate5" value="4" /> Always did the assigned work without having to be reminde<br/>           
                </td></tr>
                <tr><th>6. Rate your teammate on how well he/she attended meetings</th></tr>
                <tr><td><input type="radio" name="rate6" value="1" /> Missed most group meetings.  Did not inform other group members they would be absent <br/>
                		<input type="radio" name="rate6" value="2" /> Frequently missed group meetings and seldom informed others they would be absent<br/>
                        <input type="radio" name="rate6" value="3" /> Attended most meetings and informed others when he/she could not attend <br/>
                        <input type="radio" name="rate6" value="4" /> Attended all group meeting<br/>           
                </td></tr>
                <tr><th>7. Rate the team member on how well she/he listened to others in the group</th></tr>
                <tr><td><input type="radio" name="rate7" value="1" /> Was  always talking – never allowed anyone else to speak <br/>
                		<input type="radio" name="rate7" value="2" /> Usually did most of the talking – rarely allowed others to speak<br/>
                        <input type="radio" name="rate7" value="3" /> Listened, but occasionally talked too much <br/>
                        <input type="radio" name="rate7" value="4" /> Listened well and spoke without dominating the conservation<br/>           
                </td></tr>
                <tr><th>8. Rate the team member on how well he/she cooperates with others in the group</th></tr>
                <tr><td><input type="radio" name="rate8" value="1" /> Usually argued with teammates <br/>
                		<input type="radio" name="rate8" value="2" /> Sometimes argued<br/>
                        <input type="radio" name="rate8" value="3" /> Rarely argued with other team members <br/>
                        <input type="radio" name="rate8" value="4" /> Never argued with teammates<br/>           
                </td></tr>
                <tr><th>9. Rate your team member on how well she/he made fair decisions</th></tr>
                <tr><td><input type="radio" name="rate9" value="1" /> Usually wanted to have things their way <br/>
                		<input type="radio" name="rate9" value="2" /> Often sided with friends instead of considering all views<br/>
                        <input type="radio" name="rate9" value="3" /> Usually considered all views<br/>
                        <input type="radio" name="rate9" value="4" /> Always helped the team to reach a fair decision<br/>           
                </td></tr>
                <tr><td colspan="3" align="center"><input type="submit" name="submit" value="Submit your rating" /></td></tr>
			</table>
			<input type="hidden" name="ratemember" value="1"/>
		</form><br/><br/><br/>
    
	</div><!--//////////////////////////////////////////////////////////////////////End of the tab-2 Rating an idea-->




  <div id="tabs-3"><!--//*****************************************start of the tab-3 your ideas' report****************************************************-->

	
  
		<!--<h3> Your Ideas' report </h3><br/><br/>-->
		<?php  //getting the list of your idea based
			$teid=$_SESSION['teammember_id'];		
			$str="";
			$num=0;
			if (!empty($teid)){
				$tmresult = mysqli_query($connection,"Select * From idea WHERE TEID='".$_SESSION['teammember_id']."'");
				$str .="<table class='sortable' border='1' cellspacing='0'><tr><td><u>Row</u></td><th><b><u>your ideas</b></u></th><td><u>Mean</u></td><th><u>Median</u></th><td><u>Standard Deviation</u></td><th><u>Max</u></th><td><u>Min</u></td></tr>";
				$mean=0;
				while ($tmrow = mysqli_fetch_assoc($tmresult)) {
					$num +=1;			
					//$math=mysql_query("Select ROUND(((AVG(rateq1)+ AVG(rateq2)+AVG(rateq3))/3),2) AS mean, STD(rateq1) AS STDD ,MAX(greatest(rateq1,rateq2,rateq3)) AS maxx,MIN(Least(rateq1,rateq2,rateq3)) AS minn From ratingidea WHERE IID='{$tmrow['IID']}'");
					//$math_row = mysql_fetch_array($math);
					
					//to calculate the STD and Median
						$sql=mysqli_query($connection,"Select rateq1,rateq2,rateq3 From ratingidea WHERE IID='".$tmrow['IID']."'");
						$rate=array();
						while ($row = mysqli_fetch_assoc($sql)) {
						$rate[]=$row['rateq1'];
						$rate[]=$row['rateq2'];
						$rate[]=$row['rateq3'];
						sort($rate);					
						}
						$str .= "<tr><td>".$num."</td><th>".$tmrow['idea']."</th><td>".ROUND(mean($rate),2)."</td><th>".median($rate)."</th><td>".ROUND(sd($rate),3)."</td><th>".max($rate)."</th><td>".min($rate)."</td></tr>";
				}
				$str .= "</table>";
				//find out how many ideas left to submit\\
				//$tresult= mysql_query("Select * From team,teammember WHERE teammember.TEID='{$teid}' AND team.TID=teammember.TID");
				//$trow = mysql_fetch_array($tresult);
				//$numleft=$trow['maxidea']-$num;
				//echo" you have submited    <b>".$num."</b>   number of idea and you need to submit <b>  ".$numleft."   </b>more ideas<br/>";
				echo $str;

			}
		?>

  </div><!----End of the tab-3 ----------------------------------->

  </div> <!--End of the tabs div -->


<?php include("includes/footer.php"); ?>
