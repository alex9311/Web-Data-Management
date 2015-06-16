xquery version "1.0-ml";

let $result := xdmp:document-get("http://feeds.bbci.co.uk/news/world/rss.xml?edition=uk",
		<options xmlns="xdmp:document-get">
			<format>text</format>
		</options>
	)
	
return $result