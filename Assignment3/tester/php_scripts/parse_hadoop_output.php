<?php

if(count($argv)!=2){
	echo "please pass the name of the graph file\n";
	exit();
}

$filename = $argv[1];	
count_result_triangles($filename);

function count_result_triangles($filename){
	$myfile = fopen($filename, "r") or die("Unable to open file!");
	$triangle_count = 0;
	while(!feof($myfile)) {
		$result_line = fgets($myfile);
		if($result_line!=""){
			if(is_numeric(substr($result_line,0,1))){
				$triangle_count = $triangle_count + (explode("\t",$result_line)[1]);
			}
		}
	}
	fclose($myfile);
	echo "counted $triangle_count triangles in output\n";
}

?>
