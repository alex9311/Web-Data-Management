import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class StackHandler extends DefaultHandler {

	public void startElement(String uri, String localName, String qName, Attributes attributes) throws SAXException {
		System.out.println("Start Element :" + qName);
	}

	public void endElement(String uri, String localName, String qName) throws SAXException {
		System.out.println("End Element :" + qName);
	}
}
