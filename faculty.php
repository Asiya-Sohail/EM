<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php //confirm_logged_in();?>

<?php include("includes/header.php");?>
<?php
     //will connect to member to retrieve username and other informatin for greating and picture   getmember is a function to get this information
     $str ="";
     //$eid=$_SESSION['user_id'];
     //$result = getfaculty();
     $result = mysqli_query($connection,"Select * From member  WHERE faculty = 1 ORDER BY lastname");
     $str = '<table>';
     while ($row = mysqli_fetch_array($result)) {
      // echo data

      $str .= '<tr><th rowspan="2" align="center"><img width="100px" height="100px" src="images/thumbs/thumb_'.htmlspecialchars($row['imageid']).'"></th><th width="70%"><h3>'. $row['firstname'].'-'. $row['lastname'].'</h3</th></tr>';
      //$str .= '<tr><td width="50%"><h3>'. $row['firstname'].'-'. $row['lastname'].'</h3</td></tr>'
       $str .= '<tr><th width="70%">' .$row['email']. '</th></tr>';
      $str .= '<tr><td colspan="2">' .htmlspecialchars($row['research']). '</td></tr>';

      } // end while
      $str .= '</table>';
     echo $str;
?>


    	<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>







<?php include("includes/footer.php");?>
