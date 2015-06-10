for i in {1..1560}
do
curl -X POST $COUCHDB/books -d @book$i.json -H "Content-Type: application/json"
echo $i
done
