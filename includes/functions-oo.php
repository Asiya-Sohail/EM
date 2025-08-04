<?php
require_once("includes/connection.php");
	// This file is the place to store all basic functions

	function mysql_prep( $value ) {
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
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}

	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . mysql_error());
		}
	}
	
	function get_all_subjects($public = true) {
		global $connection;
		$query = "SELECT * 
				FROM subjects ";
		if ($public) {
			$query .= "WHERE visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$subject_set = mysql_query($query, $connection);
		confirm_query($subject_set);
		return $subject_set;
	}
	
	function get_pages_for_subject($subject_id, $public = true) {
		global $connection;
		$query = "SELECT * 
				FROM pages ";
		$query .= "WHERE subject_id = {$subject_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$page_set = mysql_query($query, $connection);
		confirm_query($page_set);
		return $page_set;
	}
	
	function get_subject_by_id($subject_id) {
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id=" . $subject_id ." ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if ($subject = mysql_fetch_array($result_set)) {
			return $subject;
		} else {
			return NULL;
		}
	}

	function get_page_by_id($page_id) {
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id=" . $page_id ." ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if ($page = mysql_fetch_array($result_set)) {
			return $page;
		} else {
			return NULL;
		}
	}
	
	function get_default_page($subject_id) {
		// Get all visible pages
		$page_set = get_pages_for_subject($subject_id, true);
		if ($first_page = mysql_fetch_array($page_set)) {
			return $first_page;
		} else {
			return NULL;
		}
	}
	
	function find_selected_page() {
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
		$output = "<ul class=\"subjects\">";
		$subject_set = get_all_subjects($public);
		while ($subject = mysql_fetch_array($subject_set)) {
			$output .= "<li";
			if ($subject["id"] == $sel_subject['id']) { $output .= " class=\"selected\""; }
			$output .= "><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]) . 
				"\">{$subject["menu_name"]}</a></li>";
			$page_set = get_pages_for_subject($subject["id"], $public);
			$output .= "<ul class=\"pages\">";
			while ($page = mysql_fetch_array($page_set)) {
				$output .= "<li";
				if ($page["id"] == $sel_page['id']) { $output .= " class=\"selected\""; }
				$output .= "><a href=\"content.php?page=" . urlencode($page["id"]) .
					"\">{$page["menu_name"]}</a></li>";
			}
			$output .= "</ul>";
		}
		$output .= "</ul>";
		return $output;
	}

	function public_navigation($sel_subject, $sel_page, $public = true) {
		$output = "<ul class=\"subjects\">";
		$subject_set = get_all_subjects($public);
		while ($subject = mysql_fetch_array($subject_set)) {
			$output .= "<li";
			if ($subject["id"] == $sel_subject['id']) { $output .= " class=\"selected\""; }
			$output .= "><a href=\"index.php?subj=" . urlencode($subject["id"]) . 
				"\">{$subject["menu_name"]}</a></li>";
			if ($subject["id"] == $sel_subject['id']) {	
				$page_set = get_pages_for_subject($subject["id"], $public);
				$output .= "<ul class=\"pages\">";
				while ($page = mysql_fetch_array($page_set)) {
					$output .= "<li";
					if ($page["id"] == $sel_page['id']) { $output .= " class=\"selected\""; }
					$output .= "><a href=\"index.php?page=" . urlencode($page["id"]) .
						"\">{$page["menu_name"]}</a></li>";
				}
				$output .= "</ul>";
			}
		}
		$output .= "</ul>";
		return $output;
	}

  //generating password
function generatePassword($length=10, $strength=2) {
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
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
 
 ///////////////////return row of member\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 function getmember($eid){
              $result = mysql_query("Select * From member WHERE EID='{$eid}' LIMIT 1");
              $row = mysql_fetch_array($result);
              return $row;
 }
 
 function getgname($gname){
              $result = mysql_query("Select * From emcourse WHERE gname='$gname' LIMIT 1");
              $row = mysql_fetch_array($result);
              return $row;
 }

 function getcoursemember($eid,$cid){
              $result = mysql_query("Select * From coursemember WHERE EID='$eid' AND CID='$cid'");
              $row = mysql_fetch_array($result);
              return $row;
 }
 
 function gettrackcourse($eid){
  $result = mysql_query("SELECT member.EID, member.lastname,course.year, course.semester,emcourse.cname,emcourse.gname, coursemember.grade FROM member,coursemember, course, emcourse WHERE
  member.EID=coursemember.EID AND coursemember.CID=course.CID AND emcourse.EMCID=course.EMCID AND coursemember.EID='{$eid']}'");
  $tcourse=mysql_fetch_array($result);
  return $tcourse;

 }
 
 function getbiography($eid){
          $result = mysql_query("Select * From biography WHERE EID='{$eid}' LIMIT 1");
          $bio = mysql_fetch_array($result);
          return $bio;
 }
 
 function getimage($eid){
              $row= getmember($eid);
              $imagelink= 'images/thumbs/thumb_'.htmlspecialchars($row['imageid']);
              return $imagelink;
 }
 
 function getfaculty(){
              $result = mysql_query("Select * From member WHERE faculty='1' ");
              $row = mysql_fetch_array($result);
              return $result;
 }


 function dropdownyear($gname){

           $ddyear="";
           $ddyear.= "<select name='year_".$gname."' type='text' class='textfield' id='year_".$gname."'>";
           $ddyear.= "<option value=''></option>";
		   $ddyear.= "<option value='2017'>2017</option>";
		   $ddyear.= "<option value='2018'>2018</option>";
		   $ddyear.= "<option value='2019'>2019</option>";
		   $ddyear.= "<option value='2020'>2020</option>";
           $ddyear.= "<option value='2009'>2009</option>";
           $ddyear.= "<option value='2010'>2010</option>";
           $ddyear.= "<option value='2011'>2011</option>";
           $ddyear.= "<option value='2012'>2012</option>";
           $ddyear.= "<option value='2013'>2013</option>";
           $ddyear.= "<option value='2014'>2014</option>";
           $ddyear.= "<option value='2015'>2015</option>";
           $ddyear.= "<option value='2016'>2016</option>";
           $ddyear.= "</select>";
           
           return $ddyear;

 }


 
 function  dropdownsemester($gname){
 
 $ddsemester="";
 $ddsemester .= "<select name='semester_".$gname."' type='text' class='textfield' id='semester_".$gname."'>";
 $ddsemester .= "<option value=''></option>";
 $ddsemester .= "<option value='fall'>F</option>";
 $ddsemester .= "<option value='winter'>W</option>";
 $ddsemester .= "<option value='Spring'>Sp</option>";
 $ddsemester .= "<option value='summer'>Su</option>";
 $ddsemester .= "</select>";
 
 return $ddsemester;
 }
 
 
 
 function grades($gname){

     $grads = "";
     $grads .= "<select name='grade_".$gname."' value='' id='grade_".$gname."' ><option value=''></option>";
     $grads .= "<option value='A'>A</option>";
     $grads .= "<option value='A-'>A-</option>";
     $grads .= "<option value='B+'>B+</option>";
     $grads .= "<option value='B'>B</option>";
     $grads .= "<option value='B-'>B-</option>";
     $grads .= "<option value='C+'>C+</option>";
     $grads .= "<option value='C'>C</option>";
     $grads .= "<option value='C-'>C-</option>";
     $grads .= "<option value='D+'>D+</option>";
     $grads .= "<option value='D'>D</option>";
     $grads .= "<option value='D-'>D-</option>";
     $grads .= "<option value='E'>E</option>";
     $grads .= "</select>";

     return $grads;
 }
 
 function getcname($gname){
 
              $str= "";
              $str .= "<tr><td>";
              $row =getgname($gname);
              $str .= $gname."------".$row['title'];
              $str .= "</td><td>".$row['chrs']."hrs</td><td>";
              $str .= dropdownsemester($gname);
              $str .= dropdownyear($gname);
              $str .= " </td><td>";
              $str .= grades($gname);
              $str .= "</td><td><input name='certification_".$gname."' type='text' class='textfield' id='certification_".$gname."' size= '10'/></td></tr>";
              return $str;
              
 }
?>