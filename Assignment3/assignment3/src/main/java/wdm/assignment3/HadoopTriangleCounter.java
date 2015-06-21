package wdm.assignment3;

import java.io.IOException;
import java.util.ArrayList;
import java.util.Map;
import java.util.Set;

import org.apache.commons.lang.StringUtils;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.LongWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;

import com.google.common.collect.Lists;
import com.google.common.collect.Maps;
import com.google.common.collect.Sets;

/**
 * Calculates triangles using Hadoop map-reduce assuming triangle ABC.
 * We use LongWritable as the input is parsed to the mapper as LongWritable
 * and the result is also expected to be LongWritable.
 * @author peter
 */
public class HadoopTriangleCounter {

    private static final int NUMBER_OF_BUCKETS = 3;
    
    private static final Log LOG = LogFactory.getLog(HadoopTriangleCounter.class);

    public static class EdgeMapper extends Mapper<LongWritable, Text, LongWritable, EdgeWritable> {

        public void map(LongWritable key, Text input, Context context) throws IOException, InterruptedException {
        	ArrayList<String> inputList = Lists.newArrayList(StringUtils.split(input.toString(), " "));
        	
        	LOG.info(NUMBER_OF_BUCKETS);
        	LOG.info("Input list" + inputList);
        	
        	int startVertex = Integer.parseInt(inputList.get(0));
        	LOG.info("Start Vertex: " + startVertex);
        	
        	for (int i = 1; i < inputList.size(); i++) {
        		int neighborVertex = Integer.parseInt(inputList.get(i));
        		LOG.info("Neighbor Vertex: " + neighborVertex);
        		
        		if (startVertex < neighborVertex) {
        			int startVertexModulo = calculateModulo(startVertex);
        			int neighborVertexModulo = calculateModulo(neighborVertex);
        			int reducerNumber;

        			for (int j = 0; j < NUMBER_OF_BUCKETS; j++) {
        				reducerNumber = startVertexModulo * NUMBER_OF_BUCKETS ^ 2 + neighborVertexModulo * NUMBER_OF_BUCKETS + j;
        				LOG.info("Send edge AB to reducer with hash(A, B, j): " + reducerNumber);
        				context.write(new LongWritable(reducerNumber), new EdgeWritable(startVertex, neighborVertex, EdgeWritable.TYPE.AB));
        				reducerNumber = j * NUMBER_OF_BUCKETS ^ 2 + startVertexModulo * NUMBER_OF_BUCKETS + neighborVertexModulo;
        				LOG.info("Send edge BC to reducer with hash(j, B, C): " + reducerNumber);
        				context.write(new LongWritable(reducerNumber), new EdgeWritable(startVertex, neighborVertex, EdgeWritable.TYPE.BC));
        				reducerNumber = startVertexModulo * NUMBER_OF_BUCKETS ^ 2 + j * NUMBER_OF_BUCKETS + neighborVertexModulo;
        				LOG.info("Send edge AC to reducer with hash(A, j, C): " + reducerNumber);
        				context.write(new LongWritable(reducerNumber), new EdgeWritable(startVertex, neighborVertex, EdgeWritable.TYPE.AC));
        			}
        		}
        	}
        }

		private int calculateModulo(int vertex) {
			return vertex % NUMBER_OF_BUCKETS;
		}
    }

    public static class EdgeReducer extends Reducer<LongWritable, EdgeWritable, LongWritable, LongWritable> {

        public void reduce(LongWritable reducerNumber, Iterable<EdgeWritable> values, Context context) throws IOException, InterruptedException {
            
        	
        	Map<EdgeWritable.TYPE, Set<EdgeWritable>> edgeTypeMap = Maps.newHashMap();
            for (EdgeWritable.TYPE edgeType : EdgeWritable.TYPE.values()){
            	edgeTypeMap.put(edgeType, Sets.<EdgeWritable>newTreeSet());
            }
            for (EdgeWritable edge : values) {
            	edgeTypeMap.get(edge.getEdgeType()).add(new EdgeWritable(edge.getSourceVertex(), edge.getTargetVertex()));
            }

            long numberOfTriangles = 0;
            for (EdgeWritable edgeAB: edgeTypeMap.get(EdgeWritable.TYPE.AB)) {
                for(EdgeWritable edgeBC: edgeTypeMap.get(EdgeWritable.TYPE.BC)){
                    if(edgeAB.getTargetVertex() == edgeBC.getSourceVertex()) {
                        if(edgeTypeMap.get(EdgeWritable.TYPE.AC).contains(new EdgeWritable(edgeAB.getSourceVertex(), edgeBC.getTargetVertex()))) {
                        	numberOfTriangles++;
                        	LOG.info("Adding triangle to reducer: " + reducerNumber);
                        }
                    }
                }
            }

            context.write(reducerNumber, new LongWritable(numberOfTriangles));
        }
    }

    public static void main(String[] args) throws Exception {
        Configuration conf = new Configuration();

        Job job = Job.getInstance(conf, "Triangle counter");
        job.setJarByClass(HadoopTriangleCounter.class);

        job.setMapperClass(HadoopTriangleCounter.EdgeMapper.class);
        job.setReducerClass(HadoopTriangleCounter.EdgeReducer.class);
        
        job.setMapOutputKeyClass(LongWritable.class);
        job.setMapOutputValueClass(EdgeWritable.class);
        
        job.setOutputKeyClass(LongWritable.class);
        job.setOutputValueClass(LongWritable.class);

        FileInputFormat.addInputPath(job, new Path(args[0]));
        FileOutputFormat.setOutputPath(job, new Path(args[1]));

        System.exit(job.waitForCompletion(true) ? 0 : 1);
    }
}
