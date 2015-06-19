hadoop fs -rm -r /user/alexandersimes/graph/output
hadoop fs -mkdir /user/alexandersimes/graph/output


hadoop fs -rm -r /user/alexandersimes/graph/input
hadoop fs -mkdir /user/alexandersimes/graph/input

hadoop fs  -put graphs/graph1 /user/alexandersimes/graph/input

hadoop jar WDMHadoop.jar com.hadoop.webdatamanagement.TriangleCounterInHadoop /user/alexandersimes/graph/input /user/alexandersimes/graph/output/output1

hadoop fs -cat /user/alexandersimes/graph/output/output1/part-r-00000 > test.txt
