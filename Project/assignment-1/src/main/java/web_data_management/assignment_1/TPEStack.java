package web_data_management.assignment_1;

import java.util.List;
import java.util.Stack;

public class TPEStack {
	private PatternNode patternNode;
	private Stack<Match> matches;
	TPEStack spar;

	public List<TPEStack> getDescendantStacks() {
		return null;
	}

	// gets the stacks for all descendants of p
	public void push(Match m) {
		matches.push(m);
	}

	public Match top() {
		return matches.peek();
	}

	public Match pop() {
		return matches.pop();
	}

	public PatternNode getPatternNode() {
		return patternNode;
	}
}
