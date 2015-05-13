import java.util.ArrayList;
import java.util.Stack;

import org.apache.commons.lang3.StringUtils;

import com.google.common.collect.Lists;


public class TreeQuery {
	private final Stack<String> queryStack = new Stack<String>();
	private final Stack<String> parentStack = new Stack<String>();
	
	public TreeQuery(String query) {
		if (StringUtils.contains(query, "/")) {
			ArrayList<String> splitQuery = Lists.newArrayList(StringUtils.split(query, "/"));
			for (String string : Lists.reverse(splitQuery)) {
				queryStack.push(string);
			}
		}
		else {
			queryStack.push(query);
		}
	}
	
	public boolean checkMatch(Node parent, String childNodeName) {
		if (parentStack.isEmpty()) {
			if (StringUtils.equals(queryStack.peek(), childNodeName)) {
				parentStack.push(queryStack.pop());
				return true;
			}
			else if (StringUtils.equals(queryStack.peek(), "*")) {
				parentStack.push(queryStack.peek());
			}
		}
		
		for (Node predecessor : parent.getPredecessors()) {
			if (!parentStack.empty()) {
				if (StringUtils.equals(parentStack.peek(), "*") || StringUtils.equals(parentStack.peek(), predecessor.getName())) {
					for (String string : queryStack) {
						if (StringUtils.equals(string, childNodeName)) {
							parentStack.push(queryStack.pop());
							return true;
						}
						else if (StringUtils.equals(string, "*")) {
							parentStack.push(queryStack.peek());
						}
					}
				}
			}
		}
		
		return false;
	}
	
	public void closingTag(String tag) {
		if (parentStack.peek().equals(tag)) {
			queryStack.push(parentStack.pop());
		}
	}
}
