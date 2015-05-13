package web_data_management.assignment_1;

import java.util.List;
import java.util.Stack;

import org.xml.sax.helpers.DefaultHandler;
import org.xml.sax.Attributes;
import org.xml.sax.SAXException;

public class StackEval extends DefaultHandler {

	private final TreePattern query;
	private final TreePatternQueryEvaluationStack rootStack; // stack for the root of q
	
	// pre numbers for all elements having started but not ended yet:
	private final Stack <Integer> preOfOpenNodes = new Stack<Integer>();

	// pre number of the last element which has started:
	private int currentPre = 0;
	
	public StackEval(TreePattern query, TreePatternQueryEvaluationStack rootStack) {
		this.query = query;
		this.rootStack = rootStack;
	}
	
	public void startElement(String uri, String localName, String qName, Attributes attributes) throws SAXException {
		List<TreePatternQueryEvaluationStack> descendantStacks = rootStack.getDescendantStacks();
		for (TreePatternQueryEvaluationStack tpeStack : descendantStacks) {
			if(qName.equals(tpeStack.getPatternNode().getName()) && 
					tpeStack.getParentStack().top().getState() == State.OPEN) {
				Match m = new Match(currentPre, tpeStack.getParentStack().top(), tpeStack);
				// create a match satisfying the ancestor conditions
				// of query node s.p
				tpeStack.pushMatch(m);
				preOfOpenNodes.push(currentPre);
			}
			currentPre ++;
		}

		int attributeListLength = attributes.getLength();
		for (int i = 0; i < attributeListLength; i++) {
			// similarly look for query nodes possibly matched
			// by the attributes of the currently started element
			for (TreePatternQueryEvaluationStack decendantStack : descendantStacks) {
				if (attributes.getLocalName(i).equals(decendantStack.getPatternNode().getName()) &&
						decendantStack.getParentStack().top().getState() == State.OPEN) {
					Match ma = new Match(currentPre, decendantStack.getParentStack().top(), decendantStack);
					decendantStack.pushMatch(ma);
				}
			}
			currentPre ++;
		}
	}
	
	public void endElement(String uri, String localName, String qName) throws SAXException {
		// we need to find out if the element ending now corresponded
		// to matches in some stacks
		// first, get the pre number of the element that ends now:
		if (!preOfOpenNodes.isEmpty()) {
			int preOflastOpen = preOfOpenNodes.pop();
			// now look for Match objects having this pre number:
			List<TreePatternQueryEvaluationStack> descendantStacks = rootStack.getDescendantStacks();
			for (TreePatternQueryEvaluationStack decendantStack : descendantStacks) {
				if (decendantStack.getPatternNode().getName().equals(qName) &&
						decendantStack.top().getState() == State.OPEN && 
						decendantStack.top().getStart() == preOflastOpen) {
					// all descendants of this Match have been traversed by now.
					Match m = decendantStack.pop();
					// check if m has child matches for all children
					// of its pattern node
					for (PatternNode pChild : decendantStack.getPatternNode().getChildren()) {
						// pChild is a child of the query node for which m was created
						if (m.getChildren().get(pChild) == null) {
							// m lacks a child Match for the pattern node pChild
							// we remove m from its Stack, detach it from its parent etc.
							remove(m, decendantStack);
						}
					}
					//			m.close();
				}
			}
		}
	}

	private void remove(Match m, TreePatternQueryEvaluationStack tpeStack) {
		// TODO Auto-generated method stub
	}
}