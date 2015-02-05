<?php
// the message
$msg = "First line of text\nSecond line of text";
echo $msg;

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("greg.powerpoint@gmail.com","My subject",$msg);

echo 'sent';
?>