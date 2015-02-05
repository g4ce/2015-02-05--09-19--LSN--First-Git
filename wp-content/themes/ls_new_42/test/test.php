<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 
<body>

<form>
	<input type="text"></input>
	<input type="hidden" id="hidden-118" name="hidden-118" value="do kitu"></input>

</form>

<script type="text/javascript">
	
	jQuery(document).ready(function($) {
    $('#hidden-118').val('<?php echo $msg; ?>');
});

</script>
	
</body>
</html>