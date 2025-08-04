<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php confirm_logged_in();?>

 <?php include('includes/header.php'); ?>

</br>
 <h3> Team creation </h3>
</br>
<form action="courseteam.php" method="post">
 <table align='center'>
<tr><td>Team name<br/></td>

 <td>
<?php
     $result = mysqli_query($connection,"SELECT * FROM emcourse order by cname asc");
     echo "Course Name:<br/>   <select name=EMCID value=''><option value=''>-----Select one-----</option>";
      while($nt=mysqli_fetch_assoc($result)){echo "<option value=$nt[EMCID]>$nt[cname]</option>";}
      echo "</select>";
?>
 </td>
 <td>
 <?echo dropyear();?>
</td>
<td>Semester:<br/>  <select name="coursesemester" type="text" class="textfield" id="coursesemester"><option value="">-----Select one-----</option><option value="Fall">Fall</option><option value="Winter">Winter</option><option value="Spring">Spring</option><option value="Summer">Summer</option></select> </td>
</td>
</tr>

<tr><td colspan="4">  <input type="submit" name="submit" value="Submit" /> </td></tr>
</table>
</br>
</br>
</form>

 
 
 
       <?php//you should use tab otherwise your template doesn't work ?>
       <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
       <?php if (!empty($errors)) { display_errors($errors); }?>

<?php include('includes/footer.php'); ?>