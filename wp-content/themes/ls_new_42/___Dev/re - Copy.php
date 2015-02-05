<?php

$data_array = array();
$data_array = csv_to_array('esbdatabase.csv');

//print_r($data_array);

$results = search($data_array, "Date Due", "09/01/2015");

//print_r($results);

$results_size = count($results);
//echo $results_size;

// Check if any items were found that are due to be calibrated in a months time
$msg .= '<html>
<body>
<p>Following items are due to recalibrate:</p>
<br />';

if($results_size > 0){
    // If found

    for ($i=0; $i<$results_size;$i++){
        //print_r($results[$i]);
        $msg .= ($i+1). '. <strong>Date Due:</strong> '. $results[$i]["Date Due"]. ',&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Job No:</strong> '.$results[$i]["Job"]. ',&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Device Info:</strong> '.$results[$i]["Device Details"]. ',&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Serial Number:</strong> ' .$results[$i]["Serial Number"].'<br /><br />';
        
    }

}
$msg .='<br />
For more information please contact us on 057 866 2162 or e-mail us on <a href="mailto:sales@calibrationlab.ie?subject=ESB Certs Enquiry">sales@calibrationlab.ie</a>. Thank you.
</body>
</html>';

//echo $msg;
?>
<?php
// So let's send a test email
send_email_notification('greg@powerpoint.ie', $msg);
?>

<?php
function csv_to_array($filename='', $delimiter=',')
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;
    
    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}

?>
<?php 
function search($array, $key, $value) 
{ 
    $results = array(); 

    if (is_array($array)) 
    { 
        if (isset($array[$key]) && $array[$key] == $value) 
            $results[] = $array; 

        foreach ($array as $subarray) 
            $results = array_merge($results, search($subarray, $key, $value)); 
    } 

    return $results; 
} 
?>
<?php
function send_email_notification($Email_address, $Message){

    $EmailFrom = "sales@calibrationlab.ie";
    $Subject = "Calibration Service Due Notification";

    // validation
    $validationOK=true;
    if (!$validationOK) {
      exit;
    }

    $banned = array(
        "pleasedontreplyhere71@gmx.com"
        );

    if ((in_array($Email_address, $banned)) || (!filter_var($Email_address, FILTER_VALIDATE_EMAIL))){
        exit;
    }
    else
    {
        // send notification
        $success = mail($Email_address, $Subject, $Message, "From: CalibrationLab.ie <$EmailFrom>");

        // redirect to success page 
        if ($success){
            echo 'i have sent it Greg';
          //print "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.lockoutsafety.com/request-a-brochure-success\">";
        }
        else{
            echo 'opps, something went wrong Greg';
          //print "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.lockoutsafety.com/email-verification-error\">";
        }
        
    }
}
?>