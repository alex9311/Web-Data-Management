<?php
include "queries/get_speaker_part.php";

$section = $_GET['section'];
$section_array = explode(".",$section);
$title = $section_array[0];
$act_no = $section_array[1];
$scene_no = $section_array[2];
$speaker = $section_array[3];
echo get_speaker_part($title,$act_no,$scene_no,$speaker);

?>
