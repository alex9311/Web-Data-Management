<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
</head>
<body>
<?php include "helpers.php"; ?>
<h2>Select a Play</h2>
<form action="single_play.php" method="post">
	<select name="play">
		<?php echo get_play_dropdown_options();?>
	</select>
	<input type="submit">
</form>
<div style="text-align:center"><a href="../../index.html">Back to Home Screen</a></div>
</body>
</html>
