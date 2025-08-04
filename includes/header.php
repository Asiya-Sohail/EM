<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Online Master of Engineering Management at EMU</title>
<link rel="shortcut icon" href="style/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/styles.css" type="text/css" />

 <!--rssfeed related scripts-->
<link href="style/rss/jquery.zrssfeed.css" rel="stylesheet" type="text/css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
  <script src="style/rss/jquery.zrssfeed.min.js" type="text/javascript"></script>
   <script src="style/rss/jquery.vticker.js" type="text/javascript"></script>


  <!--jquery related scripts-->
<link rel="stylesheet" href="style/jquery/css/cupertino/jquery-ui-1.8.9.custom.css" type="text/css" />
  <!--<script src="style/jquery/js/jquery-1.4.4.min.js"></script>-->
	<script src="style/jquery/js/jquery-ui-1.8.9.custom.min.js"></script>
	<script src="style/jquery/js/pagination.js"></script>
	  <script>
  	$(function() {
		$( "#tabs" ).tabs();

    //var $tabs = $('#tabs').tabs();
    //var $selected = $tabs.tabs('option', 'selected');
    //alert($selected);

   // $tabs.tabs('select', 2);

  	});

	</script>
	


</head>
<body>
<a name="top"></a>

<div id="container">
<img align="middle" width="50%" src="style/images/EMUEM-logo1.jpg" />

<div id="container-inner">

      <div id="nav">
    	<ul>
        	<li><a href="index.php">Home</a></li>
            <li><a href="member.php">Students</a>
             <ul>
                    <li><a href="member.php">My page</a></li>
                    <li><a href="myprofile.php">Edit profile</a></li>
					<li><a href="submit-pos.php">Submit POS</a></li>
					<li><a href="addfaq.php">Add FAQ</a></li>
					<li><a href="meetothers.php">Meet others</a></li>
                    <li><a href="survey.php">Survey </a></li>
                    <li><a href='http://idea.emuem.org/login.php' target='_blank'>My Ideas</a></li>
                </ul>
            </li>
            <li><a href="gnrlinfo.php">Public</a>
                <ul>
                    <li><a href="gnrlinfo.php">General</a></li>
                    <li><a href="aplyinfo.php">Apply</a></li>
                    <li><a href="trackinfo.php">Tracks</a></li>
                    <li><a href="courseinfo.php">Courses</a></li>
                    <li><a href="memberhof.php">Hall of Fame</a></li>
                </ul>
            </li><!--edn of the public menue-->


            <li><a href="faculty.php">Faculty</a></li>
            <li><a href="general/introduction.pdf">Help</a>
                   <ul>
                   <li><a href="general/introduction.pdf" target="_BLANK">Introduction</a></li>
                   <li><a href="contactinfo.php">Contact</a></li>
				   <li><a href="generalfaq.php">FAQs</a></li>
				   
                   </ul>
            </li><!--edn of the Help menue-->
            
            <li><a href="memberevaluation.php">Team</a>
                   <ul>
                   <li><a href="memberevaluation.php">Evaluation</a></li>
                   
                   <?php
						$str="";
						if(isset($_SESSION['user_id']) and ruadmin()==1)
						{
							   $str .= "<li><a href='addteam.php'>Create-team</a></li>";
							   $str .= "<li><a href='addstudents.php'>Add-Students</a></li>";
							   $str .= "<li><a href='teamrating.php'>Team Rating</a></li>";
							echo  $str;
							}
					?>
                   
                   
                   
                   </ul>
            </li>



            <li><?php
            $str="";
            if((isset($_SESSION['user_id']) and ruadmin()==1) || $_SESSION['user_id'] == 510)
            {
                   $str= "<a href=courseactivation.php>Admin</a>";
                   $str .= "<ul>";
                   $str .= "<li><a href=courseactivation.php>Activation</a></li>";
                   $str .= "<li><a href=approvefaq.php>Approve FAQ</a></li>";
                   $str .= "<li><a href=uploadcsv.php>Upload CSV</a></li>";
                   $str .= "<li><a href=pos.php>POS-Admin</a></li>";
				   $str .= "<li><a href=approvepos.php>Approve POS</a></li>";
				   $str .= "<li><a href=studentlist.php>Forecasting</a></li>";
				   $str .= "<li><a href=halloffame.php>Hall of Fame</a></li>";
				   $str .= "<li><a href='addadmin.php'>Add-Admin</a></li>";
				   $str .= "<li><a href='http://idea.emuem.org' target='_blank'>Idea Site</a></li>";
                   $str .= "</ul>";
                echo  $str;
                }

            ?>
            </li>
                        <!--edn of the Admin menue-->
            <li><?php if(isset($_SESSION['user_id'])){echo"<a href=logout.php> logout</a>";} else{echo"<a href=login.php>  login</a>";}?></li>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
            <li><a href=http://www.youtube.com/user/emuemonline target="_BLANK"><img src="style/images/youtube.jpg" /></li></a>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
            <li><a href=http://www.ustream.tv/user/emuem target="_BLANK"><img src="style/images/ustream.jpg" /></li></a>
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Follow us on</li>
             <li><a href=https://www.facebook.com/emuemonline?ref=tn_tnmn"_BLANK"><img src="style/images/facebook.jpeg" alt="ActivePresenter" width="25px" height="25px"/> </li></a>
        </ul>
    </div><!-- end nav -->


    <div id="main">
		<div id="content">