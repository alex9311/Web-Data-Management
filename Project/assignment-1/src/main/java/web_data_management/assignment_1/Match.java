package web_data_management.assignment_1;

import java.util.List;
import java.util.Map;

public class Match {
	
	private int start;
	private State state;
	private Match parent;
	private Map<PatternNode, List<Match>> children;
	private TreePatternQueryEvaluationStack stack;
	
	public Match(int currentPre, Match parent, TreePatternQueryEvaluationStack tpeStack) {
		setStart(currentPre);
		this.setParent(parent);
		setStack(tpeStack);
	}

	public State getState() {
		return state;
	}

	public void setState(State state) {
		this.state = state;
	}

	public int getStart() {
		return start;
	}

	public void setStart(int start) {
		this.start = start;
	}

	public Match getParent() {
		return parent;
	}

	public void setParent(Match parent) {
		this.parent = parent;
	}

	public Map<PatternNode, List<Match>> getChildren() {
		return children;
	}

	public void setChildren(Map<PatternNode, List<Match>> children) {
		this.children = children;
	}

	public TreePatternQueryEvaluationStack getStack() {
		return stack;
	}

	public void setStack(TreePatternQueryEvaluationStack stack) {
		this.stack = stack;
	}
}