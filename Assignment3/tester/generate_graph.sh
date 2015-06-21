echo "starting script"
 
if [ $# -eq 0 ] 
then echo "please supply a number of vertices" 
	exit
fi
rm new_grap

php php_scripts/graph_generator.php  "$1" > new_graph
cat new_graph
echo "stored new graph in file new_graph"

