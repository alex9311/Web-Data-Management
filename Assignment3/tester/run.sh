echo "starting script"
 
if [ $# -eq 0 ] 
then echo "no graph file given!" 
	exit
fi

graph_file=$1
filename="/input/$(basename $graph_file)"

if [ ! -f $graph_file ];
then echo "File $graph_file does not exist, please supply a graph file"
	exit
fi


echo "setting up directories on hdfs"
$HADOOP_HOME/bin/hdfs dfs -rm -r /input >&- 2>&-
$HADOOP_HOME/bin/hdfs dfs -mkdir /input >&- 2>&-
$HADOOP_HOME/bin/hdfs dfs -put "$graph_file" /input >&- 2>&-

$HADOOP_HOME/bin/hdfs dfs -rm -r -skipTrash /hadoop_output >&- 2>&-
$HADOOP_HOME/bin/hdfs dfs -rm -r -skipTrash /giraph_output >&- 2>&-

jar_file="/home/peter/workspace/assignment3/target/assignment3-0.0.1-SNAPSHOT-jar-with-dependencies.jar"

echo "running hadoop solution"
$HADOOP_HOME/bin/hadoop jar "$jar_file" wdm.assignment3.HadoopTriangleCounter "$filename" /hadoop_output >&- 2>&-
$HADOOP_HOME/bin/hdfs dfs -cat /hadoop_output/p* > hadoop_output.txt 

echo "hadoop solution complete:"
php php_scripts/parse_hadoop_output.php hadoop_output.txt
rm hadoop_output.txt

echo "running giraph solution"
$HADOOP_HOME/bin/hadoop jar "$jar_file" org.apache.giraph.GiraphRunner wdm.assignment3.GiraphTriangleCounter -vif org.apache.giraph.io.formats.IntIntNullTextInputFormat -vip "$filename" -vof org.apache.giraph.io.formats.IdWithValueTextOutputFormat -op /giraph_output/ -w 1 -ca giraph.SplitMasterWorker=false >&- 2>&-
$HADOOP_HOME/bin/hdfs dfs -cat /giraph_output/p* > giraph_output.txt

echo "giraph solution complete:"
php php_scripts/parse_hadoop_output.php giraph_output.txt
rm giraph_output.txt

echo "running brute force checker:"
php php_scripts/graph_solver.php $graph_file
