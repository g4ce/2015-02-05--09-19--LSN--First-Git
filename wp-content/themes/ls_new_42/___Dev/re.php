<?php

$data_array = array();
$data_array = csv_to_array('esbdatabase.csv');

//print_r($data_array);

$results = search($data_array, "Date Due", "09/01/2015");   // searched for needs to be made dynamic with current date + 1 month

//print_r($results);

$results_size = count($results);
//echo $results_size;

// Check if any items were found that are due to be calibrated in a months time
$msg .= '<html>
<body>
<p>Hi, this is CalibrationLab.ie Team.</p>
<p>The following items are due to recalibrate shortly:</p>
<br />';

if($results_size > 0){
    // If found


    // instead of job number get the Calibration Cert:
    for ($i=0; $i<$results_size;$i++){
        //print_r($results[$i]);
        $msg .= ($i+1). '. <strong>Date Due:</strong> '. $results[$i]["Date Due"]. ',&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Job No:</strong> '.$results[$i]["Job"]. ',&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Device Info:</strong> '.$results[$i]["Device Details"]. ',&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Serial Number:</strong> ' .$results[$i]["Serial Number"].'<br /><br />';
        
    }

}
$msg .='<br />
For more information please contact us on 057 866 2162 or e-mail us on <a href="mailto:sales@calibrationlab.ie?subject=ESB Certs Enquiry">sales@calibrationlab.ie</a>. Thank you.
</body>
</html>';
$msg = wordwrap($msg, 70, "\r\n");
//echo $msg;
?>
<?php
// So let's send a test email
////send_email_notification('greg@powerpoint.ie', $msg);

// Get ESB emails from database
define( 'SHORTINIT', true );

    require( '../../../../wp-load.php' );



   // $db_results = $wpdb->get_results("SELECT email
   //                                 FROM prem_wp_swpm_members_tbl
    //                                WHERE membership_level = '2'
    //                            ");xxx___psw__swpm_members_tbl

    $db_results = $wpdb->get_results("SELECT email
                                   FROM xxx___psw__swpm_members_tbl
                                   WHERE membership_level = '2'
                               ");

foreach ( $db_results as $result ) 
{
    // send this message to all on the list
    send_email_notification($result->email, $msg);

    //echo $result->email;
}
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
        // To send HTML mail, the Content-type header must be set
        $Headers  = 'MIME-Version: 1.0' . "\r\n";
        $Headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $Headers .= 'From: CalibrationLab Team <sales@calibrationlab.ie>' . "\r\n";

        // Send It
        $success = mail($Email_address, $Subject, $Message, $Headers);

        // redirect to success page 
        if ($success){
            //echo 'i have sent it Greg';
          //print "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.lockoutsafety.com/request-a-brochure-success\">";
        }
        else{
           // echo 'opps, something went wrong Greg';
          //print "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.lockoutsafety.com/email-verification-error\">";
        }
        
    }
}
?>