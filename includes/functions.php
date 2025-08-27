<?php
	// This file is the place to store all basic functions
require("connection.php");

	function mysql_prep( $value ) {
		$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysqli_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysqli_real_escape_string($connection,$value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

	function redirect_to( $location = NULL ) {
		$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
		if ($location != NULL) {
			header("Location: $location");
			exit;
		}
	}

	function confirm_query($result_set) {
		$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
		if (!$result_set) {
			die("Database query failed: " . mysqli_error($connection));
		}
	}
	
	function get_all_subjects($public = true) {
		$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
		global $connection;
		$query = "SELECT * 
				FROM subjects ";
		if ($public) {
			$query .= "WHERE visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection,$query);
		confirm_query($subject_set);
		return $subject_set;
	}
	
	function get_pages_for_subject($subject_id, $public = true) {
		$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
		global $connection;
		$query = "SELECT * 
				FROM pages ";
		$query .= "WHERE subject_id = $subject_id ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection,$query);
		confirm_query($page_set);
		return $page_set;
	}
	
	function get_subject_by_id($subject_id) {
		$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id=" . $subject_id ." ";
		$query .= "LIMIT 1";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if ($subject = mysqli_fetch_assoc($result_set)) {
			return $subject;
		} else {
			return NULL;
		}
	}

	function get_page_by_id($page_id) {
		$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id=" . $page_id ." ";
		$query .= "LIMIT 1";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if ($page = mysqli_fetch_assoc($result_set)) {
			return $page;
		} else {
			return NULL;
		}
	}
	
	function get_default_page($subject_id) {
		$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
		// Get all visible pages
		$page_set = get_pages_for_subject($subject_id, true);
		if ($first_page = mysqli_fetch_assoc($page_set)) {
			return $first_page;
		} else {
			return NULL;
		}
	}
	
	function find_selected_page() {
		$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
		global $sel_subject;
		global $sel_page;
		if (isset($_GET['subj'])) {
			$sel_subject = get_subject_by_id($_GET['subj']);
			$sel_page = get_default_page($sel_subject['id']);
		} elseif (isset($_GET['page'])) {
			$sel_subject = NULL;
			$sel_page = get_page_by_id($_GET['page']);
		} else {
			$sel_subject = NULL;
			$sel_page = NULL;
		}
	}

	function navigation($sel_subject, $sel_page, $public = false) {
		$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
		$output = "<ul class=\"subjects\">";
		$subject_set = get_all_subjects($public);
		while ($subject = mysqli_fetch_assoc($subject_set)) {
			$output .= "<li";
			if ($subject["id"] == $sel_subject['id']) { $output .= " class=\"selected\""; }
			$output .= "><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]) . 
				"\">".$subject["menu_name"]."</a></li>";
			$page_set = get_pages_for_subject($subject["id"], $public);
			$output .= "<ul class=\"pages\">";
			while ($page = mysqli_fetch_assoc($page_set)) {
				$output .= "<li";
				if ($page["id"] == $sel_page['id']) { $output .= " class=\"selected\""; }
				$output .= "><a href=\"content.php?page=" . urlencode($page["id"]) .
					"\">".$page["menu_name"]."</a></li>";
			}
			$output .= "</ul>";
		}
		$output .= "</ul>";
		return $output;
	}

	function public_navigation($sel_subject, $sel_page, $public = true) {
		$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
		$output = "<ul class=\"subjects\">";
		$subject_set = get_all_subjects($public);
		while ($subject = mysqli_fetch_assoc($subject_set)) {
			$output .= "<li";
			if ($subject["id"] == $sel_subject['id']) { $output .= " class=\"selected\""; }
			$output .= "><a href=\"index.php?subj=" . urlencode($subject["id"]) . 
				"\">".$subject["menu_name"]."</a></li>";
			if ($subject["id"] == $sel_subject['id']) {	
				$page_set = get_pages_for_subject($subject["id"], $public);
				$output .= "<ul class=\"pages\">";
				while ($page = mysqli_fetch_assoc($page_set)) {
					$output .= "<li";
					if ($page["id"] == $sel_page['id']) { $output .= " class=\"selected\""; }
					$output .= "><a href=\"index.php?page=" . urlencode($page["id"]) .
						"\">".$page["menu_name"]."</a></li>";
				}
				$output .= "</ul>";
			}
		}
		$output .= "</ul>";
		return $output;
	}

  //generating password
function generatePassword($length=10, $strength=2) {
	$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}

	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}


//make thumbnail picture from uploaded picture of members

function make_thumb($img_name,$filename,$new_w,$new_h)
 {
	 $connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
 	//get image extension.
 	$ext=getExtension($img_name);
 	//creates the new image using the appropriate function from gd library
 	if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext))
 		$src_img=imagecreatefromjpeg($img_name);

  	if(!strcmp("png",$ext))
 		$src_img=imagecreatefrompng($img_name);

 	 	//gets the dimmensions of the image
 	$old_x=imageSX($src_img);
 	$old_y=imageSY($src_img);

 	 // next we will calculate the new dimmensions for the thumbnail image
 	// the next steps will be taken:
 	// 	1. calculate the ratio by dividing the old dimmensions with the new ones
 	//	2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
 	//		and the height will be calculated so the image ratio will not change
 	//	3. otherwise we will use the height ratio for the image
 	// as a result, only one of the dimmensions will be from the fixed ones
 	$ratio1=$old_x/$new_w;
 	$ratio2=$old_y/$new_h;
 	if($ratio1>$ratio2)	{
 		$thumb_w=$new_w;
 		$thumb_h=$old_y/$ratio1;
 	}
 	else	{
 		$thumb_h=$new_h;
 		$thumb_w=$old_x/$ratio2;
 	}

  	// we create a new image with the new dimmensions
 	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);

 	// resize the big image to the new created one
 	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);

 	// output the created image to the file. Now we will have the thumbnail into the file named by $filename
 	if(!strcmp("png",$ext))
 		imagepng($dst_img,$filename);
 	else
 		imagejpeg($dst_img,$filename);

  	//destroys source and destination images.
 	imagedestroy($dst_img);
 	imagedestroy($src_img);
 }

 //get extention of the uploaded image
 function getExtension($str) {
	 $connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
 
 ///////////////////return row of member\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

/*function getmember($eid){
			$q = "select * from member where EID='".$eid."' LIMIT 1";	
			$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');
              $result = mysqli_query($connection,$q);
			  $num_rows = mysqli_num_rows($result);
			  #echo 'this is num of rows'.$num_rows;
              $row = mysqli_fetch_assoc($result);
			  #echo 'this is function'.$q;
			  #echo $row['firstname'];
              return $row;
 }*/

function getmember($eid){
			$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
             $result = mysqli_query($connection,"Select * From member WHERE EID='".$eid."' LIMIT 1");
			 $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
           return $row;
}

  function getgname($gname){
			 $connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
              $result = mysqli_query($connection,"Select * From emcourse WHERE gname='".$gname."' LIMIT 1");
              $row = mysqli_fetch_assoc($result);
              return $row;
 }
 
 
function getmembercourse($gname,$eid){
	$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
 $result = mysqli_query($connection,"SELECT course.year, course.semester,emcourse.cname,emcourse.gname, coursemember.grade,coursemember.certification FROM coursemember, course, emcourse WHERE
         coursemember.CID=course.CID AND emcourse.EMCID=course.EMCID AND coursemember.EID='".$eid."' AND emcourse.gname='".$gname."'");
         $row = mysqli_fetch_assoc($result);
         return $row;
 }
 
 function getbiography($eid){
	 $connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
          $result = mysqli_query($connection,"Select * From biography WHERE EID='$eid' LIMIT 1");
          $bio = mysqli_fetch_assoc($result);
          return $bio;
 }
 
//  function getimage($eid){
// 	 $connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
//               $row= getmember($eid);
//               $imagelink= 'images/thumbs/thumb_'.htmlspecialchars($row['imageid']);
//               return $imagelink;
//  }

function getimage($eid){
	$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
	$row = getmember($eid);
	
	// Debug output
	echo "<!-- DEBUG getimage: EID = " . $eid . " -->";
	echo "<!-- DEBUG getimage: imageid from DB = '" . (isset($row['imageid']) ? $row['imageid'] : 'NULL') . "' -->";
	
	if (empty($row['imageid'])) {
			echo "<!-- DEBUG getimage: No imageid, using default -->";
			return 'images/default-avatar.jpg'; // Make sure this file exists
	}
	
	$clean_imageid = trim($row['imageid']);
	$thumbnail_path = 'images/thumbs/thumb_' . htmlspecialchars($clean_imageid);
	$original_path = 'images/' . htmlspecialchars($clean_imageid);
	
	echo "<!-- DEBUG getimage: Checking thumbnail: " . $thumbnail_path . " -->";
	echo "<!-- DEBUG getimage: Checking original: " . $original_path . " -->";
	
	// Check if thumbnail exists first
	if (file_exists($thumbnail_path)) {
			echo "<!-- DEBUG getimage: Found thumbnail -->";
			return $thumbnail_path;
	} elseif (file_exists($original_path)) {
			echo "<!-- DEBUG getimage: Found original, using that -->";
			return $original_path;
	} else {
			echo "<!-- DEBUG getimage: No files found, using default -->";
			return 'images/default-avatar.png';
	}
}
 
 function getfaculty(){
	 $connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
              $result = mysqli_query($connection,"Select * From member WHERE faculty='1' ");
              $row = mysqli_fetch_assoc($result);
              return $result;
 }
 
 function  dropdownsemester($gname,$eid){
	 $connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
 $ecrow = getmembercourse($gname,$eid);
 $ddsemester="";
 $ddsemester .= "<select name='semester_".$gname."' type='text' class='textfield' id='semester_".$gname."'>";
 $ddsemester .= "<option value=''></option>";
 if($ecrow['semester']== "Fall"){$ddsemester .= "<option value='Fall' selected='selected'>F</option>";}else{ $ddsemester .= "<option value='Fall'>F</option>";}
 if($ecrow['semester']== "Winter"){$ddsemester .= "<option value='Winter' selected='selected'>W</option>";}else{ $ddsemester .= "<option value='Winter'>W</option>";}
 if($ecrow['semester']== "Spring"){$ddsemester .= "<option value='Spring' selected='selected'>Sp</option>";}else{ $ddsemester .= "<option value='Spring'>Sp</option>";}
 if($ecrow['semester']== "Summer"){$ddsemester .= "<option value='Summer' selected='selected'>Su</option>";}else{ $ddsemester .= "<option value='Summer'>Su</option>";}
 $ddsemester .= "</select>";

          $ddsemester.="<select name='year_".$gname."' id='year_".$gname."' type='text' class='textfield'><option value=''></option>";
         for ($y=2008; $y<2027; $y++){
           if ($ecrow['year']==$y){$ddsemester.= "<option value=$y selected='selected'>$y</option>";}else{$ddsemester.= "<option value=$y>$y</option>";}
           }
           $ddsemester.="</select>";
 mysqli_close($connection);
 return $ddsemester;

 }

 function grades($gname,$eid){
	 $connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
     $ecrow = getmembercourse($gname,$eid);
     $grads = "";
     $grads .= "<select name='grade_".$gname."' value='' id='grade_".$gname."' ><option value=''></option>";

     if($ecrow['grade']=='A'){$grads .= "<option value='A' selected='selected'>A</option>";}else{$grads .= "<option value='A'>A</option>";}
     if($ecrow['grade']=='A-'){$grads .= "<option value='A-' selected='selected'>A-</option>";}else{$grads .= "<option value='A-'>A-</option>";}
     if($ecrow['grade']=='B+'){$grads .= "<option value='B+' selected='selected'>B+</option>";}else{$grads .= "<option value='B+'>B+</option>";}
     if($ecrow['grade']=='B'){$grads .= "<option value='B' selected='selected'>B</option>";}else{$grads .= "<option value='B'>B</option>";}
     if($ecrow['grade']=='B-'){$grads .= "<option value='B-' selected='selected'>B-</option>";}else{$grads .= "<option value='B-'>B-</option>";}
     if($ecrow['grade']=='C+'){$grads .= "<option value='C+' selected='selected'>C+</option>";}else{$grads .= "<option value='C+'>C+</option>";}
     if($ecrow['grade']=='C'){$grads .= "<option value='C' selected='selected'>C</option>";}else{$grads .= "<option value='C'>C</option>";}
     if($ecrow['grade']=='C-'){$grads .= "<option value='C-' selected='selected'>C-</option>";}else{$grads .= "<option value='C-'>C-</option>";}
     if($ecrow['grade']=='D+'){$grads .= "<option value='D+' selected='selected'>D+</option>";}else{$grads .= "<option value='D+'>D+</option>";}
     if($ecrow['grade']=='D'){$grads .= "<option value='D' selected='selected'>D</option>";}else{$grads .= "<option value='D'>D</option>";}
     if($ecrow['grade']=='D-'){$grads .= "<option value='D-' selected='selected'>D-</option>";}else{$grads .= "<option value='D-'>D-</option>";}
     if($ecrow['grade']=='E'){$grads .= "<option value='E' selected='selected'>E</option>";}else{$grads .= "<option value='E'>E</option>";}
     $grads .= "</select>";
     
     mysqli_close($connection);
     return $grads;
 }

function getcname($gname,$eid){
	$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
              $ecrow = getmembercourse($gname,$eid);
              $str= "";
              $str .= "<tr><td>";
              $row =getgname($gname);
              $str .= $gname."-".$row['title'];
              $str .= "</td><td>".$row['chrs']."</td><td>";
              $str .= dropdownsemester($gname,$eid);
              //$str .= dropdownyear($gname);
              $str .= " </td><td>";
              $str .= grades($gname,$eid);
              $str .= "</td><td><input name='certification_".$gname."' type='text' class='textfield' id='certification_".$gname."' value='".$ecrow['certification']."' size='10'/></td></tr>";
              mysqli_close($connection);
              return $str;

 }

 ///add core courses in POS
function addcore2($psemester,$pyear,$pgrade,$pcertification,$pgname){
	// echo "IN ADDCORE2";
	$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
          if(!empty($psemester) AND !empty($pyear)){
            # echo "Inside if".$pgname;
                  //checking for existing CID
                  $result = mysqli_query($connection,"SELECT * FROM  course,emcourse WHERE  emcourse.EMCID=course.EMCID AND emcourse.gname= '".$pgname."' AND course.semester='".$psemester."' AND course.year='".$pyear."' LIMIT 1");
                  $row = mysqli_fetch_assoc($result);
                  if (mysqli_num_rows($result)==0){
                     $emrow=getgname($pgname);
                     mysqli_query($connection,"INSERT INTO course (EMCID,year,semester,status) VALUES ('".$emrow['EMCID']."','".$pyear."','".$psemester."','1')");
                     $newCID=mysqli_insert_id($connection);
                    
                    // echo "you insert the new CID";
                  }else{
                     //echo"the year and semester, and EMCID is existing ";
                     $newCID= $row['CID'];
                     //echo  $row['CID'];
                  }
                             ///delete the previouse record in coursemember withthe previous
                           $resulto = mysqli_query($connection,"SELECT * FROM coursemember, course,emcourse WHERE  emcourse.EMCID=course.EMCID AND course.CID=coursemember.CID AND
                                                                                     coursemember.EID='".$_SESSION['pos_id']."' AND  emcourse.gname= '".$pgname."'");
                           $rowo = mysqli_fetch_assoc($resulto);

                           $delresult=mysqli_query($connection,"DELETE FROM coursemember WHERE CID = '".$rowo['CID']."' and EID='".$_SESSION['pos_id']."'");


                  //now I have to check if the student has such a course in his record, if he has it I will update it otherwise I will insert a new row
                  $cmresult = mysqli_query($connection,"SELECT * FROM coursemember WHERE  coursemember.EID='".$_SESSION['pos_id']."' AND  coursemember.CID= '".$newCID."' LIMIT 1");
                  $cmrow = mysqli_fetch_assoc($cmresult);
                  if (mysqli_num_rows($cmresult)==0){
                     mysqli_query($connection,"INSERT INTO coursemember (EID,CID,grade,certification) VALUES ('".$_SESSION['pos_id']."',$newCID,'".$pgrade."','".$pcertification."')");
                     //echo "you insert the new EID, CID combination for this student";
                     //$newECID=mysql_insert_id();
                  }else{
                     $newECID= $cmrow['ECID'];

                     echo "I'm in update section";    echo $newECID;
                     $upresult = mysqli_query($connection,"UPDATE coursemember SET grade='".$pgrade."', certification='".$pcertification."' WHERE
                                               ECID='".$cmrow['ECID']."' AND EID='".$_SESSION['pos_id']."' AND  CID='".$cmrow['CID']."'");
                  }
          }

  mysqli_close($connection);
}

function reportpos($gname,$eid){
	$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
         $ecrow = getmembercourse($gname,$eid);
              $str= "";
              $str .= "<tr><td>";
              $row =getgname($gname);
              $str .= $gname."-".$row['title'];
              $str .= "</td><td>".$row['chrs']."</td><td>";
              $str .= $ecrow['semester'].$ecrow['year'];
              //$str .= dropdownyear($gname);
              $str .= " </td><td>";
              $str .= $ecrow['grade'];
              $str .= "</td><td size='10'>".$ecrow['certification']."</td></tr>";
			  mysqli_close($connection);
              return $str;

}

function dropyear(){
	$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
     $year = date("Y");
     $cyear = date("Y");
     $cont=6;
     $str ="";
     $str.= "Year<br/> <select name=courseyear value='' id='courseyear'><option value=''>-----Select one-----</option>";
     while($year+$cont > $cyear){
        $selected ='';
         if($cyear == $year)
             $selected = "selected";
         $str.= "<option value='$cyear' $selected>$cyear</option>"; 
        $cyear+=1; 

     $str.= "</select>";
     return $str;
}
}


function dropsemester(){
	$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
 $str="";
 $str.= "Semester<select name='coursesemester' type='text' class='textfield' id='coursesemester'><option value=''>-----Select one-----</option>
<option value='Fall'>Fall</option><option value='Winter'>Winter</option><option value='Spring'>Spring</option><option value='Summer'>Summer</option></select>";
 return $str;
}


//************************************************************Team Collaboration**************************************88\\

 function getteam($tid){
	 $connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
              $result = mysqli_query($connection,"Select * From team WHERE TID='".$tid."' LIMIT 1");
              $row = mysqli_fetch_assoc($result);
              return $row;
 }


 
 // returns single result  
function mysql_one_data($query)  
{  
	$connection = mysqli_connect('localhost:3307','root','','emuem001_emuem');	
   $one=mysqli_query($connection,$query);  
   $r=mysqli_fetch_row($one);  
   return($r[0]);  
}  


?>