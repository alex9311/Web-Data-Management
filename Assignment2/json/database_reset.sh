curl -X DELETE http://admin:admin@127.0.0.1:5984/books
curl -X PUT http://admin:admin@127.0.0.1:5984/books

tr -d '\n\t' < views/all.json > temp.json
curl -X PUT http://admin:admin@127.0.0.1:5984/books/_design/app --data-binary @temp.json

rm temp.json

for i in {1..1560}
do
curl -X POST http://127.0.0.1:5984/books -d @books-json/book$i.json -H "Content-Type: application/json"
done
