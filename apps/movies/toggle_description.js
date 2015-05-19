function summaryToggle(movie_id,summary){
	var e = document.getElementById("movie"+movie_id+"_description");
	if(e.style.display == "block")
		e.style.display = "none";
	else
		e.style.display = "block";
}
