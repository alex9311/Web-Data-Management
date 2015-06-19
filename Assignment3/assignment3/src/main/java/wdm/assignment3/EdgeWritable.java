package wdm.assignment3;

import java.io.DataInput;
import java.io.DataOutput;
import java.io.IOException;

import org.apache.hadoop.io.WritableComparable;

public class EdgeWritable implements WritableComparable<EdgeWritable> {
    public static enum TYPE {NONE, AB, BC, AC};
    
    private long sourceVertex;
    private long targetVertex;
    private TYPE edgeType;

    public EdgeWritable() {

    }

    public EdgeWritable(long firstVertex, long secondVertex) {
        this(firstVertex, secondVertex, TYPE.NONE);
    }

    public EdgeWritable(long firstVertex, long secondVertex, TYPE edgeType) {
        if (firstVertex > secondVertex) {
		    long tmp = firstVertex;
		    firstVertex = secondVertex;
		    secondVertex = tmp;
		}
		this.sourceVertex = firstVertex;
		this.targetVertex = secondVertex;
        this.edgeType = edgeType;
    }

    public void write(DataOutput out) throws IOException {
        out.writeLong(sourceVertex);
        out.writeLong(targetVertex);
        out.writeBytes(edgeType.name());
    }

    public void readFields(DataInput in) throws IOException {
        sourceVertex = in.readLong();
        targetVertex = in.readLong();
        edgeType = TYPE.valueOf(in.readLine());
    }

    @Override
    public boolean equals(Object o) {
        if (!(o instanceof EdgeWritable)) {
        	return false;
        }
        EdgeWritable w = (EdgeWritable) o;
        return (sourceVertex == w.sourceVertex) &&
                (targetVertex == w.targetVertex) &&
                (edgeType == w.edgeType);
    }

    @Override
    public int compareTo(EdgeWritable o) {
        if (sourceVertex != o.sourceVertex)
            return new Long(sourceVertex).compareTo(o.sourceVertex);
        if (targetVertex != o.targetVertex)
            return new Long(targetVertex).compareTo(o.targetVertex);
        return edgeType.compareTo(o.edgeType);
    }

    @Override
    public String toString() {
        return "(" + sourceVertex + "," + targetVertex + "){" + edgeType + "}";
    }

    public long getSourceVertex() {
		return sourceVertex;
	}
    
    public long getTargetVertex() {
		return targetVertex;
	}
    
    public TYPE getEdgeType() {
		return edgeType;
	}
}