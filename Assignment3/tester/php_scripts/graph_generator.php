<?php

if(count($argv)!=2){
	echo "please pass the number of nodes as an argument\n";
	exit();
}elseif(!is_numeric($argv[1])){
	echo "please pass the number of nodes as an argument\n";
	exit();
}
	

$num_nodes = $argv[1];
$nodes = range(0,$num_nodes-1);
$final_nodes = [];
for ($x = 0; $x < $num_nodes; $x++) {
	array_push($final_nodes,generate_edges($x,$nodes));
} 
$node_num =0;

foreach($final_nodes as $connections){
	foreach($connections as $connection){
		if (!in_array($node_num,$final_nodes[$connection])){
			array_push($final_nodes[$connection],$node_num);
		}
	}
	$node_num = $node_num+1;
}

for ($x = 0; $x < $num_nodes; $x++) {
	print("$x ".implode(" ",$final_nodes[$x])."\n");
}
function generate_edges($node_num,$nodes){
	unset($nodes[$node_num]);
	$possible_connections = array_values($nodes);
	$num_connections = rand(1,count($nodes)/2);

	shuffle($possible_connections);
	$connected_nodes = array_slice($possible_connections,0,$num_connections);

	return $connected_nodes;
}

?>
