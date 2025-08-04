                                   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Engineering Management at EMU</title>
<link rel="shortcut icon" href="style/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/styles.css" type="text/css" />

<link href="style/rss/jquery.zrssfeed.css" rel="stylesheet" type="text/css" />

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
  <script src="style/rss/jquery.zrssfeed.min.js" type="text/javascript"></script>

  <!--jquery related scripts-->
<link rel="stylesheet" href="style/jquery/css/cupertino/jquery-ui-1.8.9.custom.css" type="text/css" />

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



<!--End of the jquery related scripts-->




</head>
<body>
<a name="top"></a>

<div id="container">
<img align="middle" width="100%" src="style/images/banner.jpg" />

<div id="container-inner">

      <div id="nav">
    	<ul>
        	<li><a href="index.php">Home</a></li>
            <li><a href="member.php">Students</a>
             <ul>
                    <li><a href="member.php">My page</a></li>
                    <li><a href="survey.php">Survey </a></li>
                </ul>
            </li>
            <li><a href="gnrlinfo.php">Public</a>
                <ul>
                    <li><a href="gnrlinfo.php">General</a></li>
                    <li><a href="aplyinfo.php">Apply</a></li>
                    <li><a href="trackinfo.php">Tracks</a></li>
                    <li><a href="courseinfo.php">Courses</a></li>
                </ul>
            </li><!--edn of the public menue-->

            <li><a href="courseactivation.php">Admin</a>
                   <ul>
                   <li><a href="courseactivation.php">Activation</a></li>
                   <li><a href="addglossary.php">Add Glossary</a></li>
                   <li><a href="addfaq.php">Add FAQ</a></li>
                   </ul>

            </li><!--edn of the Admin menue-->
            <li><a href="general/introduction.pdf">Help</a>
                   <ul>
                   <li><a href="general/introduction.pdf" target="_BLANK">Introducation</a></li>
                   <li><a href="#">Contact</a></li>
                   </ul>
            </li><!--edn of the Help menue-->

            <li><?php if(isset($_SESSION['user_id'])){echo"<a href=logout.php> logout</a>";} else{echo"<a href=login.php>  login</a>";}?></li>
        </ul>
    </div><!-- end nav -->
    </br></br></br>
 <!-- /////////////////////////End of the header\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->




    <div id="main">
		<div id="content">


        <script type="text/javascript">
        $(document).ready(function () {
        $('#test').rssfeed('http://www.gm-jobs.com/gm.xml', {
        limit: 3
	        });
        });
        </script>

<div id="test"></div>



<?php include("includes/footeronly.php"); ?>




