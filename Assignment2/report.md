##Web Data Management Assignment 2 Writeup
Alex Simes (4415299)  and Peter van Buul (1512269)

####Introduction
For this assignment, we built a web application around a bibleographical dataset stored in CouchDB. This was our first experience working with CouchDB and we learned a lot. To complete the application, we built a straigtforward web application using PHP to connect the front end to CouchDB through curl requests. We also wrote an extensive shell script which fully configures our CouchDB setup and populates it with the documents (both data and views).

####Building the Views
Before starting on application development, we built the views we would need. Since the user would query by any combination of Title, Author, Publisher, or Year, we would need to use multi-key views. Our first plan was to use a single view which contained all 4 fields as keys and design our query in a clever way to essentially pass wildcard values to the fields left blank by the user. We discovered that this sort of functionality is in fact not supported by CouchDB, which left us with the option of creating 16 different views, one for each possible combination of search criteria the user might want to use. 

This task ended up not taking as long as we anticipated, as there was a lot of repeated code. One issue we ran into was how to quickly reset or transport our database with the views and how to leverage Git so we could pass our view code back and forth. Our solution was to store all our view code in a [json document](https://github.com/alex9311/Web-Data-Management/blob/master/Assignment2/json/config_files/all.json) which we included in a [reset script](https://github.com/alex9311/Web-Data-Management/blob/master/Assignment2/json/database_reset.sh) for our database.  We ran into issues with having tabs and newlines inside the fields of our json file, so we ended up having to squish the files into single lines before passing them to CouchDB.

```
tr -d '\n\t' < config_files/all.json > temp.json
curl -X PUT http://admin:admin@127.0.0.1:5984/books/_design/app --data-binary @temp.json
rm temp.json
```

Having this many views made CouchDB take a few minutes to sort itself out after a full reset, since it had to repopulate all the views. We'll discuss the full reset script and how we queried the views later on. 


####Meeting Application Requirements 
######Searching the Bibleographic CollectionThe first thing we tackled was searching through the bibleographic database. We needed to allow searching by any combination of four fields. We provide the user with the search form shown below, in which he can fill in however many fields he likes.<img src="resources/report_images/search_form.png" style="width:4.5in"></img>
Upon hitting submit, the form contents are sent off to a [PHP script](https://github.com/alex9311/Web-Data-Management/blob/master/Assignment2/app/handle_search.php). This script starts by detecting which fields the user filled in. From this knowledge, it knows which of our premade views to query and with what keys. This query is formatted and sent off in our PHP code. 
Upon being returned, we needed to do a small massaging step in our data. The way our views are structured, we sometimes had duplicate entries returned. We converted the return JSON to a PHP associative array to squash all duplicates into single rows. After this step, we print the result in an HTML table as shown below. 
<img src="resources/report_images/search_result.png" style="width:4.5in"></img>


######Create/Update/Delete Bibleographical Entries
Next, we needed to create a way to add/update/remove entries. You'll notice in the screenshot above that we have links to edit and delete the entries in the search results. The editing link brings the user to a [prepopulated form](https://github.com/alex9311/Web-Data-Management/blob/master/Assignment2/app/edit_form.php) where they can edit values and submit the changes to CouchDB. The delete link simply passes the document id to a [PHP script](https://github.com/alex9311/Web-Data-Management/blob/master/Assignment2/app/handle_delete.php) which deletes the document using, again, a curl request. 


To add new entries, we used an [HTML form](https://github.com/alex9311/Web-Data-Management/blob/master/Assignment2/app/add_form.php). This form submits to a [PHP script](https://github.com/alex9311/Web-Data-Management/blob/master/Assignment2/app/handle_add.php) to process the new data. We used curl requests to query CouchDB at `http://127.0.0.1:5984/_uuids` for a unique ID rather than generate our own. 

######Producing Bibtex Entries
You'll also notice that the titles are links in our search results view. The title can be clicked to provide the user with a Bibtex entry of the document. This Bibtex entry is generated with a short [javascript function](https://github.com/alex9311/Web-Data-Management/blob/master/Assignment2/app/createBibtex.js) and shown to the user in an alert box, as shown below.
<img src="resources/report_images/bibtex.png" style="width:4.5in"></img>

######Uploading PDFs as Attachments
Creating an interface for the user to upload PDFs initially gave us some problems. We wanted a way to avoid the server permission issues we struggled with in the first assignment and to simply pass the attachment directly to CouchDB. We came up with an interesting way to do this. We created a [PHP page](https://github.com/alex9311/Web-Data-Management/blob/master/Assignment2/json/config_files/handle_attachment.html) which we loaded into CouchDB as an attachment. This PHP page is a file upload form and looks for GET params for an ID and revision number. Once the user selects a file and submits, the form POSTS to the correct document in our books database with the form data. This solution is simple and clean, especially considering we add the upload form page to our CouchDB setup in the reset script.

An interesting issue we ran into here was the names of the GET parameters we passed to the form document. CouchDB seemed to get confused if we named them `id` and `rev`, so we went with `doc_id` and `doc_rev` instead. 

######Replication
Now we can finally discuss the [reset script](https://github.com/alex9311/Web-Data-Management/blob/master/Assignment2/json/database_reset.sh) we've mentioned so many times above. Using this script, both of us could quickly have our CouchDB databases in the exact same state.

The script starts by dropping and creating our three databases: books, books2, and books_app. The books_app database holds our PDF upload form, discussed above. The books and books2 databases are set up in a master-master configuration. This means they always replicate to each other.

From this point on, we only need add to books and it automatically replicates onto books2. Next, we add all of our views. This is done by removing the tabs and newlines CouchDB was complaining about and doing a PUT to `http://admin:admin@127.0.0.1:5984/books/_design/app` with the squished file. 

Next, we add the PDF upload form to the books_app database. This takes two steps. First we create the handle_upload document, then add the attachment PHP page to it. The reason this was a bit tricky was that when adding an attachment to a document, CouchDB requires the revision number. With some hacky shell scripting we were able to pull the revision number of the handle_upload doc from the curl response to the insertion. 

And finally, we unzip the books-json package, insert all books, and clean up the json files afterwards. This complete process leaves us a CouchDB setup that is completely ready for our application!
######Using the Log to see ModificationsThis has not been completed yet. 