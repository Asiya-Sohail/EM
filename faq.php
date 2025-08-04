<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();?>

<?php include('includes/header.php'); ?>
      <h3> Knowledge Management, F.A.Q  </h3></br>
<?php

     $emcid = $_GET["emcid"];
     
// database connection info
// find out how many rows are in the table
$sql = "SELECT COUNT(*) FROM faq WHERE EMCID='$emcid' ORDER BY question";

$result = mysqli_query($connection,$sql) or trigger_error("SQL", E_USER_ERROR);
$r = mysqli_fetch_row($result);
$numrows = $r[0];

// number of rows to show per page
$rowsperpage = 10;
// find out total pages
$totalpages = ceil($numrows / $rowsperpage);

// get the current page or set a default
if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
   // cast var as int
   $currentpage = (int) $_GET['currentpage'];
} else {
   // default page num
   $currentpage = 1;
} // end if

// if current page is greater than total pages...
if ($currentpage > $totalpages) {
   // set current page to last page
   $currentpage = $totalpages;
} // end if
// if current page is less than first page...
if ($currentpage < 1) {
   // set current page to first page
   $currentpage = 1;
} // end if

// the offset of the list, based on current page
$offset = ($currentpage - 1) * $rowsperpage;

// get the info from the db
$sql = "SELECT question, answer FROM faq WHERE EMCID='$emcid' ORDER BY question LIMIT $offset, $rowsperpage";
$result = mysqli_query($connection,$sql) or trigger_error("SQL", E_USER_ERROR);

// while there are rows to be fetched...
$str="";
$str.= "<table border='2' align='center' width= 50% padding='2'> <tr><th> Question </th> <th> Answer </th> </tr>";

while ($list = mysqli_fetch_assoc($result)) {
   // echo data
   $str.= "<tr><td>". $list['question'] . "</td><td>" . $list['answer'] . "</td></tr>";
   //echo $list['term'] . " : " . $list['definition'] . "<br />";
} // end while
$str.= "</table>";
echo $str;

/******  build the pagination links ******/
// range of num links to show
$range = 3;

// if not on page 1, don't show back links
if ($currentpage > 1) {
   // show << link to go back to page 1
   echo " <a href='".$_SERVER['PHP_SELF']."?currentpage=1&emcid=$emcid'><<</a> ";
   // get previous page num
   $prevpage = $currentpage - 1;
   // show < link to go back to 1 page
   echo " <a href='".$_SERVER['PHP_SELF']."?currentpage=$prevpage&emcid=$emcid'><</a> ";
} // end if

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
   // if it's a valid page number...
   if (($x > 0) && ($x <= $totalpages)) {
      // if we're on current page...
      if ($x == $currentpage) {
         // 'highlight' it but don't make a link
         echo " [<b>$x</b>] ";
      // if not current page...
      } else {
         // make it a link
         echo " <a href='".$_SERVER['PHP_SELF']."?currentpage=$x&emcid=$emcid'>$x</a> ";
      } // end else
   } // end if
} // end for

// if not on last page, show forward and last page links
if ($currentpage != $totalpages) {
   // get next page
   $nextpage = $currentpage + 1;
    // echo forward link for next page
   echo " <a href='".$_SERVER['PHP_SELF']."?currentpage=$nextpage&emcid=$emcid'>></a> ";
   // echo forward link for lastpage
   echo " <a href='".$_SERVER['PHP_SELF']."?currentpage=$totalpages&emcid=$emcid'>>></a> ";
} // end if
/****** end build pagination links ******/
?>


<?php include('includes/footer.php'); ?>