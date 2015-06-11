useful webpage: http://inchoo.net/dev-talk/couchdb-for-php-developers-crud/

titles view function: title
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

actors view function: actor
```
function(doc) {
  for each(author in doc.authors) {
    emit(author.trim(), doc);
      words = author.replace(/[!.,;]+/g,"").split(" ")
      for each (word in words) {
        if(word!="-"&&word!=""&&word!=":"&&word!="."){
        emit(word,doc);
      }
    }
  }
}
```
