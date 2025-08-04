<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/form_functions.php"); ?>
<?php confirm_logged_in(); 
//I need to check the address bar to make sure that nobody manualy wants to get to the other teams' section
?>
	
	

<?php //****Form processing section****\\
	if (array_key_exists('subtest', $_POST)) {//********************adding an idea to idea table*************************\\
		$errors = array();
		$eid = $_SESSION['user_id'];
		$query = mysql_query("Select * From question");
		$num_question = mysql_num_rows($query);
		
		$Delete= mysql_query("DELETE From answer WHERE EID='{$eid}'");
		
		
		for($i = 1; $i <= $num_question; $i++)
		{
			$q[$i]= trim(($_POST[$i]));
			if(!empty($q[$i])){
						$query = "INSERT INTO answer (
							EID,QID,answer
						) VALUES (
							'{$eid}','{$i}','{$q[$i]}'
						)";
						$result = mysql_query($query, $connection);			
			}	
		}
		//****************Errors****************\\
		
		//*****************Action******************\\
		/*if ( empty($errors) ) {
			$query = "INSERT INTO answer (
							EID,QID,answer
						) VALUES (
							'{$eid}','{$i}','{$q[$i]}'
						)";
			$result = mysql_query($query, $connection);
			if ($result) {
				$message = "You successfully add an idea.";
			} else {
				$message = "You cannot add your idea to the selected team.";
				$message .= "<br />" . mysql_error();
			}
		}*/
	}
?>



<!--**************************Form starts from here**********************************-->
<?php include("includes/header.php"); ?>

    <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
	<?php if (!empty($errors)) { display_errors($errors); } ?>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Test</a></li>
		<li><a href="#tabs-2">Answer</a></li>
	</ul>
	
	
	<div id="tabs-1"> <!--/////******************start of the tab-1 Generate idea info **********************\\\\\\-->
	 	
		<form name="test" method="post" action="test.php#tabs-1">
			<h3> Please answer the following questions </h3><br/><br/>
			
			<p>	Directions: Please answer the following questions as carefully, honestly, and quickly as possible. Important thing to note here is that there are no right answers, only your best answers. For every question just select one only.</p>
			<?php  //getting the list of the questions
				$eid=$_SESSION['user_id'];
				$str="";
				$num=0;
				$tmresult = mysql_query("Select * From question");
				$str .="<table border='1' cellspacing='0'>";
				while ($tmrow = mysql_fetch_assoc($tmresult)) {
					$num +=1;
					$str .= "<tr><th align='left' colspan='2'>".$num."-".$tmrow['question']."</th></tr>";
					$str .= "<tr><td align='left'> <input type='radio' name='".$tmrow['QID']."' value='1' /> A-".$tmrow['ans1']."</td><td align='left'><input type='radio' name='".$tmrow['QID']."' value='2' /> B-".$tmrow['ans2']."</td></tr>";
				}
				$str .= "<tr><td align='center' colspan='2'><input type='submit' name='submit' value='Submit your answers' /></td></tr></table>";
				echo $str;
			?>
			<input type="hidden" name="subtest" value="1"/>
		</form>
	</div> <!--///////////////////////////////////////End of the tab-1 test tab\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->



	
	
	<div id="tabs-2"><!--/////******************start of the tab-2 Rate ideas************************\\\\\\-->
		<!-- we have to see the list of unrated ideas and also one of them in the rating chart to rate -->
		<h3> Your score sheet </h3>
		<?php
			$eid = $_SESSION['user_id'];
			$ans=array();
			$ansquery = mysql_query("Select * From answer WHERE EID='{$eid}'");
			while ($ansrow = mysql_fetch_array($ansquery)) {
				$a=$ansrow['QID'];
				$ans[$a]=$ansrow['answer'];
			}
			
			$num=mysql_num_rows($ansquery);
			$interavert=0;
			$extrovert=0;
			$sensate=0;
			$intuitive=0;
			$feeler=0;
			$thinker=0;
			$judger=0;
			$perceiver=0;
			
			for($i = 1;$i <= $num; $i+=4){
						if ($ans[$i]==1){$extrovert +=1;}else{$interavert +=1;}
						if ($i<=52){
						if ($ans[$i+1]==1){$sensate +=1;}else{$intuitive  +=1;}						
						if ($ans[$i+2]==1){$feeler +=1;}else{$thinker  +=1;}
						if ($ans[$i+3]==1){$judger +=1;}else{$perceiver  +=1;}
						}
			}

			//All of the results together.
			$str  = "<table><tr><th>Extrovert (E)</th><th>Introvert (I)</th><th>Sensate (S)</th><th>Intuitive (N)</th><th>Feeler (F)</th><th>Thinker (T)</th><th>Judger (J)</th><th>Perceiver (P)</th></tr>";
			$str .= "<tr><td>".$extrovert."</td><td>".$interavert."</td><td>".$sensate."</td><td>".$intuitive."</td><td>".$feeler."</td><td>".$thinker."</td><td>".$judger."</td><td>".$perceiver."</td></tr></table>";
			echo $str; 
			//*****Results*******\\
			$result="<br/>";
			if($extrovert<$interavert){$result.="Interavert---";}else{$result.="Extrovert---";}
			if($sensate<$intuitive){$result.="Intuitive---";}else{$result.="Sensate---";}
			if($feeler<$thinker){$result.="Thinker---";}else{$result.="Feeler---";}
			if($judger<$perceiver){$result.="Perceiver---";}else{$result.="Judger---";}
			echo "<h4>Your results are:  ".$result."</h4>";
		?>
		
		
	</div><!--//////////////////////////////////////////////////////////////////////End of the tab-2 Rating an idea-->

	
  </div> <!--End of the tabs div -->


<?php include("includes/footer.php"); ?>
