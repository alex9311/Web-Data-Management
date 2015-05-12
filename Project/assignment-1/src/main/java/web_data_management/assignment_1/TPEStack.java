package web_data_management.assignment_1;

import java.util.List;
import java.util.Stack;

class TPEStack {
	private PatternNode patternNode;
	Stack<Match> matches;
	TPEStack spar;

	List<TPEStack> getDescendantStacks() {
		return null;
	}

	// gets the stacks for all descendants of p
	void push(Match m) {
		matches.push(m);
	}

	Match top() {
		return matches.peek();
	}

	Match pop() {
		return matches.pop();
	}

	public PatternNode getPatternNode() {
		return patternNode;
	}
}
