package web_data_management.assignment_1;

import java.util.List;
import java.util.Stack;

import org.xml.sax.helpers.DefaultHandler;
import org.xml.sax.Attributes;

public class StackEval extends DefaultHandler {

	TreePattern q;
	TPEStack rootStack; // stack for the root of q
	// pre number of the last element which has started:
	int currentPre = 0;
	// pre numbers for all elements having started but not ended yet:
	Stack <Integer> preOfOpenNodes;
	
	public void startElement(String localName, Attributes attributes) {
		List<TPEStack> descendantStacks = rootStack.getDescendantStacks();
		for (TPEStack tpeStack : descendantStacks) {
			if(localName.equals(tpeStack.getPatternNode().getName()) && 
					tpeStack.spar.top().getState() == State.OPEN) {
				Match m = new Match(currentPre, tpeStack.spar.top(), tpeStack);
				// create a match satisfying the ancestor conditions
				// of query node s.p
				tpeStack.push(m);
				preOfOpenNodes.push(currentPre);
			}
			currentPre ++;
		}

		int attributeListLength = attributes.getLength();
		for (int i = 0; i < attributeListLength; i++) {
			// similarly look for query nodes possibly matched
			// by the attributes of the currently started element
			for (TPEStack decendantStack : descendantStacks) {
				if (attributes.getLocalName(i).equals(decendantStack.getPatternNode().getName()) && decendantStack.spar.top().getState() == State.OPEN) {
					Match ma = new Match(currentPre, decendantStack.spar.top(), decendantStack);
					decendantStack.push(ma);
				}
			}
			currentPre ++;
		}
	}
	
	public void endElement(String localName) {
		// we need to find out if the element ending now corresponded
		// to matches in some stacks
		// first, get the pre number of the element that ends now:
		int preOflastOpen = preOfOpenNodes.pop();
		// now look for Match objects having this pre number:
		List<TPEStack> descendantStacks = rootStack.getDescendantStacks();
		for (TPEStack decendantStack : descendantStacks) {
			if (decendantStack.getPatternNode().getName().equals(localName) &&
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

	private void remove(Match m, TPEStack tpeStack) {
		// TODO Auto-generated method stub
	}
}