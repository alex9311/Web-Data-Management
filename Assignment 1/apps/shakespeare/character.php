<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Character Part</title></head>
<?php
include "queries/get_speaker_part.php";

$section = $_GET['section'];
$section_array = explode(".",$section);
$title = $section_array[0];
$act_no = $section_array[1];
$scene_no = $section_array[2];
$speaker = $section_array[3];
echo "<body>";
echo get_speaker_part($title,$act_no,$scene_no,$speaker);
echo '
 <p>
    <a href="http://validator.w3.org/check?uri=referer"><img
      src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
  </p>
';
echo "</body>";

?>
</html>
