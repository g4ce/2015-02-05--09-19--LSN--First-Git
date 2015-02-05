<?php
/*
* Module name: Table Rate Updater
* Author: Greg
* Description: module checks if currency conversion rate to GBP had changed and if so to update the british table rate value for the delivery 
* Version: 1.01
* Modified: 02/12/2014 16:36:30
* Changed: from 200 + 23% = 246 to 200
*/
?>

<!-- tab upd -->

<?php
$resource = Mage::getSingleton('core/resource');
$read     = $resource->getConnection('core_read');
$write 	  = $resource->getConnection('core_write');

$dir_rate = $read->query("SELECT * FROM directory_currency_rate"); 
$dir_row  = $dir_rate->fetchAll();
//print_r($dir_row);
$collected_rate = $dir_row[1]['rate'];
$collected_rate = floatval($collected_rate);
$collected_rate = number_format(round($collected_rate, 4), 4);
$collected_rate_str = strval($collected_rate);

//g_appendToLog($collected_rate_str);


$old_rate  = $read->query("SELECT * FROM g_ship_conv_rate"); 
$old_row = $old_rate->fetchAll();
//print_r($old_row);
$compare_rate = $old_row[0]['rate'];
$compare_rate = floatval($compare_rate);
$compare_rate = number_format(round($compare_rate, 4), 4);
$compare_rate_str = strval($compare_rate);

//g_appendToLog($compare_rate);

//echo 'Old currency rate = '. $collected_rate_str; 
//echo "<br />";
//echo 'Old currency rate from db = '. $compare_rate_str;
//echo "<br />";

if ($collected_rate_str == $compare_rate_str){
	//echo 'no change';
	//echo "<br />";
	//g_appendToLog('no change');
}
else{
	//echo 'changed';
	//echo "<br />";

	// rate had changed
	// so first update old rate
	
	// do other things
	
	// create new rate
	/*
	*/
	$tableRate1 = 10 / $collected_rate;			// currently vat exclusive -> to be changed for 10 / collected rate
	$tableRate2 = 200 / $collected_rate;		// currently vat exclusive -> to be changed for 200 / collected rate
	
	//echo 'new shipping price = '. strval($tableRate1);
	//echo "<br />";
	//echo 'new condition for = '.  strval($tableRate2);
	//echo "<br />";


	//write new table rate
	$write->query("UPDATE shipping_tablerate SET price = ".strval($tableRate1)." WHERE pk=8519; ");
	$write->query("UPDATE shipping_tablerate SET condition_value = ".strval($tableRate2)." WHERE pk=8520; ");
	$write->query("UPDATE g_ship_conv_rate SET rate = ".strval($collected_rate)." WHERE g_ID=1; ");

	//g_appendToLog('Comparison rate successfully updated; old rate = '.$compare_rate_str.' to new rate = ' .$collected_rate_str);

	//echo 'Overwritten old rate = '. $compare_rate_str;
	//echo "<br />";
	//echo 'New compare rate = '. $collected_rate_str;
	//echo "<br />";

	//g_appendToLog('successfully written to db: tableRate10 = ' .strval($tableRate1). ', tableRate200 = ' .strval($tableRate2));
}
function g_appendToLog($message){
	file_put_contents('g_log.txt', date('d/m/Y H:i:s') . " " .$message. " \n", FILE_APPEND);
}
?>

<!-- end tab upd -->