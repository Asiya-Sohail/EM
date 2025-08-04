<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php //confirm_logged_in();?>

 <?php include('includes/header.php'); ?>
 </br>

 <form action="courseinfo.php" method="post">
 <table>
 <tr>
 <td><b>Select a course number</b></td>
 <td>
     <?php

             
             $result1 = mysqli_query($connection,"SELECT DISTINCT(gname) FROM emcourse order by gname asc");
             echo "<select name=EMCID value=''><option value=''>-----Select one-----</option>";
             while($nt1=mysqli_fetch_assoc($result1)){

                   $result = mysqli_query($connection,"SELECT * FROM emcourse where gname='".$nt1[gname]."' LIMIT 1");
                   while($nt=mysqli_fetch_assoc($result)){echo "<option value=".$nt['EMCID'].">".$nt['gname']."</option>";}
              }
             echo "</select>";
      ?>
  </td>
      <td><input type="submit" name="Display" value="Display" /></td>
  </tr>

<?php
 $emcid = $_POST['EMCID'];

if (!empty($emcid)){
    $result = mysqli_query($connection,"Select * From emcourse WHERE emcourse.EMCID='".$emcid."'");
    $row = mysqli_fetch_assoc($result);
    ///////////////First line - course info\\\\\\\\\\\\\\\\\\\
     echo "<tr><td colspan='3'><h3>".$row['title']."\t(".$row['gname'].")\t </h3></td></tr>";
     ///echo "<tr><td><ul><li><b><a href=glossary.php?emcid=". $emcid .">Glossary</a></b></li><li><b><a href=faq.php?emcid=". $emcid .">Knowledge Management (F.A.Q)</a></b></li><li><b><a href=jobpage.php?emcid=". $emcid .">Jobs</a></b></li></ul></td></tr>";

     $str="";
     $str .="<tr><th colspan='3'><b>Description</b></th></tr>";
     $str .= "<tr><td colspan='3'>".$row['description']."</td></tr>";


     //////////////////////////////// get text books \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    $result1= mysqli_query($connection,"SELECT * FROM textbook WHERE gname = '".$row['gname']."'");
    while($row1 = mysqli_fetch_assoc($result1))
    {

      if($row1['required'] == '1'){
       $required .= "</br>".$row1['txtbook']."</br>";


      }else{
        $recommend .= "</br>".$row1['txtbook']."</br>";

      }
    }

    $str .="<tr><th colspan='3'><b>Required Text Book:</b></th></tr>";
    $str .= "<tr><td colspan='3'>".$required."</td></tr>";


    $str .="<tr><th colspan='3'><b>Recommended Text Book:</b></th></tr>";
    $str .= "<tr><td colspan='3'>".$recommend."</td></tr>";


    //////////////////////////////////end of text book\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

     $str .="<tr><th colspan='3'><b>Level</b></th></tr>";
     $str .= "<tr><td colspan='3'>".$row['level']."</td></tr>";

     $str .="<tr><th colspan='3'><b>Schedule type</b></th></tr>";
     $str .= "<tr><td colspan='3'>".$row['scheduletypes']."</td></tr>";

     $str .="<tr><th colspan='3'><b>Prerequisites</b></td></tr>";
     $str .= "<tr><td colspan='3'>".$row['prerequisites']."</td></tr>";


    $str .="<tr><th colspan='3'><b>Syllabus</b></td></tr>";
   
 $str .="<tr><td colspan='3'><a href=/em/general/syllabus/".$row['gname'].".pdf> Click for Online ".$row['gname']." </a> . This is the general syllabus for this course. For latest syllabus please contact the instructor. For text book refer above.</td></tr>";

 $str .="<tr><td colspan='3'><a href=/em/general/syllabus/".$row['gname']."-L.pdf> Click for face2face ".$row['gname']." </a> . This is the general syllabus for this course. For latest syllabus please contact the instructor. For text book refer above.</td></tr>";

    echo $str;

    }
?>
 </br>
 </br>
 </table>
 </form>
 
 
       <?php//you should use tab otherwise your template doesn't work ?>
       <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
       <?php if (!empty($errors)) { display_errors($errors); }?>

<?php include('includes/footer.php'); ?>