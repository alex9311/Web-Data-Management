<?php

if(count($argv)!=2){
	echo "please pass the name of the graph file\n";
	exit();
}

$filename = $argv[1];	

$nodes_edges = file_to_edges($filename);
$edges = $nodes_edges[1];
$nodes = $nodes_edges[0];

count_triangles($edges,$nodes);

function count_triangles($edges,$nodes){
	$num_edges=0;
	$found_triangles = [];
	foreach($edges as $edge){
		$node1 = $edge[0];
		$node2 = $edge[1];
		foreach($nodes as $node3){
			if(find_edge($edges,array($node2,$node3))&&find_edge($edges,array($node3,$node1))){
				$triangle = array($node1,$node2,$node3);
				asort($triangle);
				$triangle_string = implode(",",$triangle);
				if(!in_array($triangle_string,$found_triangles)){
					array_push($found_triangles,$triangle_string);		
					$num_edges = $num_edges+1;
				}
			}
		}
	}
	echo "found $num_edges triangles in the graph\n";
}

function find_edge($edges,$find_edge){
	foreach($edges as $edge){
		if($edge[0]==$find_edge[0] && $edge[1]==$find_edge[1]){
			return true;
		}elseif($edge[1]==$find_edge[0] && $edge[0]==$find_edge[1]){
			return true;
		}
	}
	return false;
}


function append_edges($edges_so_far,$base_node,$connected_nodes){
	foreach($connected_nodes as $connected_node){
		array_push($edges_so_far,array($base_node,intval($connected_node)));
	}
	return $edges_so_far;
}

function file_to_edges($filename){
	$myfile = fopen($filename, "r") or die("Unable to open file!");
	$edges = [];
	$nodes = [];
	while(!feof($myfile)) {
		$connectors_string = fgets($myfile);
		if($connectors_string!=""){
			$connectors_array = explode(" ",$connectors_string);

			$node_num = $connectors_array[0];
			array_push($nodes,$node_num);

			$connectors = array_slice($connectors_array,1);
			$edges = append_edges($edges,$node_num,$connectors);
		}
	}
	fclose($myfile);
	return array($nodes,$edges);
}

?>
