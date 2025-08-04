<html>
<head>
<?php require_once('includes/session.php'); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once('includes/functions.php'); include_once("includes/form_functions.php");?>
</head>
<?php

/**
 * @file swa.php
 *
 * Smith-Waterman alignment algorithm for words
 *
 * See http://en.wikipedia.org/wiki/Smith-Waterman_algorithm for basic algorithm
 */

//--------------------------------------------------------------------------------------------------
/**
 * @brief Clean token 
 *
 * Remove terminal punctuation, such as full stops
 *
 * @param token Text token to be cleaned
 *
 * @return Cleaned token
 */
function clean_token($token)
{
        $token = preg_replace('/\.$/', '', $token);
        return $token;
}

//--------------------------------------------------------------------------------------------------
/**
 * @brief Split string into array of tokens using whitespace as the delimiter
 *
 * @param str String to be tokenised
 *
 * @return Array of tokens
 */
function tokenise_string($str)
{
        return preg_split("/[\s]+/", $str);
}

//--------------------------------------------------------------------------------------------------
/**
 * @brief Align words in two strings using Smith-Waterman algorithm
 *
 * Strings are split into words, and the resulting arrays are aligned using Smith-Waterman algorithm
 * which finds a local alignment of the two strings. Aligning words rather than characters saves
 * memory
 *
 * @param str1 First string (haystack)
 * @param str2 First string (needle)
 * @param html Will contain the alignment between str1 and str2 in HTML format
 *
 * @return The score (0-1) of the alignment, where 1 is a perfect match between str2 and a subsequence of str1
 */
function smith_waterman ($str1, $str2, $html)
{
        $output= array();
		$score = 0.000;
        
        // Weights
        $match          = 2;
        $mismatch       = -1;
        $deletion       = -1;
        $insertion      =-1;
        
        // Tokenise input strings, and convert to lower case
        $X = tokenise_string($str1);
        $Y = tokenise_string($str2);
        
        // Lengths of strings
        $m = count($X);
        $n = count($Y);
		//echo $m."///\\\\".$n;
        
        // Create and initialise matrix for dynamic programming
        $H = array();
        
        for ($i = 0; $i <= $m; $i++)
        {
                $H[$i][0] = 0;
        }
        for ($j = 0; $j <= $m; $j++)
        {
                $H[0][$j] = 0;
        }
        
        $max_i = 0;
        $max_j = 0;
        $max_H = 0;
        
        for ($i = 1; $i <= $m; $i++)
        {
                for ($j = 1; $j <= $n; $j++)
                {               
                        $a = $H[$i-1][$j-1];
                        
                        $s1 = clean_token($X[$i-1]);
                        $s2 = clean_token($Y[$j-1]);
                        
                        // Compute score of four possible situations (match, mismatch, deletion, insertion
                        if (strcasecmp ($s1, $s2) == 0)
                        {
                                // Strings are identical
                                $a += $match;
                        }
                        else
                        {
                                // Strings are different
                                //$a -= levenshtein($X[$i-1], $Y[$i-1]); // allow approximate string match
                                $a += $mismatch; // you're either the same or you're not
                        }
                
                        $b = $H[$i-1][$j] + $deletion;
                        $c = $H[$i][$j-1] + $insertion;
                        
                        $H[$i][$j] = max(max($a,$b),$c);
                                                
                        if ($H[$i][$j] > $max_H)
                        {
                                $max_H = $H[$i][$j];
                                $max_i = $i;
                                $max_j = $j;
                        }
                }
        }
        
        // Best possible score is perfect alignment with no mismatches or gaps
        $maximum_possible_score = count($Y) * $match;
        $score = $max_H / $maximum_possible_score;
        
        //echo "<p>Score=$score</p>";
        
                
        // Traceback to recover alignment
        $alignment = array();
        
        $value = $H[$max_i][$max_j];
        $i = $max_i-1;
        $j = $max_j-1;
        while (($value != 0) && (($i != 0) && ($j != 0)))
        {
                //echo $H[$i][$j] . "\n";
                //echo $i . ',' . $j . "\n";
                //echo $X[$i] . '-' . $Y[$j] . "\n";
                //print_r($X);
                //print_r($Y);
                
                $s1 = clean_token($X[$i]);
                $s2 = clean_token($Y[$j]);
                
                if ($s2 != '')
                {
                        array_unshift($alignment, 
                                array(
                                        'pos' => $i, 
                                        'match' => ((strcasecmp($s1,$s2)==0) ? 1 : 0),
                                        'token' => $X[$i]
                                        )
                                );
                }
                        
                $up = $H[$i-1][$j];
                $left =  $H[$i][$j-1];
                $diag = $H[$i-1][$j-1];
        
                if ($up > $left)
                {
                        if ($up > $diag)
                        {
                                $i -= 1;
                        }
                        else
                        {
                                $i -= 1;
                                $j -= 1;
                        }
                }
                else
                {
                        if ($left > $diag)
                        {
                                $j -= 1;
                        }
                        else
                        {
                                $i -= 1;
                                $j -= 1;
                        }
                }
        }
        //echo $i . ',' . $j . "\n";
        //echo $X[$i] . '-' . $Y[$j] . "\n";
        
        // Store last token in alignment
        $s1 = clean_token($X[$i]);
        $s2 = clean_token($Y[$j]);
                
        array_unshift($alignment, 
                array(
                        'pos' => $i, 
                        'match' => ((strcasecmp($s1,$s2)==0) ? 1 : 0),
                        'token' => $X[$i]
                        )
                );

        // HTML snippet showing alignment
        
        // Local alignment
        $snippet = '';
        $last_pos = -1;
        foreach ($alignment as $a)
        {
                if ($a['pos'] != $last_pos)
                {
                
                        if ($a['match'] == 1)
                        {
                                $snippet .= '<span style="color:black;font-weight:bold;background-color:yellow;">';
                        }
                        else
                        {
                                $snippet .= '<span style="color:rgb(128,128,128);font-weight:bold;background-color:yellow;">';
                        }
                        $snippet .= $a['token'] . ' ';//$Z[$a['pos']] . ' ';
                
                        $snippet .= '</span>';
                }
                $last_pos = $a['pos'];
                
        }       
        // Embed this in haystack string
        
        // Before alignment
        $start_pos = $alignment[0]['pos'] - 1;
        $prefix_start = max(0, $start_pos - 10);
        $prefix = '';
        while ($start_pos > $prefix_start)
        {
                $prefix = $X[$start_pos] . ' ' . $prefix;
                $start_pos--;
        }
        if ($start_pos > 0) $prefix = '…' . $prefix;

        // After alignment      
        $end_pos = $alignment[count($alignment) - 1]['pos'] + 1;
        $suffix_end = min(count($X), $end_pos + 10);
        $suffix = '';
        while ($end_pos < $suffix_end)
        {
                $suffix .= ' ' . $X[$end_pos];
                $end_pos++;
        }
        if ($end_pos < count($X)) $suffix .= '…';

        $html = $prefix . $snippet . $suffix;   
        
        //return $score;
		$output []= $score;
		$output [] = $html;
		return $output;
}

?>

<body>

<?
$start = microtime(true);

 $finalarr=array();
 $finalarr2=array();
// for set memory limit & execution time
ini_set('memory_limit', '10512M');
ini_set('max_execution_time', '10080');
////////////////////read the mutation signature
$file_handle1 = fopen('mutation1.csv', 'r');
	$j=0;
	while (!feof($file_handle1) ) {
	//$i=0;
       set_time_limit(1000); // you can enable this if you have lot of data
       $line_of_text1[] = fgetcsv($file_handle1, 100024);
		$str1=$line_of_text1[$j][4];	
		echo "Exam for Mutation..........".$line_of_text1[$j][2].".............with a following sequence.............".$str1."<hr/>";

//function to read csv file
    $file_handle = fopen('test1.csv', 'r');
    $i=0;
	echo "<table border='1' size ='100%' class='table'><tr><th>Exon</th><th>Match (Smith Waterman)</th><th>Levenshtein</th><th>Similarity<tr>";
	while (!feof($file_handle) ) {
	//$i=0;
       set_time_limit(1000); // you can enable this if you have lot of data
       $line_of_text[] = fgetcsv($file_handle, 100024);
		//$line_of_text[0];
		//print_r($line_of_text);
		//print_r($line_of_text[$i]);
		//echo $line_of_text[$i][4];
		$str2=$line_of_text[$i][4];
		//$str1="CTTGCCGTCAGCCTTTTCTTTGACCTCTTCTTTCTGTTCATGTGTATTTGCTGTCTCTTAGCCC";
		$output = smith_waterman($str2, $str1, $html);
		similar_text($line_of_text[$i][4], $str1, $percent);
		//echo $output[0]."<br/>".$output[1]."<hr/>";
		
	//echo "<hr/>";
	if ($output[0]==1){$finalarr[]= $line_of_text1[$j][0]."===".$line_of_text1[$j][4]."===".$percent."<br/>Mutation sequence".$output[1];}
	if ($percent > 50){$finalarr2[]= $line_of_text1[$j][0]."===".$line_of_text1[$j][4]."===".$percent."<br/>Mutation sequence".$output[1];}
	echo "<tr><td>".$line_of_text[$i][0]."</td><td>".$percent."</td><td>".$output[0]."</td><td>".$output[1]."</td></tr>";
	
	$i++;
  }
   fclose($file_handle);
   echo "</table>";
      
   	$j++;
	}
   fclose($file_handle1);
	echo "<br/><br/><br/>";
   //<pre>
  // print_r($finalarr);
   	echo "<div class=\"errors\">";
	$end = microtime(true);

	printf("Page was generated in %f seconds", $end - $start);
	
	echo "The following matches have been found:<br /><hr/>";
	$l=1;
	foreach($finalarr as $error) {
		echo $l." - " . $error . "<br /><hr/>";
		$l++;
	}
	echo "</div>";
   //</pre>
   	echo "The following matches have been found:<br /><hr/>";
	$l=1;
	foreach($finalarr2 as $error) {
		echo $l." - " . $error . "<br /><hr/>";
		$l++;
	}
	echo "</div>";
   
  ?>
</body>
</html>
