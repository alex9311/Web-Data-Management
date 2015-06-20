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

for ($x = 0; $x < $num_nodes; $x++) {
	echo "$x ".generate_edges($x,$nodes);
} 

function generate_edges($node_num,$nodes){
	unset($nodes[$node_num]);
	$possible_connections = array_values($nodes);
	$num_connections = rand(1,count($nodes));

	shuffle($possible_connections);
	$connected_nodes = array_slice($possible_connections,0,$num_connections);

	return implode(" ",$connected_nodes)."\n";
}

?>
