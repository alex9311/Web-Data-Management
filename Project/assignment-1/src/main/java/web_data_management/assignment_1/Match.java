package web_data_management.assignment_1;

import java.util.List;
import java.util.Map;

class Match {
	
	int pre;
	State state;
	Match parent;
	Map<PatternNode, List<Match>> children;
	TPEStack stack;
	
	public Match(int currentPre, Match parent, TPEStack tpeStack) {
		pre = currentPre;
		this.parent = parent;
		stack = tpeStack;
	}

	int getStatus() {
		return 1;
	}
}