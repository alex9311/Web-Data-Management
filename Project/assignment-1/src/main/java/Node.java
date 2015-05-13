import java.util.List;

import com.google.common.collect.ImmutableList;
import com.google.common.collect.ImmutableList.Builder;
import com.google.common.collect.Lists;


public class Node {

	private final String name;
	private final Node parent;
	private final List<Node> children = Lists.newArrayList();
	private final StringBuffer content = new StringBuffer();
	
	private State state = State.OPEN;

	public Node(String name, Node parent) {
		this.name = name;
		this.parent = parent;
		
	}

	public String getName() {
		return name;
	}

	public Node getParent() {
		return parent;
	}

	public void addChild(Node child) {
		children.add(child);
	}

	public ImmutableList<Node> getChildren() {
		return ImmutableList.copyOf(children);
	}
	
	public ImmutableList<Node> getPredecessors() {
		Builder<Node> resultBuilder = ImmutableList.builder();
		Node directParent = getParent();
		if (directParent != null) {
			resultBuilder.add(directParent);
			resultBuilder.addAll(directParent.getPredecessors());
		}
		
		return resultBuilder.build();
	}
	
	public ImmutableList<Node> getDecendents() {
		Builder<Node> resultBuilder = ImmutableList.builder();
		for (Node child : getChildren()) {
			resultBuilder.add(child);
			resultBuilder.addAll(child.getDecendents());
		}
		
		return resultBuilder.build();
	}

	public State getState() {
		return state;
	}

	public void setState(State state) {
		this.state = state;
	}

	public void addContent(char[] data, int start, int length) {
		content.append(data, start, length);
	}

	public String getContent() {
		return content.toString();
	}
}
