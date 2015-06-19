hadoop com.sun.tools.javac.Main TriangleCounterInHadoop.java EdgeWritable.java -d class_files
jar cvf WDMHadoop.jar -C class_files/ .

