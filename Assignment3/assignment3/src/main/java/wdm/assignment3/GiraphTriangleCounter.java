package wdm.assignment3;

import java.io.IOException;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.apache.giraph.edge.Edge;
import org.apache.giraph.graph.BasicComputation;
import org.apache.giraph.graph.Vertex;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.NullWritable;

/**
 * Calculates triangles using Giraph assuming triangle ABC
 * @author peter
 */
public class GiraphTriangleCounter extends BasicComputation<
        IntWritable, IntWritable, NullWritable, IntWritable> {

    private static final Log LOG = LogFactory.getLog(GiraphTriangleCounter.class);

    @Override
    public void compute(
            Vertex<IntWritable, IntWritable, NullWritable> vertex,
            Iterable<IntWritable> messages) throws IOException {

    	LOG.info("Started computation for vertex: " + vertex.getId().get());
    	
        long superstep = getSuperstep();
        IntWritable vertexId = vertex.getId();
        
        if (superstep == 0) {
        	sendEdgeABMessage(vertex.getEdges(), vertexId);
        }

        if (superstep == 1) {
        	forwardBCMessage(vertex.getEdges(), messages, vertexId);
        }

        if (superstep == 2) {
        	forwardCAMessage(vertex.getEdges(), messages);
        }

        if (superstep == 3) {
        	countIncommingMessages(vertex, messages);
        }

        vertex.voteToHalt();

    }

	private void sendEdgeABMessage(Iterable<Edge<IntWritable, NullWritable>> edges, IntWritable vertexId) {
        for (Edge<IntWritable, NullWritable> edge : edges) {
        	IntWritable targetVertexId = edge.getTargetVertexId();
			if (targetVertexId.get() > vertexId.get()) {
                sendMessage(targetVertexId, vertexId);
            }
        }
	}

	private void forwardBCMessage(Iterable<Edge<IntWritable, NullWritable>> edges, Iterable<IntWritable> messages, IntWritable vertexId) {
        for (IntWritable message: messages) {
            for (Edge<IntWritable, NullWritable> edge : edges) {
                IntWritable targetVertexId = edge.getTargetVertexId();
				if (targetVertexId.get() > vertexId.get()) {
                    sendMessage(targetVertexId, message);
                }
            }
        }
	}

	private void forwardCAMessage(Iterable<Edge<IntWritable, NullWritable>> edges, Iterable<IntWritable> messages) {
        for (IntWritable message: messages) {
            for (Edge<IntWritable, NullWritable> edge : edges) {
                sendMessage(edge.getTargetVertexId(), message);
            }
        }
	}

	private void countIncommingMessages(Vertex<IntWritable, IntWritable, NullWritable> vertex, Iterable<IntWritable> messages) {
        int numberOfTriangles = 0;
        for (IntWritable message: messages) {
            if(message.get() == vertex.getId().get()){
                numberOfTriangles ++;
            }
        }
        vertex.setValue(new IntWritable(numberOfTriangles));
	}
}