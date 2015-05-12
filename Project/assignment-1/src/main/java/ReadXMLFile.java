import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

public class ReadXMLFile {

	public static void main(String argv[]) {

		try {

			SAXParserFactory factory = SAXParserFactory.newInstance();
			SAXParser saxParser = factory.newSAXParser();

			StackHandler stackHandler = new StackHandler();

			saxParser.parse("c:\\file.xml", stackHandler);

		} catch (Exception e) {
			e.printStackTrace();
		}

	}

}