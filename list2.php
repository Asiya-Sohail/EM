<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>


<?php include_once("includes/form_functions.php");?>
<?php include("includes/header.php");?>

<?/////////////////////////////*********************************************form******************************************\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\?>

<?

function data_table(
		$data, 
		$link=array('field'=>'', 'to'=>'', 'var'=>'', 'skip_if_false'=>false), 
		$skip=array(), 
		$sortlinks=false, 
		$number_rows=false, 
		$deleter=false
) {
	$skip = (array) $skip;
	$csv = ''; // for "export to csv" button
	echo '<table border="0" cellpadding="0" cellspacing="0"><tr><td><table class="webdatatable"><tr>';
	if ($number_rows) echo '<th>#</th>';
	if ($deleter) echo '<th>*</th>';
	foreach ($data[0] as $field => $value) {
		if ( !in_array($field, $skip) ) { // if not a skipped field
			$prettyfield = ucwords(str_replace(array('_', 'icc'), array(' ', 'ICC'), $field));

			// click field name to sort by this field
			if ($sortlinks) {
				if ($sortlinks !== true) // if an integer is passed, enable multiple sort options for the page
					$sortnumber = $sortlinks;
				else $sortnumber = '';
				if (stripslashes($_GET['sort'.$sortnumber]) == $field)
					$sort = "$field DESC";
				else $sort = $field;
				$url = "".$_SERVER['SCRIPT_NAME']."?" . preg_replace('/&sort'.$sortnumber.'=[^&]*/', '', $_SERVER['QUERY_STRING']) .
					"&sort$sortnumber=$sort";
				$url = htmlspecialchars($url);
				echo "<th class=\"link\"><a class=\"hiddenlink\" href=\"$url\">$prettyfield</a></th>";
			}
			else
				echo "<th>".$prettyfield."</th>";
			
			$csv .= '"'.$prettyfield.'",';
		} // if not skipped
	} // for each field
	echo "</tr>\n";
	
	if ($link and !is_array($link['field'])) {
		foreach ($link as $key => $val) {
			$link[$key] = array($link[$key]);
		}
	}
	
	foreach ($data as $i=>$record) {
		$csv .= "\n";

		// set class of row
		if ($record['expired'] == 't')
			$rowclass = 'expired';
		else if ($record['status'] == 'Contract' and $record['valid_contract'] == 'f')
			$rowclass = 'invalid';
		else $rowclass = '';
		if ($rowclass)
			echo "<tr class=\"$rowclass\">";
		else echo "<tr>";
		
		$j = $i+1;
		if ($number_rows) echo "<td class=\"rownumber\">$j</td>";
		if ($deleter) {
			if (!$deleter['prikey']) $deleter['prikey'] = 'id';
			echo "<td class=\"deleter ".$record['ID']."\">"
				. Xout($deleter['table'], $deleter['prikey'], $record[$deleter['prikey']])
				. "</td>";
		}
		
		foreach ($record as $field => $value) {
			if ( !in_array($field, $skip) ) {
				// shorten long values for table display
				$value = str_replace(
					array('Non-Standard Contract', 'Rooming and boarding', 'Partial boarding'),
					array('Non-Standard', 'Room & board', 'Partial board'),
					$value
				);
				if ( preg_match('/contracts\.php/', $_SERVER['PHP_SELF']) 
						and in_array($field, array('contract_period', 'contract'))
				) {
					$value = preg_replace('/[\d\-]+$/', '', $value); // remove year(s) from end
				}

				// if ($field == 'SS') {
				// 	$long = array('Undergraduate (half time or more)', 'Undergraduate (less than half time)', 
				// 		'Graduate student', 'Non-student', 'Global Reach', 'Visiting scholar');
				// 	$short = array('UG', 'UG&lt;', 'Grad', 'NS', 'GR', 'VS');
				// 	foreach ($long as $i => $name) {
				// 		if ($value == $name)
				// 			$value = '<span title="'.$name.'">'.$short[$i].'</span>';
				// 	}
				// }
				
				// translate 't' and 'f' to 'Yes' and 'No' for certain boolean fields
				if (in_array($field, array('re-<br>inspect'))) {
					if ($value == 't') $value = 'Yes';
					else if ($value == 'f') $value = 'No';
				}
				// this one shows 'No' for blank/null too
				if (in_array($field, array('partial'))) {
					if ($value == 't') $value = 'Yes';
					else if ($value == 'f' or $value == '') $value = 'No';
				}
				
				$class = array();
				
				// each column gets its own class
				$class[] = $field;
				// make room number gray if not "real"
				if ($field == 'room' and isset($record['real_room_number']) and $record['real_room_number'] != 't')
					$class[] = 'fake';
				if (preg_match('/^\d+$/', $value) and !preg_match('/room/', $field))
					$class[] = 'number';
				// make whole row bold if available spaces
				if ($record['spaces'] > 0)
					$class[] = 'available';	
				else if ($record['spaces'] === '0')
					$class[] = 'unavailable';
				// make totals row bold
				if ($record['house'] == 'Total')
					$class[] = 'total';
				// highlight in red contracts/holds/homesteads that need a room (logic is in query)
				if ($record['needs_room'] == 't' and ($field == 'room' or $field == 'room_type'))
					$class[] = 'needsroom';
	
				if ($class)
					$class = implode(' ', $class);
				else $class = '';
				
				if ( isset($link['field'][0]) ) { // if a valid $link array was given
					// see if this field should be linked
					$key = array_search($field, $link['field']); // returns key, false if not found
					if ($link['skip_if_false'] and !$record[$field])
						$key = false;
				}
				else $key = false; // field should not be linked
				if ( $key!==false ) { // if field should be linked
					
					if ($link['var'][$key]) { // corresponding var
						$varname = (array) $link['var'][$key];
						$var = array();
						foreach ($varname as $i)
							$var[] = $record[$i]; // value from record for this var
					}
					else $var = array();
					
					$link_split = explode('%s', $link['to'][$key]);
					$link_complete = '';
					for ($i=0; $i<count($link_split); $i++) {
						$link_complete .= $link_split[$i];
						$link_complete .= $var[$i];
					}
					$link_complete .= $link_split[$i]; // gets the last piece
					
					echo "<td class=\"$class link\"><a href=\"".htmlspecialchars($link_complete)."\">$value</a></td>";
				} // if field should be linked
				else if (preg_match('/<a href=/', $value)) { // if this field already contains a link, give it the appropriate class
					echo "<td class=\"$class link\">$value</td>";
				}
				else {
					echo "<td class=\"$class nolink\">$value</td>";
				}
				
				$csv .= '"'.trim(preg_replace('/<.+?>/', '', $value)).'",'; // strip html tags from values (e.g. "notes" field)
			} // if not skipped
		} // for each field
		echo "</tr>\n";
	} // for each record
	echo "</table></td></tr>";
	
	// export to csv button
	if (!preg_match('/\/apply\//', $_SERVER['PHP_SELF']) || preg_match('/roomchecklistresults.php/', $_SERVER['PHP_SELF'])) { // don't display export button if in /apply section
		// if in /house section, need to go up one directory to find export function
		if (preg_match('/\/house\//', $_SERVER['PHP_SELF'])|| preg_match('/\/scripts\//', $_SERVER['PHP_SELF'])|| preg_match('/roomchecklistresults.php/', $_SERVER['PHP_SELF'])) 
			$get_to_file = '../';
		else $get_to_file = '';
		// export button (each table gets its own link containing all table data)
		echo '<tr><td><form name="export" method="post" action="'.$get_to_file.'export_csv.php">';
		echo '<input type="hidden" name="csv" value="'.base64_encode(gzcompress($csv)).'">';
		echo '<input type="submit" name="export" value="export" class="exportbutton" title="Export table to CSV file">';
		echo '</form></td></tr>';
	}
	
	echo "</table>";
} // function data_table

?>

<!--******************************************************************search engin ****************************************************-->
<?php
	
	$csv_column=array();
	$csv_rows=array();
	$j=0;
	$csv_column[]="First Name";
	$csv_column[]="Last Name";
	$csv_column[]="Email";
	$csv_column[]="Track";

	$qry="SELECT * FROM member order by track,lastname";
		$result = mysqli_query($connection,$qry);
		$row = mysqli_fetch_assoc( $result );
		$str ="";
		$str .= "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Track</th>";
	   $coqry="SELECT DISTINCT(gname) FROM emcourse order by gname asc";
		$coresult = mysqli_query($connection,$coqry);
		while($corow = mysqli_fetch_assoc( $coresult )){
			$str .= "<th>".$corow['gname']."</th>";
			$csv_column[]=$corow['gname'];
		}
		
	   $str .= "</tr>";
       while($row = mysqli_fetch_assoc( $result ))
       {
	    $track="";
		if ($row['track'] == 1){$track="Design and Manufacturing";} if ($row['track'] == 2){$track="Lean Enterprise System";} if ($row['track'] == 3){$track="Project and Program Management";} if ($row['track'] == 4){$track="Quality Certificate Program";} if ($row['track'] == 5){$track="Research and Development";}
        $str .="<tr><td>".$row['firstname']."</td><td>".$row['lastname']."</td><td>".$row['email']."</td><td>".$track."</td>";
        $j=$j+1;
		$csv_rows[j]= $row['firstname'].",".$row['lastname'].",".$row['email'].",".$track;
		
		//check if the student take the gname
		$coqry2="SELECT DISTINCT(gname) FROM emcourse order by gname asc";
		$coresult2 = mysqli_query($connection,$coqry2);
		while($corow2 = mysqli_fetch_assoc( $coresult2 )){
			//$str .= "<th>".$corow['gname']."</th>";
			
				$qry2="SELECT * FROM coursemember, emcourse, course  WHERE coursemember.EID='".$row['EID']."' and emcourse.gname='".$corow2['gname']."' and coursemember.CID= course.CID and emcourse.EMCID=course.EMCID order by gname asc LIMIT 1";
				$result2 = mysqli_query($connection,$qry2);
				$str .="<td>";
				while($row2 = mysqli_fetch_assoc( $result2 )){
					$str .=$row2['year']."-".$row2['semester'];	
				}
				
				//$csv_rows[j] .= ",".$row2['gname']."--".$row2['year']."-".$row2['semester']
				$str .="</td>";
		}
	      
	   }
      	
	  $str .="</tr></table>";
       echo $str;
	   
	   
	   
	   
		// output headers so that the file is downloaded rather than displayed
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');

		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');

		// output the column headings
		fputcsv($output, $csv_column() );

		// fetch the data
		//mysql_connect('localhost', 'username', 'password');
		//mysql_select_db('database');
		//$rows = mysql_query('SELECT field1,field2,field3 FROM table');

		// loop over the rows, outputting them
		//while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
		
		fputcsv($output, $csv_rows());
		
		
	   data_table($csv_rows,'', '');

?>

<?php include("includes/footer.php"); ?>




