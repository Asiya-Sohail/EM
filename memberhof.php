<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); ?>
<?php //confirm_logged_in();?>
<?php //check_supperuser();?>

<?php include_once("includes/form_functions.php");
      ?>  
   
<?php include('includes/header.php'); ?>
<style>
    .divs{
        float: left;
        padding: 20px;
        border: 1px solid black;
        text-align: center;
        margin: 15px;
        width: 23%;
        height: 170px;
    }
</style>
<div>
    <h1 style="color: black;text-decoration: underline;">EM Program Certification Hall of Fame</h1>
    <br/><br/>
    <p>The following students have gained professional certification as a(n) <b>EMCF, EMCP, CEM, CEI, CMfgE, CMfgT, CAPM, PMP, and/or CLean</b> as part of their coursework in EM 511, EM 580, EM 609, EM 669, and/or EM 695 in the Engineering Management program. Achieving certification is a significant personal challenge and a great professional accomplishment--it is a professionally-recognized credential, beyond the master's degree. <b>These are our <u>best</u> students and graduates! Way to go!!</b></p>
<p>(If you have achieved certification in one of the areas listed above and are not shown in
our Hall of Fame below, or if your information needs to be updated, please send your pic
and background information to mahmed6@emich.edu so that you can be added to the
list below.)</p>
<div style="padding:10px;border: 1px solid black;margin: 0px 50px 0px 25px;">
    <div>
        Name: <input type="text" name="name" id="name" value="<?php echo $_REQUEST['name']; ?>">&nbsp;&nbsp; Cetification: &nbsp;<input type="text" name="cert" id="cert" value="<?php echo$_REQUEST['cert']; ?>">
    </div>
    <div style="text-align:center;margin-top: 20px;">
        <input type="button" id="search" value="Search">&nbsp;&nbsp;&nbsp;<input type="reset" id="reset" value="Reset">
    </div>
</div>
<!--<div>SEE ALL Search With Name</div> -->
<div style="margin: 10px;width: 100%;">
    <?php 
    $where ='';
        if(isset($_REQUEST['name']) && $_REQUEST['name'] !=''){
            $name =$_REQUEST['name'];
             $where .= " AND name like '%$name%'";
        }
        if(isset($_REQUEST['cert']) && $_REQUEST['cert'] !=''){
            $cert =$_REQUEST['cert'];
             $where .= " AND certification like '%$cert%'";
        }
           
        $sql = "select * from halloffame where 1 ".$where;
        $result = mysqli_query($connection,$sql);
        $cnt = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            /*if($cnt % 3 == 0){
                echo "<div class='divClass'>";
            }*/
            echo "<div class='divs'><div>";
            if($row['image'] == '')
                $pimage = 'images/halloffame/noimage.jpg';
            else
                $pimage = 'images/halloffame/'.$row['image'];
            echo "<img src='$pimage' style='height:100px;width:100px;'></div>";
            echo "<div><b>".$row['name']." ".$row['certification']."</b></div>";
             echo "<div>".$row['title'].", ".$row['companyname']."</div>";
            echo "</div>";
            /*if($cnt !=0 && (($cnt % 3)  == 0)){
                echo "</div>";
            }*/
            $cnt++;
        }
    ?>
    <div style="clear:both;"></div>
</div>
</div>
<script>
$(document).ready(function(){
   $('#search').click(function(){
      var name= $('#name').val();
      var cert = $('#cert').val();
      if(name == '' && cert ==''){
          alert("Please enter certification or name");
      }
      else{
          location.href='memberhof.php?name='+name+'&cert='+cert
      }
   });
   $('#reset').click(function(){
       location.href='memberhof.php';
   })
});

</script>
    
<?php include('includes/footer.php');?>