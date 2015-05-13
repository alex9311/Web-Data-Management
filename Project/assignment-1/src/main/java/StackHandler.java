import java.util.Stack;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

import com.google.common.collect.Lists;

public class StackHandler extends DefaultHandler {

	private final Node queryResultRootNode;
	private final TreeQuery query;
	private final Stack<Node> traversalStack = new Stack<Node>();
	
	public StackHandler(Node queryResultRootNode, TreeQuery query) {
		this.queryResultRootNode = queryResultRootNode;
		this.query = query;
	}
	
	public void startElement(String uri, String localName, String qName, Attributes attributes) throws SAXException {
		addChild(queryResultRootNode, qName);
	}

	private void addChild(Node parent, String qName) {
		boolean addChild = true;
		if (parent.getState() == State.OPEN) {
			for (Node child : parent.getChildren()) {
				if (child.getState() == State.OPEN) {
					addChild = false;
					addChild(child, qName);
				}
			}
			if (addChild && query.checkMatch(parent, qName)) {
				Node newNode = new Node(qName, parent);
				traversalStack.push(newNode);
				parent.addChild(newNode);
			}
		}
	}

	public void endElement(String uri, String localName, String qName) throws SAXException {
		if (!traversalStack.isEmpty()) {
			query.closingTag(traversalStack.pop().getName());
		}
		for (Node decendent : Lists.reverse(queryResultRootNode.getDecendents())) {
			if (decendent.getState() == State.OPEN && decendent.getName().equals(qName)) {
				decendent.setState(State.CLOSED);
			}
		}
	}
	
	 public void characters(char[] data, int start, int length) {
		 if (!traversalStack.isEmpty()) {
			 traversalStack.peek().addContent(data, start, length);
		 }
	 }
}
