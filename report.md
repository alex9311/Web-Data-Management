##Web Data Management Assignment 1 Writeup
Alex Simes  and Peter van Buul

###Introduction
We choose to do the exercises from Chapter 5 of the textbook. This chapter included two sets of questions to practice xQuery and xPath queries. Our solutions to these questions can be found in this repo [here](xpath_xquery_questions/queries.md).

Below, we will detail our work in solving the three larger assignments in this chapter. For each, we will discuss our process and final structure.


###Movie Database Project
This project was our first experience with using xQuery and xPath in practice. We decided to use the REST API to query our movie collection in eXist-db for this project. We found that quickly being able to test queries directly in the browser sped up our development. We used PHP to handle POST/GET requests to connect our query results to the static parts of our web application. Our query results were formatted in a way such that they could easily be dropped into a web page body.

The requirements of this project were three-fold:
  
1. There must be a form that allows the user to search for movies based on (fragment of) the title, list of genres, director and actors names, years, and key-words that can be matched against the summary of the movie.
2. When the user submits the form, the application retrieves the relevant movies from the XML repository, and displays the list of these movies in XHTML.
3. in the previous list, each movie title should be a link that allows to display the full description of the movie.

#####Including the User Query
To allow the user to run their own search query, we built an HTML form with all of the needed fields. We had fun creating an xQuery query to fill the form's genre dropdown box with a list of genres found in the collection. You can see that code [here](apps/movies/queries/get_genre_list.php). Our query returns the unique list of genres wrapped in `<select>` and `<option>` tags so it can easily be dropped into the form.

Upon submit, the form data is sent through a POST request to a [PHP script](apps/movies/list_movies.php). This script calls a function which builds an xQuery expression based on the parameters. We will discuss this function in the section below.

##### Displaying the List of Movies in XHTML
As mentioned in the previous section, the user search parameters are passed to [a function](apps/movies/queries/get_movie_list.php) through a POST request. This function contructs the query in two parts. First, in the build_movie_query() function, we take all the search parameters and create an xPath query to show only relevant movies. For example, if the user selects a genre "Drama" and an actor "Johansson" the following xPath statement is generated:

`/movies/movie[genre = "Crime"and (contains(actor/last_name,"Johansson") or contains(actor/first_name,"Johansson"))]`

This xPath query is used in an xQuery expression which formats the relevant movies into something we can pop into our small static html wrapper. The wrapper includes things like the DOCTYPE declaration, includes, and `<html>`,`<head>`, and `<body>` tags. This xPath expression can be seen in the get_xquery() function, in [the same file](apps/movies/queries/get_movie_list.php) as linked above.

We ensured that the file output page was XHTML standard approved by running it through [W3 markup validation service](https://validator.w3.org/).

##### Showing Full Description of the Movie On Click
We used a small Javascript function that toggles the html `style="display:none"` attribute. We added the attribute and the onclick that calls the javascript function in our xQuery query. One issue we ran into was that we were unable to add an `href="#"` to make the title clickable in xQuery, so we formatted that with css afterwards. 

Below is a screenshot of our application's query result page with two movies, one of which has been expanded out by the user clicking the title.
![movie list screenshot](resources/movie_list_screenshot.png)

###Shakespeare Opera Omnia Project 

###MusicXML Project
