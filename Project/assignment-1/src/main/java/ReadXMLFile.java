import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import org.apache.commons.lang3.StringUtils;

public class ReadXMLFile {

	public static void main(String args[]) {
		try {

			SAXParserFactory factory = SAXParserFactory.newInstance();
			SAXParser saxParser = factory.newSAXParser();

			Node queryResultRootNode = new Node("root", null);
			TreeQuery query = new TreeQuery("name/*");
			StackHandler stackHandler = new StackHandler(queryResultRootNode, query);

			saxParser.parse("D:\\Users\\Repositories\\Web-Data-Management\\Project\\assignment-1\\xml_doc_d.xml", stackHandler);
			
			for (Node child : queryResultRootNode.getDecendents()) {
				System.out.println(child.getName());
				if (StringUtils.isNotBlank(child.getContent())) {
					System.out.println("    " + child.getContent());
				}
			}

		} catch (Exception e) {
			e.printStackTrace();
		}

	}

}