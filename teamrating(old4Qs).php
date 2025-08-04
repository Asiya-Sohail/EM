<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php
confirm_logged_in();
check_supperuser();
?>


<?php
include_once("includes/form_functions.php");

//////////////////////addteam\\\\\\\\\\\\\\\\\\\\\\\\\\
/* if (array_key_exists('teamrating', $_POST)) {
  $errors = array();
  $ctname = trim(($_POST['ctname']));
  $EMCID = trim(($_POST['EMCID']));
  $courseyear = trim(($_POST['courseyear']));
  $coursesemester = trim(($_POST['coursesemester']));

  //this function is defined in include/function.php
  $CID = mysql_one_data("SELECT CID FROM course WHERE course.EMCID = {$_POST['EMCID']} AND course.year={$_POST['courseyear']} AND course.semester='{$_POST['coursesemester']}'");
  //echo $CID;
  if ($CID == '') {
  $errors[] = 'The selected class is not activated for the selected semester.';
  }

  if ($ctname == '') {
  $errors[] = 'Team name is missing';
  }
  if ($EMCID == '') {
  $errors[] = 'Course name is missing';
  }
  if ($courseyear == '') {
  $errors[] = 'Year is missing';
  }
  if ($coursesemester == '') {
  $errors[] = 'Semester is missing';
  }
  //check for duplicate team name

  if ($ctname != '') {
  $qry = "SELECT * FROM courseteam WHERE ctname='$ctname' AND CID='$CID'";
  $result = mysql_query($qry);
  //echo $result['CID'];
  if ($result) {
  if (mysql_num_rows($result) > 0) {
  $errors[] = 'Team already in use, Please chose another team name';
  mysql_close($connection);
  }
  } else {
  die("Query failed");
  }
  }
  //if there is no error now we can enter the data in courseteam table
  if (empty($errors)) {
  $query = "INSERT INTO courseteam (
  ctname,CID
  ) VALUES (
  '{$ctname}','{$CID}'
  )";
  $result = mysql_query($query, $connection);
  if ($result) {
  $message = "The Team successfully created.";
  } else {
  $message = "The Team could not be created.";
  $message .= "<br />" . mysql_error();
  }
  } else {
  if (count($errors) == 1) {
  $message = "There was 1 error in the form.";
  } else {
  $message = "There were " . count($errors) . " errors in the form.";
  }
  }
  }
  //if($_GET["action"]=='delete'){
  //echo "boo000000000ok";
  //echo $_GET["action"];
  //}else{//echo "NOOOOOOOOOOOO";}
  if (!empty($_GET["CID"]) and ! empty($_GET["CTID"])) {
  $_SESSION['CTID'] = $_GET['CTID'];
  $_SESSION['CID'] = $_GET['CID'];
  }//else {//this still might happen in the first talb} */
?>
<?php include('includes/header.php'); ?>
<!----------------------------------------form-------------------------------------->
<br/></br><h3> Search Team </h3></br>
<form name="addteam" action="teamrating.php#tabs-1" method="post">
    <table align='center'>
        <tr>            
            <td> Course Year: <br><select name="courseyear" value="" id="courseyear"><option value="">-----Select one-----</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015" selected="">2015</option><option value="2016" <?php if(date('Y') == '2016') echo 'seleted'; ?>>2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select></td>
            <td>Semester:<br/>  <select name="coursesemester" type="text" class="textfield" id="coursesemester"><option value="">-----Select one-----</option><option value="Fall">Fall</option><option value="Winter">Winter</option><option value="Spring">Spring</option><option value="Summer">Summer</option></select> </td>
            <td>
                <?php
                $result = mysqli_query($connection,"SELECT * FROM emcourse order by cname asc");
                echo "Course Name:<br/>   <select name=EMCID value='' id='coursename'><option value=''>-----Select one-----</option>";
                while ($nt = mysqli_fetch_assoc($result)) {
                    echo "<option value=".$nt['EMCID'].">".$nt['cname']."</option>";
                }
                echo "</select>";
                ?>
            </td></tr>
        <tr><td colspan="4" align="center">  <input type="submit" name="submit" value="Search Team" /> </td></tr>
    </table>
    </br></br>
    <input type="hidden" name="teamrating" value="1"/>
</form>


<?
if (isset($_REQUEST['teamrating'])) {
//echo $_POST['EMCID'].'-'.$_POST['courseyear'].'-'.$_POST['coursesemester'];

    $str = "";
    $str .="SELECT * FROM course, courseteam WHERE course.EMCID = ".$_REQUEST['EMCID']." AND courseteam.CID = course.CID AND course.year=".$_REQUEST['courseyear']." AND course.semester='".$_REQUEST['coursesemester']."'   ORDER BY courseteam.ctname";
    //$eid = $_SESSION['user_id'];
    $result = mysqli_query($connection,$str);
    $tbstr = "";
    $tbstr .= "<table border= '1' align='center'>";
    $tbstr .= "<tr><th><b>Team Name</b></th></tr>";
    //$tbstr .= "<tr><th><b>Team Name</b></th><th><b>Delete</b></th><th><b>Add Member</b></th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $tbstr .= "<tr><td>";
        $tbstr .= "<a href='teamrating.php?teamrating=1&student=1&EMCID=" . $_REQUEST['EMCID'] . "&courseyear=" . $_REQUEST['courseyear'] . "&coursesemester=" . $_REQUEST['coursesemester'] . "&CTID=" . $row[CTID] . "' style='text-decoration:none'>" . $row[ctname] . "</a>";
        //$tbstr .= "</td><td>";
        // $tbstr .= "<a href='#' style='text-decoration:none'>Delete</a>";
        //$tbstr .= "</td><td>";
        // $tbstr .= "<a href='addstudents.php?CTID=" . $row[CTID] . "&CID=" . $row[CID] . "&EMCID=" . $_POST['EMCID'] . "&courseyear=" . $_POST['courseyear'] . "&coursesemester=" . $_POST['coursesemester'] . "&coursename=" . $row[ctname] . "'>Add Members</a>";
        $tbstr .= "</td></tr>";
    }
    $tbstr .= "</table><br/>";
    echo $tbstr;

    if (isset($_REQUEST['student'])) {
        
        $teamstr ="SELECT * FROM cmteam, member, courseteam WHERE cmteam.CTID = ".$_REQUEST['CTID']." AND member.EID=cmteam.EID AND courseteam.CTID=cmteam.CTID";
        $teamresult = mysqli_fetch_assoc(mysqli_query($connection,$teamstr));
        //print_r($teamresult); 
        echo "Team Name: <b>".$teamresult['ctname']."</b><br/><br/>";
        $cusrseStr = "SELECT * FROM emcourse em join course  cr on cr.EMCID= em.EMCID WHERE cr.CID=".$teamresult['CID'];
        $courseresult = mysqli_fetch_assoc(mysqli_query($connection,$cusrseStr));
        echo "Course Name: <b>".$courseresult['cname']." ".$courseresult['title']."</b><br/><br/>";
        $str = "";
        $str .="SELECT * FROM cmteam, member, courseteam WHERE cmteam.CTID = ".$_REQUEST['CTID']." AND member.EID=cmteam.EID AND courseteam.CTID=cmteam.CTID";
        $result = mysqli_query($connection,$str);
        $tbstr = "";
        $tbstr .= "<table border= '1' align='center'>";
        //$tbstr .= "<tr><th><b>Student Name</b></th><th><b>Team Name</b></th><th><b>Course Code</b></th></tr>";
        $tbstr .= "<tr><th><b>Student Name</b></th></tr>";
        while ($row = mysqli_fetch_array($result)) {

            $tbstr .= "<tr><td>";
            $tbstr .= "<a href='teamrating.php?teamrating=1&student=1&EMCID=" . $_REQUEST['EMCID'] . "&courseyear=" . $_REQUEST['courseyear'] . "&coursesemester=" . $_REQUEST['coursesemester'] . "&CTID=" . $row['CTID'] . "&tid=" . $row['CMTID'] . "&evalution=1' style='text-decoration:none'>" . $row['firstname'] . '-' . $row['lastname'] . '-' . $row['username'] . "<a>";
            //$tbstr .= "</td><td>";
            //$tbstr .= $row[ctname];
            //$tbstr .= "</td><td>";
            //$tbstr .= $row[CID];
            $tbstr .= "</td></tr>";
        }
        $tbstr .= "</table><br/>";
        echo $tbstr;
    }
    if (isset($_REQUEST['evalution'])) {
       $teid = $_REQUEST['tid'];
       $memStr = "SELECT * FROM cmteam em join member mem on mem.EID = em.EID WHERE em.CMTID=".$teid;
        $memresult = mysqli_fetch_assoc(mysqli_query($connection,$memStr));
        //print_r($memresult);
        echo "Member Who is Evaluated: <b>".$memresult['firstname']." ".$memresult['lastname'] ." EID : ".$memresult['username']."</b><br/><br/>";
        //$membereve = getmember($teid);
        //print_r($membereve);
        $strm = "";
        $num = 0;
        if (!empty($teid)) {
            $tmresult = mysql_query("Select * From peerevaluation WHERE CMTID='".$_REQUEST['tid']."' GROUP BY EID ORDER BY PEID DESC ");
            $strm .="<table class='sortable' border='1' cellspacing='0'><tr><th><u>Row</u></th><th><u>Evalutor ID</u></th><th title='Rate your teammate on the effort she/he put into researching and gathering background information for the desig'><u>Rating 1</u></th><th title='Rate your teammate on how well she/he shares information with the group'><u>Rating 2</u></th><th title='Rate your teammate on how punctual she/he was in completing and turning in project assignment'><u>Rating 3</u></th><th title='Rate your teammate on how well he/she performed their duties relating to their role in the group'><u>Rating 4</u></th><th title='Rate your teammate on how well he/she shared the work load'><u>Rating 5</u></th><th title='Rate your teammate on how well he/she attended meetings'><u>Rating 6</u></th><th title='Rate the team member on how well she/he listened to others in the group'><u>Rating 7</u></th><th title='Rate the team member on how well he/she cooperates with others in the group'><u>Rating 8</u></th><th title='Rate your team member on how well she/he made fair decisions'><u>Rating 9</u></th><th><u>Mean</u></th></tr>";
            $meanofmeans = 0;
            $totalmeans = 0;
            $totalRow1 = 0;
            $totalRow2 = 0;
            $totalRow3 = 0;
            $totalRow4 = 0;
            $totalRow5 = 0;
            $totalRow6 = 0;
            $totalRow7 = 0;
            $totalRow8 = 0;
            $totalRow9 = 0;
            $rate = array();
            while ($rowdata = mysql_fetch_assoc($tmresult)) {
                $mean = 0;
                $meanoftotal = 0;
                $totalmean = 0;
                $num +=1;
                $member = getmember($rowdata['EID']);
                //to calculate the STD and Median
                /* $rate[] = $rowdata['rate1'];
                  $rate[] = $rowdata['rate2'];
                  $rate[] = $rowdata['rate3'];
                  $rate[] = $rowdata['rate4'];
                  $rate[] = $rowdata['rate5'];
                  $rate[] = $rowdata['rate6'];
                  $rate[] = $rowdata['rate7'];
                  $rate[] = $rowdata['rate8'];
                  $rate[] = $rowdata['rate9'];
                  sort($rate); */
                if ($rowdata['rate1'] != 0) {
                    $totalRow1 = $totalRow1+$rowdata['rate1'];
                    $meanoftotal = $meanoftotal + 1;
                    $mean = $mean + $rowdata['rate1'];
                }
                if ($rowdata['rate2'] != 0) {
                    $totalRow2 = $totalRow2+$rowdata['rate2'];
                    $meanoftotal = $meanoftotal + 1;
                    $mean = $mean + $rowdata['rate2'];
                }
                if ($rowdata['rate3'] != 0) {
                    $totalRow3 = $totalRow3+$rowdata['rate3'];
                    $meanoftotal = $meanoftotal + 1;
                    $mean = $mean + $rowdata['rate3'];
                }
                if ($rowdata['rate4'] != 0) {
                    $totalRow4 = $totalRow4+$rowdata['rate4'];
                    $meanoftotal = $meanoftotal + 1;
                    $mean = $mean + $rowdata['rate4'];
                }
                if ($rowdata['rate5'] != 0) {
                    $totalRow5 = $totalRow5+$rowdata['rate5'];
                    $meanoftotal = $meanoftotal + 1;
                    $mean = $mean + $rowdata['rate5'];
                }
                if ($rowdata['rate6'] != 0) {
                    $totalRow6 = $totalRow6+$rowdata['rate6'];
                    $meanoftotal = $meanoftotal + 1;
                    $mean = $mean + $rowdata['rate6'];
                }
                if ($rowdata['rate7'] != 0) {
                    $totalRow7 = $totalRow7+$rowdata['rate7'];
                    $meanoftotal = $meanoftotal + 1;
                    $mean = $mean + $rowdata['rate7'];
                }
                if ($rowdata['rate8'] != 0) {
                    $totalRow8 = $totalRow8+$rowdata['rate8'];
                    $meanoftotal = $meanoftotal + 1;
                    $mean = $mean + $rowdata['rate8'];
                }
                if ($rowdata['rate9'] != 0) {
                    $totalRow9 = $totalRow9+$rowdata['rate9'];
                    $meanoftotal = $meanoftotal + 1;
                    $mean = $mean + $rowdata['rate9'];
                }
                //echo $mean." mean  ".$meanoftotal."  ";
                $totalmean = round($mean / $meanoftotal, 2);
                $totalmeans = $totalmeans + $totalmean;
                //$strm .= "<tr><td>".$num."</td><th>".$rowdata['EID']."</th><td>".ROUND(mean($rate),2)."</td><th>".median($rate)."</th><td>".ROUND(sd($rate),3)."</td><th>".max($rate)."</th><td>".min($rate)."</td></tr>";
                //$strm .= "<tr><td>".$num."</td><th>".$tmrow['idea']."</th><td>".ROUND(mean($rate),2)."</td><th>".median($rate)."</th><td>".ROUND(sd($rate),3)."</td><th>".max($rate)."</th><td>".min($rate)."</td></tr>";
                /* $sql=mysql_query("Select rateq1,rateq2,rateq3 From ratingidea WHERE IID='{$tmrow['IID']}'");
                  $rate=array();
                  while ($rowdata = mysql_fetch_assoc($sql)) {
                  $rate[]=$rowdata['rateq1'];
                  $rate[]=$rowdata['rateq2'];
                  $rate[]=$rowdata['rateq3'];
                  sort($rate);
                  } */
                //$strm .= "<tr><td>".$num."</td><td>".$tmrow['idea']."</th><td>".round(($rate),2)."</td></tr>";
                //$strm .= "<tr><td>".$num."</td><th>".$tmrow['idea']."</th><td>".ROUND(mean($rate),2)."</td><th>".median($rate)."</th><td>".ROUND(sd($rate),3)."</td><th>".max($rate)."</th><td>".min($rate)."</td></tr>";
                $strm .= "<tr><td>" . $num . "</td><td>" . $member['firstname'] . " " . $member['lastname'] . "</td><td>" . $rowdata['rate1'] . "</td><td>" . $rowdata['rate2'] . "</td><td>" . $rowdata['rate3'] . "</td><td>" . $rowdata['rate4'] . "</td><td>" . $rowdata['rate5'] . "</td><td>" . $rowdata['rate6'] . "</td><td>" . $rowdata['rate7'] . "</td><td>" . $rowdata['rate8'] . "</td><td>" . $rowdata['rate9'] . "</td><td>" . $totalmean . "</td></tr>";
            }
            $strm .= "<tr><td colspan='2' style='text-align:center;'>Mean</td><td>" . round($totalRow1 / $num, 2) . "</td><td>" .  round($totalRow2 / $num, 2) . "</td><td>" .  round($totalRow3 / $num, 2) . "</td><td>" .  round($totalRow4 / $num, 2) . "</td><td>" .  round($totalRow5 / $num, 2) . "</td><td>" .  round($totalRow6 / $num, 2) . "</td><td>" .  round($totalRow7 / $num, 2) . "</td><td>" .  round($totalRow8 / $num, 2) . "</td><td>" .  round($totalRow9 / $num, 2) . "</td><td>&nbsp;</td></tr>";
            $strm .='<tr><td colspan="12" style="text-align:center;">Total Weighted Score : '.round($totalmeans/$num,2).'</td></tr>';
            $strm .= "</table>";
            echo $strm;
        }
    }
}
?>

<script>
    function setSelectedIndex(s, valsearch) {
// Loop through all the items in drop down list
        for (i = 0; i < s.options.length; i++) {
            if (s.options[i].value == valsearch) {
// Item is found. Set its property and exit
                s.options[i].selected = true;
                break;
            }
        }
        return;
    }
    setSelectedIndex(document.getElementById("coursename"), "<? echo $_POST['EMCID']; ?>");
    if(<?echo $_POST['courseyear']; ?> == '')
    setSelectedIndex(document.getElementById("courseyear"),"<? echo date('Y'); ?>");
else
    setSelectedIndex(document.getElementById("courseyear"),"<?echo $_POST['courseyear']; ?>");
    setSelectedIndex(document.getElementById("coursesemester"), "<? echo $_POST['coursesemester']; ?>");
</script>

<?php //you should use tab otherwise your template doesn't work   ?>
<?php
if (!empty($message)) {
    echo "<p class=\"message\">" . $message . "</p>";
}
?>
<?php
if (!empty($errors)) {
    display_errors($errors);
}
?>

<?php include('includes/footer.php'); ?>