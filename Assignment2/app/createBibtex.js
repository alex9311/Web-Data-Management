function createBibtex(book){
	var bibtex_string = "@"+book.type+"{"+book._id+"\n";
	bibtex_string = bibtex_string.concat("\tauthor: {",book.authors.join(" and "),"}\n");
	bibtex_string = bibtex_string.concat("\ttitle: {",book.title,"}\n");
	bibtex_string = bibtex_string.concat("\tpublisher: {",book.publisher,"}\n");
	bibtex_string = bibtex_string.concat("\tyear: {",book.year,"}\n");
	bibtex_string = bibtex_string.concat("}");
	alert(bibtex_string);
}
