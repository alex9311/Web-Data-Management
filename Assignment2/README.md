useful webpage: http://inchoo.net/dev-talk/couchdb-for-php-developers-crud/

titles view function
```
function(doc) {
  emit(doc.title.trim(), doc);
	words = doc.title.replace(/[!.,;]+/g,"").toLowerCase().split(" ")
	for each (word in words) {
		if(word!="-"&&word!=""&&word!=":"&&word!="."){
		emit(word,doc);}
	}
}
```
