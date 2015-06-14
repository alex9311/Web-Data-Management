curl -X DELETE http://admin:admin@127.0.0.1:5984/books_app
curl -X PUT http://admin:admin@127.0.0.1:5984/books_app

rev="$(curl -X PUT http://127.0.0.1:5984/books_app/handle_upload -d '{"id":"handle_upload"}' | rev | cut -c 3- | rev | cut -c 40-)"

curl -X PUT http://127.0.0.1:5984/books_app/handle_upload/handle_upload.html?rev=$rev -d @config_files/handle_attachment.html   -H "Content-Type: text"

