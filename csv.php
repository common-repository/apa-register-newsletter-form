<?php

if ( ! defined( 'ABSPATH' ) ) exit;
//$con = mysqli_connect("localhost","root","","wordpress_test") or die("can't connect");
//require_once('../../../wp-load.php');

/*$host = 'n5-db4.ilisys.com.au';
$user = 'thenep';
$pass = '7nXhggv0';
$db = 'thenep_db';*/
global $wpdb;
$table = $wpdb->prefix.'reg_form'; // type table name
$file = 'reg_form'; // type your file name
//$link = mysql_connect($host, $user, $pass) or die("Can not connect." . mysql_error());
//mysql_select_db($db) or die("Can not connect.");

//$results =  $wpdb->get_results("SHOW COLUMNS FROM ".$table."",ARRAY_A);
$results = array("SN","Name", "Email","Page URL","page_title","Date Time");
//var_dump($results);
$i = 0;
//if (mysql_num_rows($result) > 0) {
foreach ($results as $result) {
//$csv_output .= $result['Field'].", "; // , or ;
$csv_output .= $result.", "; // , or ;
$i++;
}
//}
 $csv_output .= "\n";

$values = $wpdb->get_results("SELECT * FROM ".$table."",ARRAY_A);
//while ($rowr = mysql_fetch_row($values)) {
	$sn=1;
foreach ($values as $value) {
$csv_output .= $sn.", ".$value['reg_name'].", ".$value['reg_email'].",  ".$value['page_url'].",  ".$value['page_title'].",".$value['date_time'].","; // , or ;

$csv_output .= "\n";
$sn++;
}
//}
 
$filename = $file."_".date("Y-m-d_H-i",time());
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
?>