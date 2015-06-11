for i in {1..1560}
do
curl -X POST http://127.0.0.1:5984/books -d @book$i.json -H "Content-Type: application/json"
echo $i
done
