function speakerToggle(speaker_no){
	var e = document.getElementById("speaker_list"+speaker_no);
	if(e.style.display == "block")
		e.style.display = "none";
	else
		e.style.display = "block";
}
