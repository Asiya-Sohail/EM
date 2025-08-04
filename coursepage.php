<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php include("includes/header.php"); ?>

      <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>

<?php  //getting course information
     $emcid = $_GET["emcid"];
     if (!empty($emcid)){
        $result = mysqli_query($connection,"Select * From emcourse, course WHERE emcourse.EMCID='".$emcid."' AND course.EMCID= emcourse.EMCID");
        $row = mysqli_fetch_array($result);

     ///////////////First line - course info\\\\\\\\\\\\\\\\\\\
     echo "<br/><br/><h3> Welcome to :".$row['title']."\t(".$row['cname'].") </h3><br/><br/>";
	 echo "<a href='http://emuem.org/em/member.php'>Back to EM coursese</a>";
     
     //////////GET the RSS FEED linke from the database\\\\\\\\\\\\\
     $rss = $row['rss'];
     ////////getting the faq and glossary code so we can search on faq and glossary table\\\\\\\\\
     $gname= $row['gname'];
     }
?>




<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Course info</a></li>
		<li><a href="#tabs-2">Glossary</a></li>
		<li><a href="#tabs-3">F.A.Q</a></li>
		<li><a href="#tabs-4">JOBS</a></li>
		<li><a href="#tabs-5">Resources</a></li>
	</ul>


	<div id="tabs-1"><!--////////////////////////////////////////////////////////////start of the tab-1 course inof -->
	 	<?php  //getting course information

     $emcid = $_GET["emcid"];
      $str="";
      if (!empty($emcid)){
     $result = mysqli_query($connection,"Select * From emcourse, course WHERE emcourse.EMCID='".$emcid."' AND course.EMCID= emcourse.EMCID");
     $row = mysqli_fetch_assoc($result);

     ///////////////First line - course info\\\\\\\\\\\\\\\\\\\

     $str .="<table table border='1' align='center' cellspacing='0'><tr><th><b>Description</b></th></tr>";
     $str .= "<tr><td>".$row['description']."</td></tr>";

     //////////////////////////////// get text books \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    $result1= mysqli_query($connection,"SELECT * FROM textbook WHERE gname='".$gname."'");
    while($row1 = mysqli_fetch_assoc($result1))
    {

      if($row1['required'] == '1'){
       $required .= "</br>".$row1['txtbook']."</br>";


      }else{
        $recommend .= "</br>".$row1['txtbook']."</br>";

      }
    }

    $str .="<tr><th ><b>Required Text Book:</b></th></tr>";
    $str .= "<tr><td >".$required."</td></tr>";


    $str .="<tr><th ><b>Recommended Text Book:</b></th></tr>";
    $str .= "<tr><td >".$recommend."</td></tr>";
    //////////////////////////////////end of text book\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

     $str .="<tr><th><b>Level</b></th></tr>";
     $str .= "<tr><td>".$row['level']."</td></tr>";

     $str .="<tr><th><b>Schedule type</b></th></tr>";
     $str .= "<tr><td>".$row['scheduletypes']."</td></tr>";

     $str .="<tr><th><b>Prerequisites</b></td></tr>";
     $str .= "<tr><td>".$row['prerequisites']."</td></tr>";
	 
	 $str .="<tr><th><b>Syllabus</b></td></tr>";
     $str .= "<tr><td><a href='/em/general/syllabus/".$row['cname'].".pdf' target='empty' >Click here to download the syllabus</a></td></tr></table>";
	 
	 //<a class="footer1" href="/live/who/">More Contact Information</a>

    echo $str;

    }
?>

	</div><!--//////////////////////////////////////////////////////////////////////End of the tab-1 course inof-->



  <div id="tabs-2"><!--///////////////////////////////////////////////////////////start of the tab-2 Glossary-->
     <?php
     $emcid = $_GET["emcid"];
     $sql = "SELECT term, definition FROM glossary WHERE gname='".$gname."' ORDER BY term";
     $result = mysqli_query($connection,$sql) or trigger_error("SQL", E_USER_ERROR);

     // while there are rows to be fetched...
     $str="";
     $str.= "<table border='1' align='center' width= '50%' cellspacing='0'> <tr><th> Term </th> <th> Definition </th> </tr>";

     while ($list = mysqli_fetch_assoc($result)) {
       // echo data
        $str.= "<tr><td>". $list['term'] . "</td><td>" . $list['definition'] . "</td></tr>";
         //echo $list['term'] . " : " . $list['definition'] . "<br />";
         } // end while
         $str.= "</table>";
         echo $str;

  ?>
	</div><!--//////////////////////////////////////////////////////////////////////End of the tab-2 Glossary-->




  <div id="tabs-3"><!--///////////////////////////////////////////////////////////start of the tab-3 F.A.Q-->
	  

<form action="coursepage.php?<?echo 'emcid='.$emcid;?>#tabs-3" method="post">
 <h3> Search FAQs
 <input name="searchtxt" type="text" class="textfield" id="searchtxt" />
 <input type="submit" name="submit" value="search" />
 <input type="hidden" name="search" value="1"/>
 </h3>
</form>
<br/>
  
  <!--******************************************************************search engin ****************************************************-->
<?php
if (array_key_exists('search', $_POST)) {
    $searchtxt = trim(($_POST['searchtxt']));
    if($searchtxt == '') { $errors[] = 'Enter First name, or Last name, or email, or Student ID in the search field'; }
    if ( empty($errors) ){
    $qry = "SELECT * FROM faq WHERE question LIKE '%$searchtxt%' OR answer LIKE '%$searchtxt%'";
		$result = mysqli_query($connection,$qry);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
       if (mysqli_num_rows($result) == 1){$row = mysqli_fetch_assoc( $result ); $_SESSION['pos_id'] = $row['EID'];}   //if the search found just one record
       else{
       $_SESSION['pos_id']="";
       $str ="";
       $str .= "<br/><h4>Search Results</h4><hr/></hr><br/><br/><table boarder='2'><tr><th>Question</th><th>Answer</th></tr>";
       while($row = mysqli_fetch_assoc( $result ))
       {
        $str .="<tr><td>".$row['question']."</td><td>".$row['answer']."</td></tr>";
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

	echo "<br/><br/><br/><hr/><br/>";
	}else{
$str="";
$searchtxt="";
}

?>
	
	
	
	<?php

	 //echo $gname;
     //$emcid = $_GET["emcid"];
     //$sql = "SELECT question, answer FROM faq WHERE EMCID='".$emcid."' ORDER BY question";
     $sql = "SELECT * FROM faq WHERE gname='".$gname."' AND approved=1 ORDER BY question";
     $result = mysqli_query($connection,$sql) or trigger_error("SQL", E_USER_ERROR);

     // while there are rows to be fetched...
     $str="";
     $str.= "<table border='1' align='center' width= '50%' cellspacing='0'> <tr><th> Question </th> <th> Answer </th> </tr>";

     while ($list = mysqli_fetch_assoc($result)) {
     // echo data
     $str.= "<tr><td>". $list['question'] . "</td><td>" . $list['answer'] . "</td></tr>";
     //echo $list['term'] . " : " . $list['definition'] . "<br />";
     } // end while
     $str.= "</table>";
     echo $str;
   ?>

  </div><!--///////////////////////////////////////////////////////////////////////End of the tab-3 F.A.Q-->

	
  <div id="tabs-4"><!--///////////////////////////////////////////////////////////start of the tab-4 JOBS-->
  
   <script type="text/javascript">
        $(document).ready(function () {
        $('#test').rssfeed('<?echo $rss;?>', {
        limit: 7

	        });
        });
    </script>

        <div id="test"></div>

	</div><!--///////////////////////////////////////////////////////////////////////End of the tab-4 JOBS-->
	
	
	
  <div id="tabs-5"><!--///////////////////////////////////////////////////////////start of the tab-4 Resources|||||||||||||||||||||||||||||||||||||-->
  <p>
  <table border='1' cellspacing="0">
  <tr><th>Journals</th></tr>
  <tr><td>
  <?php
     $sql = "SELECT * FROM resource WHERE gname='".$gname."' AND rtype =1 ORDER BY rname"; //rtype=1 to select journals
     $result = mysqli_query($connection,$sql) or trigger_error("SQL", E_USER_ERROR);
     $str="";
     while ($list = mysql_fetch_assoc($result)) {
     $str.= "<a href=".$list['rlink']." target='_BLANK'>". $list['rname'] . "</a><br/><br/>";
     }
     echo $str;
  ?>
  </td></tr>

  <tr><th>Important Websites</th></tr>
  <tr><td>
  <?php
     $sql = "SELECT * FROM resource WHERE gname='".$gname."' AND rtype =2 ORDER BY rname";  //rtype=2 to select Website
     $result = mysqli_query($connection,$sql) or trigger_error("SQL", E_USER_ERROR);
     $str="";
     while ($list = mysqli_fetch_assoc($result)) {
     $str.= "<a href=".$list['rlink']." target='_BLANK'>". $list['rname'] . "</a><br/><br/>";
     }
     echo $str;
  ?>
  </td></tr>


<tr><th>Software</th></tr>
  <tr><td>
  <?php
     $sql = "SELECT * FROM resource WHERE gname='".$gname."' AND rtype =3 ORDER BY rname";  //rtype=3 to select Software
     $result = mysqli_query($connection,$sql) or trigger_error("SQL", E_USER_ERROR);
     $str="";
     while ($list = mysqli_fetch_assoc($result)) {
     $str.= "<a href=".$list['rlink']." target='_BLANK'>". $list['rname'] . "</a><br/><br/>";
     }
     echo $str;
  ?>
  </td></tr>
  
  </table>
  </p>

	</div><!--///////////////////////////////////////////////////////////////////////End of the tab-4 Resources||||||||||||||||||||||||||||||||||||||-->


  </div> <!--End of the tabs div -->


<?php include("includes/footer.php"); ?>
