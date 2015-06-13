
<script src="http://admin:admin@127.0.0.1:5984/_utils/script/json2.js"></script>
<script src="http://admin:admin@127.0.0.1:5984/_utils/script/jquery.js?1.2.6"></script>
<script src="http://admin:admin@127.0.0.1:5984/_utils/script/jquery.couch.js?0.8.0"></script>
<script src="http://admin:admin@127.0.0.1:5984/_utils/script/jquery.form.js?0.9.0"></script>

<form id="upload" method="post"
      action="http://admin:admin@127.0.0.1:5984/books/<?php echo $_GET["id"];?>"
      enctype="multipart/form-data">
    <input type="hidden" id="revision" type="text" name="_rev" value="<?php echo $_GET["rev"];?>"/>
    <input id="attachment" type="file" name="_attachments"/><br/>
    <br/>
    <input type="submit"/>
</form>

