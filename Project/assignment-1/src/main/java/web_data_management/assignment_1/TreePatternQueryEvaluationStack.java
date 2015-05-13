package web_data_management.assignment_1;

import java.util.List;
import java.util.Stack;

import com.google.common.collect.Lists;

public class TreePatternQueryEvaluationStack {
	private final PatternNode ownNode;
	private final TreePatternQueryEvaluationStack parentStack;
	
	private final Stack<Match> matches = new Stack<Match>();
	private final List<TreePatternQueryEvaluationStack> decendantStacks = Lists.newArrayList();
	
	public TreePatternQueryEvaluationStack(PatternNode ownNode, TreePatternQueryEvaluationStack parentStack) {
		this.ownNode = ownNode;
		this.parentStack = parentStack;
	}

	public List<TreePatternQueryEvaluationStack> getDescendantStacks() {
		return decendantStacks;
	}

	public void pushMatch(Match m) {
		matches.push(m);
	}

	public Match top() {
		return matches.peek();
	}

	public Match pop() {
		return matches.pop();
	}

	public PatternNode getPatternNode() {
		return ownNode;
	}

	public TreePatternQueryEvaluationStack getParentStack() {
		return parentStack;
	}
}
