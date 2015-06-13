#first delete both databases and create new, empty versions
curl -X DELETE http://admin:admin@127.0.0.1:5984/books
curl -X DELETE http://admin:admin@127.0.0.1:5984/books2
curl -X PUT http://admin:admin@127.0.0.1:5984/books
curl -X PUT http://admin:admin@127.0.0.1:5984/books2

#set up each to replicate onto the other
curl -X POST http://admin:admin@127.0.0.1:5984/_replicate  -d '{"source": "books",  "target": "books2", "continuous": true}' -H "Content-Type: application/json"
curl -X POST http://admin:admin@127.0.0.1:5984/_replicate  -d '{"source": "books2",  "target": "books", "continuous": true}' -H "Content-Type: application/json"

#fill in the views, after removing new lines and tabs from views/all.json
#all views are added to books db, to be replicated in books2 automatically
tr -d '\n\t' < views/all.json > temp.json
curl -X PUT http://admin:admin@127.0.0.1:5984/books/_design/app --data-binary @temp.json
rm temp.json

#add all books to the books db, these will automatically be replicated in books2
for i in {1..1560}
do
curl -X POST http://127.0.0.1:5984/books -d @books-json/book$i.json -H "Content-Type: application/json"
done