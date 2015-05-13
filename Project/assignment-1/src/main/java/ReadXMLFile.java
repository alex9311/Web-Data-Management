import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import web_data_management.assignment_1.PatternNode;
import web_data_management.assignment_1.StackEval;
import web_data_management.assignment_1.TreePatternQueryEvaluationStack;
import web_data_management.assignment_1.TreePattern;

public class ReadXMLFile {

	public static void main(String args[]) {
		try {

			SAXParserFactory factory = SAXParserFactory.newInstance();
			SAXParser saxParser = factory.newSAXParser();

			TreePatternQueryEvaluationStack rootStack = new TreePatternQueryEvaluationStack(new PatternNode(), null);
			TreePattern query = new TreePattern();
			StackEval stackHandler = new StackEval(query, rootStack);

			saxParser.parse("D:\\Users\\Repositories\\Web-Data-Management\\Project\\assignment-1\\xml_doc_d.xml", stackHandler);

		} catch (Exception e) {
			e.printStackTrace();
		}

	}

}